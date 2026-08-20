<?php

namespace App\Http\Controllers;

use App\Models\Scholar;
use App\Models\SmsSetting;
use App\Models\Member;
use Illuminate\Http\Request;
use Netgsm\Sms\SmsSend;

class SmsController extends Controller
{
    public function __construct()
    {
        session(['sidebar' => 32]);
        $this->vFolder='panel.settings.smssetting';
    }
    public function index(Request $request)
    {
        // SMS ayarlarını al
        $smsSettings = SmsSetting::where('is_active', true)->first();
        $smsBalance = $smsSettings ? $smsSettings->balance : 0;

        return view('panel.screate-message.send-sms', compact('smsBalance'));
    }

    public function  getSmsSettings(){
        session(['sidebar' => 32]);
        $smsSettings = SmsSetting::where('provider', 'netgsm')
                                ->where('is_active', true)
                                ->first();
        if (!$smsSettings) {
            $smsSettings = new SmsSetting([
                'provider' => 'netgsm',
                'is_active' => true,
                'balance' => 0
            ]);
        }

        return view($this->vFolder.'.index', compact('smsSettings'));
    }
    public function sendBulkSms(Request $request)
    {
        try {
            $memberIds = json_decode($request->member_ids);
            $message = $request->message;

            $members = Member::whereIn('id', $memberIds)
                            ->whereNotNull('cep_telefonu')
                            ->pluck('cep_telefonu')
                            ->toArray();

            if (empty($members)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seçili üyelerin telefon numarası bulunamadı.'
                ]);
            }

            $response = $this->sendSmsWithCurl($members, $message);

            return response()->json([
                'success' => $response['status'],
                'message' => $response['message']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }

    public function testSms(Request $request)
    {
        try {
            $request->validate([
                'test_phone' => 'required|string'
            ]);

            $phoneNumber = ltrim($request->test_phone, '0');
            $message = "Bu bir test SMS'idir. SMS ayarlarınız başarıyla çalışmaktadır.";

            $response = $this->sendSmsWithCurl($phoneNumber, $message);
            if ($response['status']) {
                return redirect()->back()->with('success', 'Test SMS\'i başarıyla gönderildi.');
            } else {
                return redirect()->back()->with('error', 'SMS gönderilirken bir hata oluştu: ' . $response['message']);
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function updateSettings(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
                'header' => 'required|string',
            ]);

            $smsSetting = SmsSetting::where('provider', 'netgsm')->first();

            if (!$smsSetting) {
                $smsSetting = new SmsSetting();
                $smsSetting->provider = 'netgsm';
                $smsSetting->is_active = true;
            }

            $smsSetting->username = $request->username;
            $smsSetting->password = $request->password;
            $smsSetting->header = $request->header;
            $smsSetting->save();

            return redirect()->back()->with('success', 'SMS ayarları başarıyla güncellendi.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ayarlar güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Telefon numarasından eşleşen bursiyer tc_no (timeline için).
     */
    private function scholarTcByPhone(string $phone): ?string
    {
        $digits = preg_replace('/\D/', '', $phone);
        if (strlen($digits) < 10) {
            return null;
        }
        $tail10 = substr($digits, -10);
        $scholar = Scholar::where('tel_no', 'like', '%'.$tail10.'%')->first();

        return $scholar?->tc_no;
    }

    private function sendSmsWithCurl($phoneNumbers, $message)
    {
        try {
            // SMS ayarlarını al
            $settings = SmsSetting::getNetGsmConfig();

            // Tarih formatlarını hazırla
            $startDate = now()->format('dmYHi');
            $stopDate = now()->addDay()->format('dmYHi');

            // Mesajı ve header'ı encode et

            $header =$settings['header'];
            // Telefon numaralarını formatlı hale getir
            $phones = is_array($phoneNumbers) ? implode(',', $phoneNumbers) : $phoneNumbers;

            // API URL'ini oluştur
            $url = "https://api.netgsm.com.tr/bulkhttppost.asp?" . http_build_query([
                'usercode' => $settings['usercode'],
                'password' => $settings['password'],
                'gsmno' => $phones,
                'message' => $message,
                'msgheader' => $header,
                'startdate' => $startDate,
                'stopdate' => $stopDate,
                'dil' => 'TR'
            ]);

            // cURL isteğini gerçekleştir
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false
            ]);

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($error) {
                throw new \Exception("cURL Error: " . $error);
            }

            // NetGSM yanıt kodlarını kontrol et
            $responseCode = explode(' ', $response)[0];

            return [
                'status' => in_array($responseCode, ['00', '01', '02']),
                'code' => $responseCode,
                'message' => $this->getNetGsmMessage($responseCode)
            ];

        } catch (\Exception $e) {
            return [
                'status' => false,
                'code' => 'ERROR',
                'message' => $e->getMessage()
            ];
        }
    }

    private function getNetGsmMessage($code)
    {
        $messages = [
            '00' => 'Mesaj gönderim başarılı',
            '01' => 'Mesaj gönderim başarılı',
            '02' => 'Mesaj gönderim başarılı',
            '20' => 'Mesaj metni hatalı veya boş',
            '30' => 'Geçersiz kullanıcı adı, şifre veya API hesabınız aktif değil',
            '40' => 'Mesaj başlığı (gönderici adı) hatalı',
            '50' => 'Telefon numarası hatalı',
            '51' => 'Tekrar eden telefon numarası',
            '70' => 'Hatalı parametre format',
            '85' => 'Mükerrer görev',
            'ERROR' => 'Sistem hatası'
        ];

        return $messages[$code] ?? 'Bilinmeyen hata kodu';
    }

    public function sendSmsWithTemplate($phoneNumber, $template, $data, ?string $timelineTcNo = null)
    {
        try {
            // Template'i hazırla
            $message = view($template, $data)->render();

            // HTML taglerini temizle
            $message = strip_tags($message);

            // SMS gönder
            $response = $this->sendSmsWithCurl($phoneNumber, $message);

            if ($response['status']) {
                $tc = $timelineTcNo ?? (is_array($data) ? ($data['tc_no'] ?? null) : null);
                if (! is_string($tc) || $tc === '') {
                    $tc = $this->scholarTcByPhone((string) $phoneNumber);
                }
                if (is_string($tc) && $tc !== '') {
                    aday_timeline_sms_gonderildi($tc, 'Şablon: '.$template);
                }
                \Log::info('SMS başarıyla gönderildi', [
                    'phone' => $phoneNumber,
                    'template' => $template,
                    'data' => $data
                ]);
                return true;
            } else {
                \Log::error('SMS gönderimi başarısız', [
                    'phone' => $phoneNumber,
                    'template' => $template,
                    'data' => $data,
                    'error' => $response['message']
                ]);
                return false;
            }
        } catch (\Exception $e) {
            \Log::error('SMS gönderimi hatası: ' . $e->getMessage(), [
                'phone' => $phoneNumber,
                'template' => $template,
                'data' => $data
            ]);
            return false;
        }
    }

    public function urldenemesms($formattedPhones,$message){
        $settings = SmsSetting::getNetGsmConfig();

            // Tarih formatlarını hazırla
            $startDate = now()->format('dmYHi');
            $stopDate = now()->addDay()->format('dmYHi');

            // Mesajı ve header'ı encode et
            $message = rawurlencode(html_entity_decode($message, ENT_COMPAT, "UTF-8"));
            $header = rawurlencode(html_entity_decode($settings['header'], ENT_COMPAT, "UTF-8"));

            // Telefon numaralarını formatlı hale getir
            $phones = is_array($formattedPhones) ? implode(',', $formattedPhones) : $formattedPhones;

            // API URL'ini oluştur
            $url = "https://api.netgsm.com.tr/bulkhttppost.asp?" . http_build_query([
                'usercode' => $settings['usercode'],
                'password' => $settings['password'],
                'gsmno' => $phones,
                'message' => $message,
                'msgheader' => $header,
                'startdate' => $startDate,
                'stopdate' => $stopDate,
                'dil' => 'TR'
            ]);

            // cURL isteğini gerçekleştir
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false
            ]);

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            if ($error) {
                throw new \Exception("cURL Error: " . $error);
            }
            return $response;

            // NetGSM yanıt kodlarını kontrol et
            $responseCode = explode(' ', $response)[0];

            return [
                'status' => in_array($responseCode, ['00', '01', '02']),
                'code' => $responseCode,
                'message' => $this->getNetGsmMessage($responseCode)
            ];
    }
    public function sendBulkSmsToSelected(Request $request)
    {
        try {
            $phones = $request->phones;
            $message = $request->message;

            if (empty($phones)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Telefon numarası seçilmedi.'
                ]);
            }

            if (empty($message)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mesaj içeriği boş olamaz.'
                ]);
            }

            // Telefon numaralarını formatlayalım
            $formattedPhones = array_map(function($phone) {
                // +90 ile başlıyorsa +90'ı kaldır
                if (str_starts_with($phone, '+90')) {
                    return substr($phone, 3);
                }
                // 0 ile başlıyorsa baştaki 0'ı kaldır
                if (str_starts_with($phone, '0')) {
                    return ltrim($phone, '0');
                }
                // Diğer formatlar için olduğu gibi bırak
                return $phone;
            }, $phones);

            // SMS gönderme işlemi
            $response = $this->sendSmsWithCurl($formattedPhones, $message);

            if ($response['status']) {
                foreach ($formattedPhones as $phone) {
                    $tc = $this->scholarTcByPhone((string) $phone);
                    if ($tc) {
                        aday_timeline_sms_gonderildi($tc, 'Toplu SMS (panel)');
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'SMS başarıyla gönderildi'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'SMS gönderilemedi: ' . $response['message']
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('SMS gönderimi hatası: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage()
            ]);
        }
    }

    public function checkSmsStatus(Request $request)
    {
        try {
            $settings = SmsSetting::getNetGsmConfig();
            $bulkId = $request->bulkId; // URL'den bulk ID alınacak

            $curl = curl_init();

            $xmlData = '<?xml version="1.0"?>
            <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
                         xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                <SOAP-ENV:Body>
                    <ns3:raporV3 xmlns:ns3="http://sms/">
                        <username>'.$settings['usercode'].'</username>
                        <password>'.$settings['password'].'</password>
                        <bulkid>'.$bulkId.'</bulkid>
                        <appkey></appkey>
                    </ns3:raporV3>
                </SOAP-ENV:Body>
            </SOAP-ENV:Envelope>';

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.netgsm.com.tr/sms/report',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $xmlData,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/xml'
                ),
            ));

            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);
            echo $response;
            die();
            if ($error) {
                return response()->json([
                    'success' => false,
                    'message' => 'CURL Hatası: ' . $error
                ]);
            }

            // XML yanıtını parse et
            $xml = simplexml_load_string($response);

            // Yanıt durumlarını kontrol et
            $statusMessages = [
                0 => 'SMS Gönderildi',
                1 => 'SMS İletildi',
                2 => 'Zaman Aşımı',
                3 => 'SMS İletilemedi',
                4 => 'Operatöre İletilemedi',
                11 => 'Operatör Tarafından Kabul Edilmedi',
                12 => 'Gönderim Hatası',
                13 => 'Mükerrer Gönderim',
                100 => 'Sistem Hatası'
            ];

            return response()->json([
                'success' => true,
                'raw_response' => $response,
                'parsed_response' => $xml,
                'status_messages' => $statusMessages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hata oluştu: ' . $e->getMessage()
            ]);
        }
    }
    public function sendSingleSms(Request $request)
    {
        // Gelen telefon numarasını al
        $tel = $request->input('tel');
        $name = $request->input('name');
        $surname = $request->input('surname');

        // Kişiyi oluştur
        $scholar = new \stdClass();
        $scholar->tel_no = $tel;
        $scholar->name = $name;
        $scholar->surname = $surname;

        // Veriyi session'a kaydet
        session()->put('scholars', collect([$scholar]));

        // Yönlendirme URL'si
        $redirectUrl = route('Coklu-Sms');

        // JSON formatında yönlendirme URL'sini döndür
        return response()->json(['redirectUrl' => $redirectUrl]);
    }
}
