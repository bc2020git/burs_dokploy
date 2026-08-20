<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Soru;
use Carbon\Carbon;
use App\Models\PeriodDocument;
use App\Models\PeriodEducationTypes;
use App\Http\Controllers\OrtakController;
use Illuminate\Support\Facades\Schema;
use App\Models\Scholar;
use App\Models\ScholarForm;
use App\Models\RenewForm;
use App\Models\RenewDocuments;
use App\Models\RenewAnswer;
use App\Models\RenewSiblingDetails;
use App\Models\RenewOtherScholarshipDetails;
use App\Models\ActiveSiblingDetails;
use App\Models\ActiveOtherScholarshipDetails;
use Illuminate\Support\Str;
use App\Http\Controllers\MailController;

class PeriodController extends Controller
{

    public function __construct()
    {
        $this->checkColumns();
        $this->ortakcontroller = new OrtakController();
        $this->mailController = new MailController();
    }
    public function checkColumns()
    {
        if (!Schema::hasColumn('periods', 'is_started')) {
            \DB::statement('ALTER TABLE periods ADD is_started BOOLEAN DEFAULT FALSE');
        }
        if (!Schema::hasColumn('periods', 'is_ended')) {
            \DB::statement('ALTER TABLE periods ADD is_ended BOOLEAN DEFAULT FALSE');
        }
    }
    public function getPeriods()
    {
        session(['sidebar' => 8]);

        $now = Carbon::now();
        $year = $now->year - 4;
        for ($i = 0; $i < 9; $i++) {
            $result['yillar'][$i] = $year . '-' . $year + 1;
            $year += 1;

        }
        $result['periods'] = [
            ['ilkokul', "İlkokul"],
            ['ortaokul', "Ortaokul"],
            ['lise', "Lise"],
            ['onlisans', "On Lisans"],
            ['lisans', "Lisans"],
            ['yukseklisans', "Yüksek Lisans"],
            ['doktora', "Doktora"],
        ];
        $result['documents'] = Soru::where('category_title', 'Belge Yükleme')->where('status', 'Aktif')->get();
        $result['newperiods'] = Period::with('types', 'documents')->where('type', 0)->get();
        $result['renewperiods'] = Period::with('types', 'documents')->where('type', 1)->get();
        return view('panel.period-management', $result);
    }
    public function addNewPeriod(Request $request)
    {
        $renewDocuments = collect($request->all())->filter(function ($value, $key) {
            return str_starts_with($key, 'renewdocuments_');
        });

        $newDocuments = collect($request->all())->filter(function ($value, $key) {
            return str_starts_with($key, 'newdocuments_');
        });

        if ($request->type == 0) {
            $newDocuments = $newDocuments->map(function ($documents, $key) {
                $schoolType = str_replace('newdocuments_', '', $key);

                return [
                    'school_type' => $schoolType,
                    'documents' => json_encode($documents)
                ];
            })->values();
        }
        if ($request->type == 1) {
            $renewDocuments = $renewDocuments->map(function ($documents, $key) {
                $schoolType = str_replace('renewdocuments_', '', $key);

                return [
                    'school_type' => $schoolType,
                    'documents' => json_encode($documents)
                ];
            })->values();
        }

        foreach ($request->term as $donem) {
            $item = new Period();
            $baslik = $request->bursDonemi . ' ' . $donem;
            $item->title = $baslik;
            $item->type = $request->type;
            $item->status = 0;
            $item->start_time = $request->start_time;
            $item->end_time = $request->end_time;
            $item->path = $this->ortakcontroller->createPath($baslik);
            $item->save();

        }
        foreach ($request->educType as $eductype) {
            $item2 = new PeriodEducationTypes();
            $item2->period_id = $item->id;
            $item2->educationType = $eductype;
            $item2->save();
        }
        if ($request->type == 0) {
            foreach ($newDocuments as $document) {
                $pDocument = new PeriodDocument();
                $pDocument->period_id = $item->id;
                $pDocument->school_type = $document['school_type'];
                $pDocument->documents = $document['documents'];
                $pDocument->save();
            }
        }
        if ($request->type == 1) {
            foreach ($renewDocuments as $document) {
                $pDocument = new PeriodDocument();
                $pDocument->period_id = $item->id;
                $pDocument->school_type = $document['school_type'];
                $pDocument->documents = $document['documents'];
                $pDocument->save();
            }
        }
        return redirect()->back();
    }
    public function editPeriod($id)
    {
        $period = Period::with(['types', 'documents'])->findOrFail($id);
        $result['period'] = $period;
        $result['periods'] = [
            ['ilkokul', "İlkokul"],
            ['ortaokul', "Ortaokul"],
            ['lise', "Lise"],
            ['onlisans', "On Lisans"],
            ['lisans', "Lisans"],
            ['yukseklisans', "Yüksek Lisans"],
            ['doktora', "Doktora"],
        ];
        $result['documents'] = Soru::where('category_title', 'Belge Yükleme')
            ->where('status', 'Aktif')
            ->get();

        return response()->json($result);
    }

    public function updatePeriod(Request $request)
    {
        $period = Period::with('types', 'documents')->findOrFail($request->edit_id);

        if ($request->has('edit-guz')) {
            $title = $request->edit_title . ' Güz Dönemi';
        }
        if ($request->has('edit-bahar')) {
            $title = $request->edit_title . ' Bahar Dönemi';
        }
        if ($request->has('edit-guz') || $request->has('edit-bahar')) {
            $period->title = $title;
        }
        $period->start_time = $request->edit_start_time;
        $period->end_time = $request->edit_end_time;
        $period->save();

        // Mevcut belgeleri ve eğitim türlerini temizle
        PeriodDocument::where('period_id', $request->edit_id)->delete();
        PeriodEducationTypes::where('period_id', $request->edit_id)->delete();

        // Eğitim türlerini güncelle
        if ($request->has('editType')) {
            foreach ($request->editType as $eductype) {
                $result = PeriodEducationTypes::create([
                    'period_id' => $request->edit_id,
                    'educationType' => $eductype
                ]);
            }
        }

        // Belgeleri güncelle
        $documents = collect($request->all())->filter(fn($v, $k) => str_starts_with($k, 'editdocuments_'));
        $oldDocuments = PeriodDocument::where('period_id', $request->edit_id)->get();
        foreach ($oldDocuments as $oldDoc) {
            $result = $oldDoc->delete();
        }
        foreach ($documents as $key => $docs) {
            $schoolType = str_replace(['editdocuments_'], '', $key);
            if ($schoolType == 'yukseklisans') {
                $schoolType = 'yukseklisans';
            }
            PeriodDocument::create([
                'period_id' => $request->edit_id,
                'school_type' => $schoolType,
                'documents' => json_encode($docs)
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function deletePeriod($id)
    {
        $period = Period::findOrFail($id);

        // İlişkili kayıtları sil
        PeriodDocument::where('period_id', $id)->delete();
        PeriodEducationTypes::where('period_id', $id)->delete();

        $period->delete();

        return response()->json(['success' => true]);
    }

    public function changePeriodStatus($id, $status)
    {
        $item = Period::find($id);
        if ($status == 0) {
            if (!$item->start_time || !$item->end_time) {
                session()->flash('error', 'Dönemin başlama ve bitiş tarihleri tanımlanmamıştır.');
                return redirect()->back();
            }

            $now = Carbon::now();
            $startDate = Carbon::parse($item->start_time)->startOfDay();
            $endDate = Carbon::parse($item->end_time)->endOfDay();

            if (!$now->between($startDate, $endDate)) {
                session()->flash('error', 'Bugünün tarihi dönemin başlama ve bitiş tarihleri arasında değildir.');
                return redirect()->back();
            }

            $status = 1;

        } else {
            $status = 0;
        }
        $item->status = $status;
        $item->save();
        return redirect()->back();
    }
    public function periodStartStop($id)
    {
        $item = Period::with('types')->find($id);
        if (!$item) {
            return redirect()->back();
        }

        if ($item->is_started == 0) {
            if (!$item->start_time || !$item->end_time) {
                session()->flash('error', 'Dönemin başlama ve bitiş tarihleri tanımlanmamıştır.');
                return redirect()->back();
            }

            $now = Carbon::now();
            $startDate = Carbon::parse($item->start_time)->startOfDay();
            $endDate = Carbon::parse($item->end_time)->endOfDay();

            if (!$now->between($startDate, $endDate)) {
                session()->flash('error', 'Bugünün tarihi kayıt yenileme dönemi başlangıç ve bitiş tarihleri aralığında değildir.');
                return redirect()->back();
            }

            return $this->baslatmaIslemleri($item);
        } else {
            $this->bitirmeIslemleri($item);
            session()->flash('success', 'Kayıt Yenileme Dönemi Bitirildi.');
            return redirect()->back();
        }
    }
    private function baslatmaIslemleri($item)
    {
        $item->status = 1;
        $item->is_started = 1;
        $item->is_ended = 0;
        if ($item->save()) {
            $this->ogretimTipineGoreDonemBaslat($item);
            session()->flash('success', 'Kayıt Yenileme Dönemi Başlatıldı');
            return redirect()->back();
        } else {
            session()->flash('error', 'Kayıt Yenileme Dönemi Başlatılırken Hata Oluştu');
            return redirect()->back();
        }

    }
    private function bitirmeIslemleri($item)
    {
        $item->status = 0;
        $item->is_started = 1;
        $item->is_ended = 1;
        $item->save();
    }
    private function ogretimTipineGoreDonemBaslat($item)
    {
        foreach ($item->types as $type) {
            $this->createRenewForms($item, $type->educationType);
        }
    }
    public function createRenewForms($period, $educationType)
    {
        if (!$period) {
            session()->flash('error', 'Kayıt Yenileme Dönemi Bulunamadı!');
            return redirect()->route('panel');
        }
        // Sadece aktif ve gelen donem ogrenim tipine gore ogrenciler seciliyor
        $activeScholars = Scholar::where('status', 1)
            ->with('form.infos')
            ->whereHas('form.infos', function ($query) use ($educationType) {
                $query->where('educationType', $educationType);
            })
            ->get();

        foreach ($activeScholars as $activeScholar) {
            $password = Str::random(8);
            $hashpassword = md5($password);
            $bursiyer = Scholar::find($activeScholar->id);
            $bursiyer->password = $hashpassword;
            $bursiyer->status = 2;
            $bursiyer->save();

            // 1. İlgili döneme ait RenewForm kontrolü
            $existingForm = RenewForm::where('scholar_id', $activeScholar->id)
                ->where('period_id', $period->id)
                ->first();

            if (!$existingForm) {
                // Eğer form yoksa yeni oluştur
                $form = new RenewForm();
                $form->period_id = $period->id;
                $form->scholar_id = $activeScholar->id;
                $form->save();
            } else {
                // Var olan formu kullan
                $form = $existingForm;
            }

            // 2. Öğrencinin birden fazla ScholarForm kaydı varsa sadece en güncel olanını al
            $scholarForm = ScholarForm::with('infos')
                ->where('scholar_id', $activeScholar->id)
                ->whereHas('infos', function ($query) use ($educationType) {
                    $query->where('educationType', $educationType);
                })
                ->latest('id')
                ->first();

            if ($scholarForm && !is_null($scholarForm->infos)) {
                $oldForm = $scholarForm->id;

                // Create or get RenewDocuments entry
                $itemdoc = RenewDocuments::where('form_id', $oldForm)->first();
                if (!$itemdoc) {
                    $itemdoc = new RenewDocuments();
                    $itemdoc->form_id = $oldForm;
                    $itemdoc->save();
                }

                // 3. RenewAnswer mükerrer kaydını önlemek için mevcut olanı bul veya yeni oluştur
                $item = RenewAnswer::where('form_id', $form->id)->first();
                if (!$item) {
                    $item = new RenewAnswer();
                }

                $item->tc_no = $scholarForm->infos->tc_no;
                $item->form_id = $form->id;
                $item->tel_no = $scholarForm->infos->tel_no;
                $item->save();

                $this->moveActiveModelToRenewModel(ActiveSiblingDetails::class, RenewSiblingDetails::class, $form->id, $oldForm);
                $this->moveActiveModelToRenewModel(ActiveOtherScholarshipDetails::class, RenewOtherScholarshipDetails::class, $form->id, $oldForm);

                if ($item->educationType == 'Lisans' || $item->educationType == 'yukseklisans' || $item->educationType == 'onlisans') {
                    $istenilenBelgeler = ['Öğrenci Belgesi', 'Transkript', 'Adli Sicil Belgesi'];
                } elseif ($item->educationType == 'ilkokul' || $item->educationType == 'ortaokul' || $item->educationType == 'lise') {
                    $istenilenBelgeler = ['Öğrenci Belgesi', 'Karne'];
                } else {
                    $istenilenBelgeler = [];
                }

                // ScholarForm'dan gelen verileri al
                $scholarFormData = $scholarForm->infos->toArray();

                $filteredData = array_filter($scholarFormData, function ($key) {
                    return $key !== 'form_id' && $key !== 'password' && $key !== 'id' && strpos($key, 'doc_') !== 0;
                }, ARRAY_FILTER_USE_KEY);

                // Verileri RenewAnswer modeline güncelle
                $item->update($filteredData);
                $item->status = 0;
                $item->save();
            }

            RenewForm::where('id', $form->id)->update(['status' => 0]);

            // Email kontrolü ekle
            if ($activeScholar->email) {
                try {
                    // Yeni template sistemi ile mail gönder
                    try {
                        $parameters = [
                            'name' => $activeScholar->name,
                            'surname' => $activeScholar->surname,
                            'email' => $activeScholar->email,
                            'password' => $password,
                        ];

                        $this->mailController->sendTemplateEmail(
                            'kayit-yenileme-donemi-basladi',
                            $activeScholar->email,
                            'Kayıt Yenileme Döneminiz Açıldı',
                            $parameters
                        );
                    } catch (\Exception $e) {
                        // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                        \Log::error('Kayıt yenileme dönemi başladı mail gönderim hatası: ' . $e->getMessage());
                    }
                } catch (\Exception $e) {
                    // Mail gönderimi sırasında oluşan hatayı loglayabilirsiniz
                    \Log::error('Mail gönderimi hatası: ' . $e->getMessage(), [
                        'scholar_id' => $activeScholar->id,
                        'email' => $activeScholar->email
                    ]);
                }
            } else {
                // Email olmayan bursiyerleri loglayabilirsiniz
                \Log::warning('Bursiyerin email adresi yok', [
                    'scholar_id' => $activeScholar->id,
                    'name' => $activeScholar->name,
                    'surname' => $activeScholar->surname
                ]);
            }
        }
    }

    public function moveActiveModelToRenewModel($oldModel, $newModel, $form_id, $old_form_id)
    {
        $newModel::where('form_id', $form_id)->delete();
        $record = $oldModel::where('form_id', $old_form_id)->get();
        $data = $record->toArray();
        foreach ($data as $item) {
            unset($item['id']);
            unset($item['form_id']);
            $item['form_id'] = $form_id;
            $item = $newModel::create($item);
        }
    }
}
