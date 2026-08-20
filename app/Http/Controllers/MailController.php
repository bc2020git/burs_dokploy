<?php

namespace App\Http\Controllers;

use App\Models\MailSetting;
use App\Models\ActiveAnswer;
use App\Models\MessageTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index()
    {
        session(['sidebar' => 31]);
        $mailSettings = MailSetting::all();
        return view('panel.settings.emailsetting.index', compact('mailSettings'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:smtp,useinbox,sendgrid',
            'host' => 'required_if:type,smtp',
            'port' => 'required_if:type,smtp|numeric',
            'username' => 'required_if:type,smtp',
            'password' => 'required_if:type,smtp',
            'encryption' => 'required_if:type,smtp',
            'from_address' => 'required|email',
            'from_name' => 'required',
            'api_key' => 'required_if:type,sendgrid',
            'useinbox_api_key' => 'required_if:type,useinbox',
        ]);

        MailSetting::query()->update(['is_active' => false]);

        MailSetting::updateOrCreate(
            ['type' => $validatedData['type']],
            array_merge($validatedData, ['is_active' => true])
        );

        return redirect()->back()->with('success', 'Mail ayarları güncellendi.');
    }

    public function sendMailOtp($to, $subject, $view, $data, ?string $timelineTcNo = null)
    {
        // Template için gerekli verileri hazırla
        $templateData = [
            'name' => $data['name'],
            'surname' => $data['surname'],
            'code' => $data['code'],
        ];

        if (rtrim(env('APP_URL'), '/') === 'https://bursmodulu.host') {
            try {
                $html = view($view, $templateData)->render();
                \Log::info("Mail (OTP) logged to {$to} with subject '{$subject}':\n" . $html);
            } catch (\Exception $e) {
                \Log::error("Mail (OTP) render error: " . $e->getMessage());
                \Log::info("Mail (OTP) logged to {$to} with subject '{$subject}'. Data: " . json_encode($templateData));
            }

            $tc = $timelineTcNo ?? ($data['tc_no'] ?? null);
            if (is_string($tc) && $tc !== '') {
                aday_timeline_mail_gonderildi($tc, $subject, 'OTP doğrulama');
            }

            return true;
        }

        // Mail ayarlarını kontrol et
        $activeSetting = MailSetting::where('is_active', true)->first();

        if (!$activeSetting) {
            throw new \Exception('Aktif mail ayarı bulunamadı.');
        }

        $this->setMailConfig($activeSetting);

        // Blade template ile mail gönder - dinamik verileri template'e gönder
        Mail::send($view, $templateData, function ($message) use ($to, $subject, $activeSetting) {
            $message->to($to)
                ->subject($subject)
                ->from($activeSetting->from_address, $activeSetting->from_name);
        });

        $tc = $timelineTcNo ?? ($data['tc_no'] ?? null);
        if (is_string($tc) && $tc !== '') {
            aday_timeline_mail_gonderildi($tc, $subject, 'OTP doğrulama');
        }

        return true;
    }

    public function sendMailWithBlade($to, $subject, $view, $data, ?string $timelineTcNo = null)
    {
        if (rtrim(env('APP_URL'), '/') === 'https://bursmodulu.host') {
            try {
                $html = view($view, $data)->render();
                \Log::info("Mail (Blade) logged to {$to} with subject '{$subject}':\n" . $html);
            } catch (\Exception $e) {
                \Log::error("Mail (Blade) render error: " . $e->getMessage());
                \Log::info("Mail (Blade) logged to {$to} with subject '{$subject}'. Data: " . json_encode($data));
            }

            $tc = $timelineTcNo ?? (is_array($data) ? ($data['tc_no'] ?? null) : null);
            if (is_string($tc) && $tc !== '') {
                aday_timeline_mail_gonderildi($tc, $subject);
            }
            return;
        }

        $activeSetting = MailSetting::where('is_active', true)->first();

        if (!$activeSetting) {
            throw new \Exception('Aktif mail ayarı bulunamadı.');
        }

        $this->setMailConfig($activeSetting);

        Mail::send($view, $data, function ($message) use ($to, $subject, $activeSetting) {
            $message->to($to)
                ->subject($subject)
                ->from($activeSetting->from_address, $activeSetting->from_name);
        });

        $tc = $timelineTcNo ?? (is_array($data) ? ($data['tc_no'] ?? null) : null);
        if (is_string($tc) && $tc !== '') {
            aday_timeline_mail_gonderildi($tc, $subject);
        }
    }

    public function sendMail($subject, $to, $view)
    {
        // Template içeriğini al
        $content = $view;

        if (rtrim(env('APP_URL'), '/') === 'https://bursmodulu.host') {
            try {
                $html = view('mailtemplates.template-mail', ['content' => $content])->render();
                \Log::info("Mail logged to {$to} with subject '{$subject}':\n" . $html);
            } catch (\Exception $e) {
                \Log::error("Mail render error: " . $e->getMessage());
                \Log::info("Mail logged to {$to} with subject '{$subject}'. Content: " . $content);
            }

            return true;
        }

        // Mail ayarlarını kontrol et
        $activeSetting = MailSetting::where('is_active', true)->first();

        if (!$activeSetting) {
            throw new \Exception('Aktif mail ayarı bulunamadı.');
        }

        $this->setMailConfig($activeSetting);

        // Blade template ile mail gönder
        Mail::send('mailtemplates.template-mail', ['content' => $content], function ($message) use ($to, $subject, $activeSetting) {
            $message->to($to)
                ->subject($subject)
                ->from($activeSetting->from_address, $activeSetting->from_name);
        });

        return true;
    }

    /**
     * MessageTemplate kullanarak mail gönderir
     *
     * @param string $slug Template slug'ı
     * @param string $to Alıcı email adresi
     * @param string $subject Mail konusu
     * @param array $parameters Template parametreleri
     * @param  string|null  $timelineTcNo  Alıcı için timeline (tc_no) — verilirse gönderim kaydı tutulur
     * @return bool
     * @throws \Exception
     */
    public function sendTemplateEmail($slug, $to, $subject, $parameters = [], ?string $timelineTcNo = null)
    {
        // Template'i slug'a göre bul
        $template = MessageTemplate::where('slug', $slug)->first();

        if (!$template) {
            throw new \Exception("'{$slug}' slug'ına sahip template bulunamadı.");
        }

        // Template içeriğini al
        $content = $template->content;

        // Parametreleri değiştir
        if (!empty($parameters) && is_array($parameters)) {
            foreach ($parameters as $key => $value) {
                // _parametre_ formatındaki metinleri değiştir
                $placeholder = '_' . $key . '_';
                $content = str_replace($placeholder, $value, $content);
            }
        }

        if (rtrim(env('APP_URL'), '/') === 'https://bursmodulu.host') {
            try {
                $html = view('mailtemplates.template-mail', ['content' => $content])->render();
                \Log::info("Mail (Template: {$slug}) logged to {$to} with subject '{$subject}':\n" . $html);
            } catch (\Exception $e) {
                \Log::error("Mail (Template) render error: " . $e->getMessage());
                \Log::info("Mail (Template: {$slug}) logged to {$to} with subject '{$subject}'. Content: " . $content);
            }

            $tc = $timelineTcNo ?? ($parameters['tc_no'] ?? null);
            if (is_string($tc) && $tc !== '') {
                aday_timeline_mail_gonderildi($tc, $subject, 'Şablon: ' . $slug);
            }

            return true;
        }

        // Mail ayarlarını kontrol et
        $activeSetting = MailSetting::where('is_active', true)->first();

        if (!$activeSetting) {
            throw new \Exception('Aktif mail ayarı bulunamadı.');
        }

        $this->setMailConfig($activeSetting);

        // Blade template ile mail gönder
        Mail::send('mailtemplates.template-mail', ['content' => $content], function ($message) use ($to, $subject, $activeSetting) {
            $message->to($to)
                ->subject($subject)
                ->from($activeSetting->from_address, $activeSetting->from_name);
        });

        $tc = $timelineTcNo ?? ($parameters['tc_no'] ?? null);
        if (is_string($tc) && $tc !== '') {
            aday_timeline_mail_gonderildi($tc, $subject, 'Şablon: ' . $slug);
        }

        return true;
    }

    public function sendBirthdayMessages(Request $request)
    {
        $providedToken = (string) $request->query('token', '');
        $expectedToken = (string) env('CRON_BIRTHDAY_TOKEN', '');
        $force = (string) $request->query('force', '0') === '1';

        if ($expectedToken === '' || !hash_equals($expectedToken, $providedToken)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $todayDayMonthDot = Carbon::now()->format('d.m'); // "30.03"
        $todayDayMonthDash = Carbon::now()->format('d-m'); // "30-03"
        $todayKey = Carbon::now()->format('Y-m-d');

        $candidates = ActiveAnswer::query()
            ->where('status', 3)
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->whereNotNull('b_dob')
            ->where('b_dob', '!=', '')
            ->where(function ($q) use ($todayDayMonthDot, $todayDayMonthDash) {
                $q->whereRaw('LEFT(b_dob, 5) = ?', [$todayDayMonthDot])
                    ->orWhereRaw('LEFT(b_dob, 5) = ?', [$todayDayMonthDash]);
            })
            ->get(['id', 'tc_no', 'name', 'surname', 'email', 'b_dob']);

        $slug = 'dogum-gunu-mesaji';
        $subject = 'Doğum Gününüz Kutlu Olsun';

        $sent = 0;
        $skippedDuplicate = 0;
        $failed = 0;
        $failures = [];

        foreach ($candidates as $row) {
            $dedupeKey = "cron:birthday_mail:{$todayKey}:active_answer:{$row->id}";

            if (!$force && Cache::has($dedupeKey)) {
                $skippedDuplicate++;
                continue;
            }

            try {
                $parameters = [
                    'name' => (string) $row->name,
                    'surname' => (string) $row->surname,
                ];

                $ok = $this->sendTemplateEmail($slug, (string) $row->email, $subject, $parameters);

                if ($ok) {
                    Cache::put($dedupeKey, true, Carbon::now()->addDays(2));
                    $sent++;
                    aday_timeline_log(
                        (string) $row->tc_no,
                        'E-posta',
                        'Doğum günü mesajı',
                        sprintf('Otomatik gönderildi — Şablon: %s — Konu: %s — İşlem: sistem (cron görevi)', $slug, $subject)
                    );
                } else {
                    $failed++;
                    $failures[] = ['id' => $row->id, 'email' => $row->email, 'reason' => 'sendTemplateEmail_returned_false'];
                }
            } catch (\Throwable $e) {
                $failed++;
                $failures[] = ['id' => $row->id, 'email' => $row->email, 'reason' => $e->getMessage()];
                Log::error('cron.birthday_mail_failed', [
                    'active_answer_id' => $row->id,
                    'tc_no' => $row->tc_no,
                    'email' => $row->email,
                    'b_dob' => $row->b_dob,
                    'exception' => $e->getMessage(),
                ]);
            }
        }

        Log::info('cron.birthday_mail_summary', [
            'day_month' => $todayDayMonthDot,
            'candidate_count' => $candidates->count(),
            'sent' => $sent,
            'skipped_duplicate' => $skippedDuplicate,
            'failed' => $failed,
            'slug' => $slug,
            'subject' => $subject,
        ]);

        return response()->json([
            'day_month' => $todayDayMonthDot,
            'candidate_count' => $candidates->count(),
            'sent' => $sent,
            'skipped_duplicate' => $skippedDuplicate,
            'failed' => $failed,
            'failures' => $failures,
        ]);
    }

    private function setMailConfig($setting)
    {
        $config = [
            'driver' => $setting->type,
            'host' => $setting->host,
            'port' => $setting->port,
            'encryption' => $setting->encryption,
            'username' => $setting->username,
            'password' => $setting->password,
            'from' => [
                'address' => $setting->from_address,
                'name' => $setting->from_name,
            ],
        ];

        if ($setting->type === 'sendgrid') {
            $config['driver'] = 'smtp';
            $config['host'] = 'smtp.sendgrid.net';
            $config['port'] = 587;
            $config['encryption'] = 'tls';
            $config['username'] = 'apikey';
            $config['password'] = $setting->api_key;
        } elseif ($setting->type === 'useinbox') {
            $config['driver'] = 'smtp';
            $config['host'] = 'smtp.useinbox.com';
            $config['port'] = 587;
            $config['encryption'] = 'tls';
            $config['username'] = $setting->from_address;
            $config['password'] = $setting->useinbox_api_key;
        }

        Config::set('mail', $config);
    }

    public function sendTestMail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        if (rtrim(env('APP_URL'), '/') === 'https://bursmodulu.host') {
            \Log::info("Mail (Test) logged to {$request->test_email}: Bu bir test mailidir.");
            return redirect()->back()->with('success', 'Test maili başarıyla log dosyasına yazıldı.');
        }

        try {
            $activeSetting = MailSetting::where('is_active', true)->firstOrFail();
            $this->setMailConfig($activeSetting);

            Mail::raw('Bu bir test mailidir.', function ($message) use ($request, $activeSetting) {
                $message->to($request->test_email)
                    ->subject('Test Mail')
                    ->from($activeSetting->from_address, $activeSetting->from_name);
            });

            return redirect()->back()->with('success', 'Test maili başarıyla gönderildi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Test maili gönderilirken bir hata oluştu: ' . $e->getMessage());
        }
    }
}
