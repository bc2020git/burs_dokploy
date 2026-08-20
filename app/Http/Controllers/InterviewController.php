<?php

namespace App\Http\Controllers;


use App\Models\NewInterview;
use App\Models\NewAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\MailController;
class InterviewController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public $mailController;
    public function __construct()
    {
        $this->mailController = new MailController();
    }

    private function normalizeInterviewDateForStorage($date)
    {
        if ($date === null || $date === '') {
            return $date;
        }

        if ($date instanceof \DateTimeInterface) {
            return Carbon::instance($date)->format('Y-m-d');
        }

        $date = trim((string) $date);
        $formats = ['Y-m-d', 'd-m-Y', 'Y/m/d', 'd/m/Y', 'd.m.Y'];

        foreach ($formats as $format) {
            try {
                $parsed = Carbon::createFromFormat($format, $date);

                if ($parsed && $parsed->format($format) === $date) {
                    return $parsed->format('Y-m-d');
                }
            } catch (\Throwable $e) {
                //
            }
        }

        try {
            return Carbon::parse($date)->format('Y-m-d');
        } catch (\Throwable $e) {
            return $date;
        }
    }

    public function getInterview($id) {
        $interview = NewInterview::find($id);
        return response()->json($interview);
    }

    public function updateInterview(Request $request, $id) {
        $interview = NewInterview::find($id);
        // Verileri güncelle
        // Örneğin:
        // $interview->interview_date = $request->input('interview_date');
        // $interview->interview_time = $request->input('interview_time');
        $interview->save();

        return response()->json(['success' => true]);
    }
    public function mulakatSayfasindanDuzenle(Request $request) {
        $request->validate([
            'aday_katilim_durumu' => 'nullable|in:Katılacağım,Başka bir tarihte ve/veya saatte katılmak istiyorum,Katılmayacağım',
        ]);

        $i = NewInterview::find($request->id);
        
        // LOG: Mevcut Durum
        Log::info('Mülakat Güncelleme - Öncesi:', [
            'id' => $i->id,
            'date' => $i->interview_date,
            'time' => $i->interview_time,
            'platform' => $i->interview_platform,
            'person' => $i->interview_person,
            'address' => $i->interview_address,
            'katilim' => $i->aday_katilim_durumu
        ]);

        // LOG: Gelen İstek
        Log::info('Mülakat Güncelleme - Gelen İstek:', $request->all());

        $i->interview_date=$this->normalizeInterviewDateForStorage($request->editinterviewDate);
        $i->interview_time=$request->editinterviewTime;
        $i->interview_platform=$request->editinterviewType;
        $i->interview_person=$request->editinterviewer;
        $i->interview_address=$request->editinterviewadress;
        
        // Hangi alanların değiştiğini tek tek de kontrol edelim
        $dirtyFields = $i->getDirty();
        $isCoreDirty = $i->isDirty(['interview_date', 'interview_time', 'interview_platform', 'interview_person', 'interview_address']);
        
        Log::info('Mülakat Güncelleme - Değişen Alanlar:', $dirtyFields);
        Log::info('Mülakat Güncelleme - Temel Bilgi Değişti mi?: ' . ($isCoreDirty ? 'EVET' : 'HAYIR'));

        $i->aday_katilim_durumu=$request->aday_katilim_durumu;
        $i->aday_katiliim_mazereti=null;
        
        // Mülakatçı katılım durumlarını kaydet
        $i->interviewer_participation = $request->interviewer_participation;

        // Değişiklik detaylarını hazırla
        $fieldLabels = [
            'interview_date' => 'Tarih',
            'interview_time' => 'Saat',
            'interview_platform' => 'Tip',
            'interview_person' => 'Personel/Grup',
            'interview_address' => 'Adres/Link',
            'aday_katilim_durumu' => 'Aday Katılım Durumu',
            'aday_katiliim_mazereti' => 'Mazeret',
            'interviewer_participation' => 'Grup Üyesi Katılımı'
        ];

        $changes = [];
        foreach ($i->getDirty() as $field => $newValue) {
            if (isset($fieldLabels[$field])) {
                $oldValue = $i->getOriginal($field);
                $label = $fieldLabels[$field];
                
                // Değerleri daha okunabilir yapalım (Örn: null -> 'Belirtilmedi')
                $printableOld = $oldValue ?: 'Belirtilmedi';
                $printableNew = $newValue ?: 'Belirtilmedi';
                
                if ($field == 'interview_person') {
                    $oldGroup = \App\Models\InterviewGroup::find($oldValue);
                    $newGroup = \App\Models\InterviewGroup::find($newValue);
                    $printableOld = $oldGroup ? $oldGroup->name : 'Atanmamış';
                    $printableNew = $newGroup ? $newGroup->name : 'Atanmamış';
                }

                if ($field == 'interviewer_participation') {
                    $printableOld = is_array($oldValue) ? count($oldValue) . ' kişi' : 'Yok';
                    $printableNew = is_array($newValue) ? count($newValue) . ' kişi' : 'Yok';
                }

                $changes[] = "{$label}: {$printableOld} -> {$printableNew}";
            }
        }

        $logText = count($changes) > 0 
            ? 'Mülakat bilgileri güncellendi. Değişen alanlar: ' . implode(', ', $changes) 
            : 'Mülakat bilgileri güncellendi (Herhangi bir alan değişmedi).';

        $shouldSendEmail = $isCoreDirty;

        $result = $i->save();
        $this->checkResult($result);

        // LOG: Kayıt Sonrası DB Hali
        $after = NewInterview::find($request->id);
        Log::info('Mülakat Güncelleme - Sonrası (DB):', [
            'date' => $after->interview_date,
            'time' => $after->interview_time,
            'platform' => $after->interview_platform,
            'person' => $after->interview_person,
            'address' => $after->interview_address,
            'katilim' => $after->aday_katilim_durumu
        ]);

        // Zaman çizelgesine ekle
        if ($result) {
            \App\Models\InterviewTimeline::create([
                'interview_id' => $i->id,
                'title' => 'Mülakat Bilgileri Güncellendi',
                'text' => $logText,
                'topTitle' => 'Mülakat Süreci'
            ]);
        }

        // LOG: Mail Kararı
        Log::info('Mülakat Güncelleme - Mail Gönderilecek mi?: ' . ($shouldSendEmail ? 'EVET' : 'HAYIR'));

         // Mülakat güncellendiğinde template email gönder
         if ($result && $shouldSendEmail) {
            Log::info('Mülakat Güncelleme - Mail Gönderimi Başlatılıyor...');
            try {
                $interview = $i;
                // TC no ile kullanıcı bilgilerini bul
                $user = NewAnswer::where('tc_no', $interview->tc_no)->first();

                if ($user && $user->email) {
                    // Template parametrelerini hazırla
                    $parameters = [
                        'name' => $user->name,
                        'surname' => $user->surname,
                        'interview_date' => date('d.m.Y', strtotime($interview->interview_date)),
                        'interview_time' => $interview->interview_time,
                        'interview_type' => $interview->interview_platform,
                        'interview_address' => $interview->interview_address,
                    ];

                    // Template email gönder
                    $this->mailController->sendTemplateEmail(
                        'mulakat-guncellendi-mesaji',
                        $user->email,
                        'Mülakatiniz Güncellendi',
                        $parameters
                    );
                }
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                Log::error('Mülakat güncelleme mail gönderim hatası: ' . $e->getMessage());
            }
        }
        if ($request->redirect_to == 'index') {
            return redirect()->route('mulakatlar');
        }
        return redirect()->back();

        }
    public function updateInterviews(Request $request) {
        $i = NewInterview::find($request->id);
        $i->interview_date=$this->normalizeInterviewDateForStorage($request->editinterviewDate);
        $i->interview_time=$request->editinterviewTime;
        $i->interview_platform=$request->editinterviewType;
        $i->interview_person=$request->editinterviewer;
        $i->interview_address=$request->editinterviewadress;
        $result = $i->save();
        $this->checkResult($result);

        if ($result) {
            \App\Models\InterviewTimeline::create([
                'interview_id' => $i->id,
                'title' => 'Mülakat Güncellendi',
                'text' => 'Mülakat bilgileri güncellendi.',
                'topTitle' => 'Mülakat Süreci'
            ]);
        }


        return redirect()->back();
    }
    public function resultInterviews(Request $request) {
        $i = NewInterview::find($request->id);
        $i->interview_date=$this->normalizeInterviewDateForStorage($request->editinterviewDate);
        $i->interview_time=$request->editinterviewTime;
        $i->save();

        \App\Models\InterviewTimeline::create([
            'interview_id' => $i->id,
            'title' => 'Mülakat Tarihi Güncellendi',
            'text' => 'Mülakat tarihi ve saati güncellendi.',
            'topTitle' => 'Mülakat Süreci'
        ]);


        return redirect()->back();
    }

    public function concludeInterview(Request $request, $id) {
        $interview = NewInterview::find($id);
        // Verileri sonuçlandır
        // Örneğin:
        // $interview->interview_score = $request->input('interview_score');
        // $interview->interview_result = $request->input('interview_result');
        $interview->save();

        return response()->json(['success' => true]);
    }

    public function checkResult($result){
        if ($result){
            session()->flash('success', 'İşlem Başarılı!');
        }
        else{
            session()->flash('error', 'İşlem Başarısız!');
        }
    }

}
