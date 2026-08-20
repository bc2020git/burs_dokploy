<?php

namespace App\Http\Controllers;

use App\Models\ActiveAnswer;
use App\Models\Lisansscholar;
use App\Models\Lisescholar;
use App\Models\LisescholarForm;
use App\Models\Period;
use App\Models\Scholar;
use App\Models\ScholarForm;
use App\Models\Soru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KydonemduzeltController extends Controller
{
    public function start($type, $educ)
    {
        if ($type === 'lise') {
            if ($educ === 'renew') {
                return $this->getLiseRenewQuestions();
            } elseif ($educ === 'form') {
                return $this->getLiseFormQuestions();
            }
        } elseif ($type === 'lisans') {
            if ($educ === 'renew') {
                return $this->getLisansRenewQuestions();
            } elseif ($educ === 'form') {
                return $this->getLisansFormQuestions();
            } elseif ($educ === 'combined') {
                return $this->getLisansCombinedQuestions();
            }
        }

        return response()->json(['error' => 'Invalid parameters'], 400);
    }

    public function startForLise()
    {
        $liseliler = Lisescholar::where('status', 1)
            ->whereHas('renewform.infos', function ($query) {
                $query->where('educationType', 'lise');
            })
            ->get();

        return $liseliler;
    }

    public function startForLisansOrYuksekLisans()
    {

        // Asıl sorgu
        $lisansliler = Lisansscholar::where('status', 1)
            ->whereHas('form.answers', function ($query) {
                $query->where('educationType', 'lisans')
                    ->orWhere('educationType', 'yukseklisans');
            })
            ->with('form.answers')
            ->get();

        \Log::info('Filtrelenmiş lisans öğrencisi: '.$lisansliler->count());

        return $lisansliler;
    }

    public function getLiseRenewQuestions()
    {
        $sorular = Soru::where('type', 'file')->get();
        $db_keys = $sorular->pluck('db_key');

        $liseScholars = $this->startForLise();

        $data = [];

        foreach ($liseScholars as $scholar) {
            $scholarData = [
                'scholar' => $scholar,
                'file_answers' => [],
            ];

            if ($scholar->renewform) {
                foreach ($scholar->renewform as $form) { // Assuming renewform is a collection based on usage in startForLise (whereHas) but definition says hasMany? Let's check model again. Model says hasMany.
                    // But strictly, startForLise filters by Has('renewform.infos'), so at least one exists.
                    $answers = $form->infos;
                    if ($answers) {
                        foreach ($db_keys as $key) {
                            if (isset($answers->$key)) {
                                $scholarData['file_answers'][$key] = $answers->$key;
                            }
                        }
                    }
                }
            }
            $data[] = $scholarData;
        }

        return response()->json($data);
    }

    public function getLisansRenewQuestions()
    {
        $sorular = Soru::where('type', 'file')->get();
        $db_keys = $sorular->pluck('db_key');

        $lisansScholars = $this->startForLisansOrYuksekLisans();

        $data = [];

        foreach ($lisansScholars as $scholar) {
            $scholarData = [
                'scholar' => $scholar,
                'file_answers' => [],
            ];

            if ($scholar->form) {
                foreach ($scholar->form as $form) {
                    $answers = $form->answers ?? $form->infos;
                    if ($answers) {
                        foreach ($db_keys as $key) {
                            if (isset($answers->$key)) {
                                $scholarData['file_answers'][$key] = $answers->$key;
                            }
                        }
                    }
                }
            }
            $data[] = $scholarData;
        }

        return response()->json($data);
    }

    public function getLiseFormQuestions()
    {
        $sorular = Soru::where('type', 'file')->get();
        $db_keys = $sorular->pluck('db_key');

        // Fetch forms for active scholars
        $forms = LisescholarForm::whereHas('scholar', function ($query) {
            $query->where('status', 1);
        })->with('infos')->get();

        $data = [];

        foreach ($forms as $form) {
            $formData = [
                'form' => $form,
                'file_answers' => [],
            ];

            // LisescholarForm uses 'infos' relation for answers
            $answers = $form->infos;
            if ($answers) {
                foreach ($db_keys as $key) {
                    if (isset($answers->$key)) {
                        $formData['file_answers'][$key] = $answers->$key;
                    }
                }
            }
            $data[] = $formData;
        }

        return response()->json($data);
    }

    public function getLisansFormQuestions()
    {
        $sorular = Soru::where('type', 'file')->get();
        $db_keys = $sorular->pluck('db_key');

        // Fetch active scholars with their forms and renewal history
        $scholars = Lisansscholar::where('status', 1)
            ->with(['form.answers', 'eskiky.infos'])
            ->get();

        $data = [];

        foreach ($scholars as $scholar) {
            // Process renewal history (eskiky) once per scholar
            $renewalsData = [];
            if ($scholar->eskiky) {
                foreach ($scholar->eskiky as $renewForm) {
                    $renewAnswers = [];
                    if ($renewForm->infos) {
                        foreach ($db_keys as $key) {
                            if (isset($renewForm->infos->$key)) {
                                $renewAnswers[$key] = $renewForm->infos->$key;
                            }
                        }
                    }
                    $renewalsData[] = [
                        'form' => $renewForm,
                        'file_answers' => $renewAnswers,
                    ];
                }
            }

            // Process each main form
            if ($scholar->form) {
                foreach ($scholar->form as $form) {
                    $formData = [
                        'form' => $form,
                        'file_answers' => [],
                        'renewals' => $renewalsData, // Attach scholar's renewal history
                    ];

                    $answers = $form->answers;
                    if ($answers) {
                        foreach ($db_keys as $key) {
                            if (isset($answers->$key)) {
                                $formData['file_answers'][$key] = $answers->$key;
                            }
                        }
                    }
                    $data[] = $formData;
                }
            }
        }

        return response()->json($data);
    }

    public function getLisansCombinedQuestions()
    {
        $sorular = Soru::where('type', 'file')->get();
        $db_keys = $sorular->pluck('db_key');

        $scholars = Lisansscholar::where('status', 1)
            ->with(['form.answers', 'eskiky.infos'])
            ->get();

        $data = [];

        foreach ($scholars as $scholar) {
            $scholarData = [
                'scholar' => $scholar,
                'active_forms' => [],
                'renewal_forms' => [],
            ];

            // Active Forms
            if ($scholar->form) {
                foreach ($scholar->form as $form) {
                    $answers = $form->answers;
                    $fileAnswers = [];
                    if ($answers) {
                        foreach ($db_keys as $key) {
                            if (isset($answers->$key)) {
                                $fileAnswers[$key] = $answers->$key;
                            }
                        }
                    }
                    $scholarData['active_forms'][] = [
                        'form_data' => $form,
                        'file_answers' => $fileAnswers,
                    ];
                }
            }

            // Renewal Forms (eskiky)
            if ($scholar->eskiky) {
                foreach ($scholar->eskiky as $renewForm) {
                    $answers = $renewForm->infos;
                    $fileAnswers = [];
                    if ($answers) {
                        foreach ($db_keys as $key) {
                            if (isset($answers->$key)) {
                                $fileAnswers[$key] = $answers->$key;
                            }
                        }
                    }
                    $scholarData['renewal_forms'][] = [
                        'form_data' => $renewForm,
                        'file_answers' => $fileAnswers,
                    ];
                }
            }

            $data[] = $scholarData;
        }

        return response()->json($data);
    }

    public function showMigrationView()
    {
        return view('migration.index');
    }

    public function getMigrationScholars(\Illuminate\Http\Request $request)
    {
        $type = $request->input('type', 'lisans');

        if ($type === 'lise') {

            // Lise için aktif öğrencileri çek
            return Lisescholar::where('status', 1)
                ->whereHas('form.infos', function ($q) {
                    $q->whereIn('educationType', ['lise', 'ilkokul', 'ortaokul']);

                })
                ->pluck('id');
        }

        return Lisansscholar::where('status', 1)
            ->whereHas('form.answers', function ($q) {
                $q->whereIn('educationType', ['lisans', 'yukseklisans', 'doktora']);
            })
            ->pluck('id');
    }

    public function migrateBatch(\Illuminate\Http\Request $request)
    {
        $ids = $request->input('ids');
        $type = $request->input('type', 'lisans');

        if ($type === 'lise') {
            return $this->liseIcinIslem($ids);
        }

        return $this->lisansIcinIslem($ids);
    }

    private function processFileMigration($scholar, $model, $column, $targetDir, &$logs, &$successes, $defaultType)
    {
        $oldPath = $model->$column; // Örn: /storage/uploads/kayitYenilemeler/820/68dba46660280.jpg
        $scholarId = $scholar->id;

        // Eğer path zaten yeni formatta ise (bursiyerler/{id}) atla
        if (strpos($oldPath, "storage/bursiyerler/{$scholarId}") !== false) {
            // Zaten taşınmışsa da listeye ekleyelim mi? Kullanıcı "işlem tamamlandı" dediğinde görmek istiyor.
            // Şimdilik sadece yeni taşınanları ekleyelim. İstenirse burası açılabilir.
            // $successes[] = [
            //    'id' => $scholar->id,
            //    'name' => $scholar->name,
            //    'surname' => $scholar->surname,
            //    'type' => $defaultType, // veya $model->educationType ?? $defaultType
            //    'key' => $column
            // ];
            return;
        }

        // DB'deki path genelde başında / ile kayıtlı olabilir.
        // Temizleme: baştaki / işaretini kaldır
        $relPath = ltrim($oldPath, '/');

        // Direkt olarak base_path (proje kökü) üzerinden kontrol et
        $sourceFullPath = base_path($relPath);

        if (file_exists($sourceFullPath) && is_file($sourceFullPath)) {
            $info = pathinfo($sourceFullPath);
            $ext = $info['extension'] ?? 'jpg';
            $newFileName = uniqid().'.'.$ext;
            $newFullPath = $targetDir.'/'.$newFileName;

            // Dosyayı taşı
            if (copy($sourceFullPath, $newFullPath)) {
                // DB güncelle
                // Yeni path formatı: /storage/bursiyerler/3067/yeniad.jpg
                $newDbPath = "/storage/bursiyerler/{$scholarId}/{$newFileName}";

                $model->$column = $newDbPath;
                $model->save();

                $logs[] = "Taşındı: {$oldPath} -> {$newDbPath}";

                // Başarılı listesine ekle
                $successes[] = [
                    'id' => $scholar->id,
                    'name' => $scholar->name,
                    'surname' => $scholar->surname,
                    'type' => $model->educationType ?? $defaultType,
                    'key' => $column,
                ];

                // İsteğe bağlı: Eski dosyayı silmek isterseniz:
                // unlink($sourceFullPath);
            } else {
                $logs[] = "HATA: Dosya kopyalanamadı: $sourceFullPath";
            }
        } else {
            $logs[] = "HATA: Kaynak dosya bulunamadı: $sourceFullPath (DB: $oldPath)";
        }
    }

    public function liseIcinIslem($ids)
    {
        $logs = [];
        $successes = []; // Başarılılar
        $sorular = Soru::where('type', 'file')->get();
        $db_keys = $sorular->pluck('db_key');

        $logs[] = 'Öğrenci listesi çekiliyor (LISE)...';

        // IDs arrayinde değilse array yap (tek id string/int gelebilir)
        if (! is_array($ids)) {
            $ids = [$ids];
        }

        // Debug için ID filtresi
        // $ids = [3837];

        $scholars = \App\Models\Scholar::whereIn('id', $ids)
            ->with(['form.infos'])
            ->get();

        $logs[] = $scholars->count().' adet öğrenci bulundu. İşlem başlıyor...';

        foreach ($scholars as $scholar) {
            $logs[] = "Öğrenci ID: {$scholar->id} işleniyor...";

            $targetDir = base_path("storage/bursiyerler/{$scholar->id}");

            if (! file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Sadece Period 65 formlarını al ve işlem yap
            // Collection'ı önceden alıp loopa sokuyoruz ki döngü içinde eklenen yeni formlar (period 75) döngüyü bozmasın.
            $formsToProcess = $scholar->form->where('period_id', 65);

            if ($formsToProcess->count() > 0) {
                foreach ($formsToProcess as $originalForm) {
                    $infos = $originalForm->infos;

                    // Form check
                    if (! $infos) {
                        $logs[] = " - Form ID: {$originalForm->id} için bilgi (infos) bulunamadı. Atlanıyor.";

                        continue;
                    }

                    if (! in_array($infos->educationType, ['ilkokul', 'ortaokul', 'lise'])) {
                        // $logs[] = " - Form ID: {$originalForm->id} educationType ({$infos->educationType}) uygun değil. Atlanıyor.";
                        continue;
                    }

                    $logs[] = " - Form ID: {$originalForm->id} (Period 65) bulundu. Arşivleme başlıyor.";

                    // Zaten işlem yapılmış mı kontrolü?
                    $alreadyMigrated = \App\Models\ScholarForm::where('scholar_id', $scholar->id)
                        ->where('period_id', 75)
                        ->exists();

                    if ($alreadyMigrated) {
                        $logs[] = " - UYARI: Öğrenci ID: {$scholar->id} için zaten Period 75 arşiv formu mevcut. İşlem atlanıyor.";
                        continue;
                    }

                    // 1. Yeni ScholarForm oluştur (Arşiv için, period_id = 75)
                    $archiveForm = $originalForm->replicate();
                    $archiveForm->period_id = 75;
                    $archiveForm->save();

                    $logs[] = "   -> Form Arşivlendi. Yeni Form ID (Period 75): {$archiveForm->id}";

                    // 2. Mevcut ActiveAnswer'ı arşiv forma taşı ve periodunu guncelle
                    // infos zaten ActiveAnswer modelidir (ilişkiden geldi)
                    // Ancak re-query veya direkt update daha güvenli olabilir.
                    // $infos mevcut kaydı temsil ediyor.
                    $infos->form_id = $archiveForm->id;
                    $infos->period_id = 75;
                    $infos->save();

                    $logs[] = "   -> Mevcut ActiveAnswer (ID: {$infos->id}) Arşiv Forma taşındı (Period 75).";

                    // 3. LiseactiveAnswer tablosundan veriyi bul (orijinal form id ile)
                    $liseAnswer = \App\Models\LiseactiveAnswer::where('form_id', $originalForm->id)->first();

                    if ($liseAnswer) {
                        $logs[] = "   -> LiseactiveAnswer bulundu (ID: {$liseAnswer->id}). Kopyalanıyor...";

                        // 4. ActiveAnswer tablosuna kopyala (Orijinal form (65) altında)
                        $newActiveAnswer = new \App\Models\ActiveAnswer;
                        $liseData = $liseAnswer->toArray();

                        // ID hariç her şeyi kopyala
                        unset($liseData['id']);
                        // Timestamps genellikle otomatik yönetilir ama toArray ile gelirse unset yapmak iyidir
                        unset($liseData['created_at'], $liseData['updated_at']);

                        $newActiveAnswer->fill($liseData);
                        $newActiveAnswer->form_id = $originalForm->id;
                        $newActiveAnswer->period_id = 65; // Orijinal period
                        $newActiveAnswer->save();

                        $logs[] = "   -> Yeni ActiveAnswer oluşturuldu (ID: {$newActiveAnswer->id}) Period 65 Formuna bağlandı.";

                        // 5. Dosya Taşıma (Yeni oluşan ActiveAnswer verileri üzerinden)
                        // Sadece type=file olan (db_keys içinde olan) ve dolu olan veriler için
                        foreach ($db_keys as $key) {
                            if (! empty($newActiveAnswer->$key)) {
                                $logs[] = "     -> Dosya kopyalanıyor: {$key}";
                                $this->processFileMigration($scholar, $newActiveAnswer, $key, $targetDir, $logs, $successes, 'Lise');
                            }
                        }
                    } else {
                        $logs[] = "   -> UYARI: LiseactiveAnswer bulunamadı! Form ID: {$originalForm->id}";
                    }
                }
            } else {
                $logs[] = ' - Öğrencinin formu yok.';
            }
        }

        $logs[] = 'Tüm işlemler tamamlandı.';

        return response()->json(['status' => 'success', 'logs' => $logs, 'successes' => $successes]);
    }

    public function lisansIcinIslem($ids)
    {
        $logs = [];
        $successes = []; // Başarılı işlemleri tutacak dizi
        $sorular = Soru::where('type', 'file')->get();
        $db_keys = $sorular->pluck('db_key');

        // LisansScholar yerine Scholar kullanılıyor
        $scholars = \App\Models\Scholar::whereIn('id', $ids)
            ->with(['form.infos'])
            ->get();
        foreach ($scholars as $scholar) {
            // Hedef Klasör: Ana dizinde storage/bursiyerler/{id}
            $targetDir = base_path("storage/bursiyerler/{$scholar->id}");

            if (! file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            if ($scholar->form) {
                foreach ($scholar->form as $form) {
                    // infos ilişkisini kullanıyoruz (ScholarForm -> ActiveAnswer)
                    $infos = $form->infos;
                    // Filtreleme: educationType lisans/yukseklisans/doktora VE period_id = 65
                    if ($infos &&
                        in_array($infos->educationType, ['lisans', 'yukseklisans', 'doktora']) &&
                        $form->period_id == 65
                    ) {

                        // Dosya Taşıma
                        foreach ($db_keys as $key) {
                            // db_key verisi var mı kontrol et (örneğin doc_kimlik)
                            if (! empty($infos->$key)) {
                                // Dosya taşıma ve path güncelleme işlemi
                                $this->processFileMigration($scholar, $infos, $key, $targetDir, $logs, $successes, 'Lisans');
                            }
                        }
                    }
                }
            }
        }

        return response()->json(['status' => 'success', 'logs' => $logs, 'successes' => $successes]);
    }

    public function cleanupDuplicate75Forms()
    {
        $logs = [];
        $deletedCount = 0;
        $skippedCount = 0;
        $educationTypes = ['ilkokul', 'ortaokul', 'lise'];

        // Sadece hem 65 hem de 75 dönemli formu olan öğrencileri bul
        $scholarIds = ScholarForm::whereIn('period_id', [65, 75])
            ->whereHas('infos', function ($q) use ($educationTypes) {
                $q->whereIn('educationType', $educationTypes);
            })
            ->pluck('scholar_id')
            ->unique()
            ->values();

        $logs[] = "İşleme alınacak öğrenci sayısı: {$scholarIds->count()}";

        foreach ($scholarIds as $scholarId) {
            $forms65 = ScholarForm::where('scholar_id', $scholarId)
                ->where('period_id', 65)
                ->whereHas('infos', function ($q) use ($educationTypes) {
                    $q->whereIn('educationType', $educationTypes);
                })
                ->with('infos')
                ->get();

            $forms75 = ScholarForm::where('scholar_id', $scholarId)
                ->where('period_id', 75)
                ->whereHas('infos', function ($q) use ($educationTypes) {
                    $q->whereIn('educationType', $educationTypes);
                })
                ->with('infos')
                ->get();

            if ($forms65->isEmpty() || $forms75->isEmpty()) {
                continue;
            }

            foreach ($forms75 as $form75) {
                $hasMatching65 = false;

                foreach ($forms65 as $form65) {
                    $formIdentical = $this->modelRecordsAreIdentical(
                        $form65,
                        $form75,
                        ['period_id']
                    );

                    $answerIdentical = $this->modelRecordsAreIdentical(
                        $form65->infos,
                        $form75->infos,
                        ['form_id', 'period_id']
                    );

                    if ($formIdentical && $answerIdentical) {
                        $hasMatching65 = true;

                        try {
                            \DB::transaction(function () use ($form75) {
                                if ($form75->infos) {
                                    $form75->infos->delete();
                                }
                                $form75->delete();
                            });

                            $deletedCount++;
                            $logs[] = "Silindi: scholar_id={$scholarId}, 75 Period Form ID={$form75->id}, eşleşen 65 Period Form ID={$form65->id}";
                        } catch (\Exception $e) {
                            $logs[] = "HATA: scholar_id={$scholarId}, 75 Period Form ID={$form75->id} silinemedi: {$e->getMessage()}";
                        }

                        break;
                    }
                }

                if (! $hasMatching65) {
                    $skippedCount++;
                    $logs[] = "Atlandı: scholar_id={$scholarId}, 75 Period Form ID={$form75->id} (eşleşen 65 Period formu yok)";
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'deleted_count' => $deletedCount,
            'skipped_count' => $skippedCount,
            'logs' => $logs,
        ]);
    }

    public function showActiveAnswerFileRepair()
    {
        return view('file-repair.index', [
            'periods' => Period::orderByDesc('id')->get(['id', 'title']),
            'fileColumns' => $this->activeAnswerFileColumns(),
        ]);
    }

    public function getActiveAnswerFileRepairScholars(Request $request)
    {
        $validated = $request->validate([
            'period_id' => ['required', 'integer', 'exists:periods,id'],
        ]);

        $fileColumns = array_keys($this->activeAnswerFileColumns());
        $selectColumns = array_merge(
            ['active_answers.id', 'active_answers.form_id', 'active_answers.period_id', 'active_answers.name', 'active_answers.surname', 'active_answers.tc_no', 'active_answers.educationType'],
            array_map(fn ($column) => 'active_answers.'.$column, $fileColumns)
        );

        $answers = ActiveAnswer::query()
            ->leftJoin('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
            ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
            ->where('active_answers.period_id', $validated['period_id'])
            ->whereIn('active_answers.educationType', ['ilkokul', 'ortaokul', 'lise'])
            ->whereNotNull('scholars.id')
            ->select(array_merge($selectColumns, ['scholars.id as scholar_id']))
            ->orderBy('active_answers.name')
            ->orderBy('active_answers.surname')
            ->get();

        return response()->json([
            'count' => $answers->count(),
            'columns' => $this->activeAnswerFileColumns(),
            'scholars' => $answers,
        ]);
    }

    public function processActiveAnswerFileRepair(Request $request)
    {
        $fileColumns = array_keys($this->activeAnswerFileColumns());
        $validated = $request->validate([
            'period_id' => ['required', 'integer', 'exists:periods,id'],
            'clear_columns' => ['required', 'array', 'min:1'],
            'clear_columns.*' => ['required', 'string', 'distinct', Rule::in($fileColumns)],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_date'],
            'target_columns' => ['required', 'array', 'size:2'],
            'target_columns.*' => ['required', 'string', 'distinct', Rule::in($fileColumns)],
            'confirmation' => ['accepted'],
        ]);

        $startTimestamp = strtotime($validated['start_date'].' 00:00:00');
        $endTimestamp = strtotime($validated['end_date'].' 23:59:59');
        $clearColumns = array_values($validated['clear_columns']);
        $targetColumns = array_values($validated['target_columns']);
        $disk = Storage::disk('public');
        $results = [];
        $updatedCount = 0;
        $deletedCount = 0;
        $skippedCount = 0;

        ActiveAnswer::query()
            ->join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
            ->join('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
            ->where('active_answers.period_id', $validated['period_id'])
            ->whereIn('active_answers.educationType', ['ilkokul', 'ortaokul', 'lise'])
            ->select('active_answers.*', 'scholars.id as scholar_id')
            ->orderBy('active_answers.id')
            ->chunkById(100, function ($answers) use ($disk, $startTimestamp, $endTimestamp, $clearColumns, $targetColumns, &$results, &$updatedCount, &$deletedCount, &$skippedCount) {
                foreach ($answers as $answer) {
                    try {
                        // Gather clear paths that belong to bursiyerler/{scholar_id}/
                        $clearPaths = collect($clearColumns)
                            ->map(fn ($column) => $this->storageRelativePath($answer->$column, $answer->scholar_id))
                            ->filter()
                            ->unique()
                            ->values()
                            ->all();

                        $occupiedTarget = collect($targetColumns)->first(function ($column) use ($answer, $clearColumns) {
                            return ! in_array($column, $clearColumns, true) && ! empty($answer->$column);
                        });

                        if ($occupiedTarget) {
                            $skippedCount++;
                            $results[] = $this->fileRepairResult($answer, 'skipped', "{$occupiedTarget} hedef sütunu dolu.");
                            continue;
                        }

                        $candidateFiles = collect($disk->allFiles('bursiyerler/'.$answer->scholar_id))
                            ->filter(function ($path) use ($disk, $startTimestamp, $endTimestamp, $clearPaths) {
                                if (in_array($path, $clearPaths, true)) {
                                    return false;
                                }

                                $modifiedAt = $disk->lastModified($path);

                                return $modifiedAt >= $startTimestamp && $modifiedAt <= $endTimestamp;
                            })
                            ->sortBy(fn ($path) => sprintf('%020d-%s', $disk->lastModified($path), $path))
                            ->values();

                        $candidateCount = $candidateFiles->count();

                        if ($candidateCount === 0) {
                            $skippedCount++;
                            $results[] = $this->fileRepairResult($answer, 'skipped', 'Seçilen tarih aralığında uygun dosya bulunamadı.');
                            continue;
                        }

                        $filesToAssign = $candidateFiles->take(2);
                        $statusMsg = '';

                        if ($candidateCount === 1) {
                            $statusMsg = '1 adet dosya bulundu ve ilk hedef sütuna atandı (diğer hedef sütun boş bırakıldı).';
                        } elseif ($candidateCount === 2) {
                            $statusMsg = '2 adet dosya bulundu ve hedef sütunlara atandı.';
                        } else {
                            $statusMsg = "{$candidateCount} adet dosya bulundu, sıralı ilk 2 dosya hedef sütunlara atandı.";
                        }

                        $recordDeletedCount = 0;

                        DB::transaction(function () use ($answer, $disk, $clearColumns, $clearPaths, $targetColumns, $filesToAssign, &$recordDeletedCount) {
                            // Delete clear paths physically inside bursiyerler/{scholar_id}/
                            foreach ($clearPaths as $path) {
                                if ($disk->exists($path)) {
                                    @$disk->delete($path);
                                    $recordDeletedCount++;
                                }
                            }

                            // Nullify clear columns in DB
                            foreach ($clearColumns as $column) {
                                $answer->$column = null;
                            }

                            // Assign target columns
                            foreach ($targetColumns as $index => $column) {
                                if (isset($filesToAssign[$index])) {
                                    $answer->$column = '/storage/'.$filesToAssign[$index];
                                } else {
                                    $answer->$column = null;
                                }
                            }

                            $answer->save();
                        });

                        $updatedCount++;
                        $deletedCount += $recordDeletedCount;
                        $results[] = $this->fileRepairResult($answer, 'success', $statusMsg);

                    } catch (\Throwable $exception) {
                        $skippedCount++;
                        $results[] = $this->fileRepairResult($answer, 'error', 'Hata: '.$exception->getMessage());
                    }
                }
            }, 'active_answers.id', 'id');

        return response()->json([
            'status' => 'success',
            'updated_count' => $updatedCount,
            'deleted_count' => $deletedCount,
            'skipped_count' => $skippedCount,
            'results' => $results,
        ]);
    }

    private function activeAnswerFileColumns(): array
    {
        $existingColumns = Schema::getColumnListing('active_answers');

        return Soru::where('type', 'file')
            ->whereIn('db_key', $existingColumns)
            ->whereNotNull('db_key')
            ->orderBy('title')
            ->get(['db_key', 'title'])
            ->unique('db_key')
            ->mapWithKeys(fn ($question) => [$question->db_key => $question->title ?: $question->db_key])
            ->all();
    }

    private function storageRelativePath($path, $scholarId): ?string
    {
        if (! is_string($path) || $path === '') {
            return null;
        }

        $relativePath = ltrim(preg_replace('#^/?storage/#', '', $path), '/');
        $expectedPrefix = 'bursiyerler/'.$scholarId.'/';

        if (! str_starts_with($relativePath, $expectedPrefix) || str_contains($relativePath, '..')) {
            return null;
        }

        return $relativePath;
    }

    private function fileRepairResult($answer, string $status, string $message): array
    {
        return [
            'answer_id' => $answer->id,
            'scholar_id' => $answer->scholar_id,
            'name' => trim(($answer->name ?? '').' '.($answer->surname ?? '')),
            'education_type' => $answer->educationType,
            'status' => $status,
            'message' => $message,
        ];
    }

    private function modelRecordsAreIdentical($recordA, $recordB, array $excludeKeys = [])
    {
        if (! $recordA || ! $recordB) {
            return false;
        }

        $dataA = $recordA->getAttributes();
        $dataB = $recordB->getAttributes();

        $excludeKeys = array_merge(['id', 'created_at', 'updated_at'], $excludeKeys);

        foreach ($excludeKeys as $key) {
            unset($dataA[$key], $dataB[$key]);
        }

        return $dataA == $dataB;
    }

    public function exportActiveAnswerFileRepairResults(Request $request)
    {
        $validated = $request->validate([
            'period_id' => ['required', 'integer'],
            'results' => ['required'],
        ]);

        $results = is_array($request->input('results'))
            ? $request->input('results')
            : json_decode($request->input('results', '[]'), true);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('İşlem Sonuç Raporu');

        $sheet->fromArray([
            ['Answer ID', 'Scholar ID', 'Öğrenci Adı Soyadı', 'Öğrenim Türü', 'Durum', 'Açıklama']
        ], null, 'A1');

        $rows = [];
        foreach ($results as $item) {
            $rows[] = [
                $item['answer_id'] ?? '',
                $item['scholar_id'] ?? '',
                $item['name'] ?? '',
                $item['education_type'] ?? '',
                $item['status'] ?? '',
                $item['message'] ?? '',
            ];
        }

        if (! empty($rows)) {
            $sheet->fromArray($rows, null, 'A2');
        }

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'dosya_duzenleme_sonuc_raporu_donem_'.$validated['period_id'].'_'.date('Ymd_His').'.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function getScholarFolderFiles(Request $request)
    {
        $validated = $request->validate([
            'period_id' => ['nullable', 'integer'],
        ]);

        $periodId = ! empty($validated['period_id']) ? (int) $validated['period_id'] : null;
        $folderFiles = $this->buildScholarFolderFilesList($periodId);

        return response()->json([
            'status' => 'success',
            'period_id' => $periodId,
            'total_files' => count($folderFiles),
            'files' => $folderFiles,
        ]);
    }

    public function exportScholarFolderFiles(Request $request)
    {
        $validated = $request->validate([
            'period_id' => ['nullable', 'integer'],
        ]);

        $periodId = ! empty($validated['period_id']) ? (int) $validated['period_id'] : null;
        $folderFiles = $this->buildScholarFolderFilesList($periodId);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Öğrenci Klasör Dosyaları');

        $sheet->fromArray([
            ['Scholar ID', 'Öğrenci Adı Soyadı', 'Öğrenim Türü', 'Dönem ID', 'Tanımlı Sütun', 'Dosya Adı', 'Dosya Yolu (Path)', 'Son Değiştirilme Tarihi']
        ], null, 'A1');

        $rows = [];
        foreach ($folderFiles as $item) {
            $rows[] = [
                $item['scholar_id'],
                $item['name_surname'],
                $item['education_type'],
                $item['period_id'],
                $item['matched_column'],
                $item['filename'],
                $item['path'],
                $item['last_modified'],
            ];
        }

        if (! empty($rows)) {
            $sheet->fromArray($rows, null, 'A2');
        }

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'bursiyer_klasor_dosyalari_'.($periodId ? 'donem_'.$periodId.'_' : '').date('Ymd_His').'.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function buildScholarFolderFilesList(?int $periodId = null): array
    {
        $answersQuery = ActiveAnswer::query()
            ->join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
            ->join('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
            ->whereIn('active_answers.educationType', ['ilkokul', 'ortaokul', 'lise']);

        if ($periodId) {
            $targetScholarIds = (clone $answersQuery)
                ->where('active_answers.period_id', $periodId)
                ->pluck('scholars.id')
                ->unique()
                ->all();

            $answers = ActiveAnswer::query()
                ->join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
                ->join('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                ->whereIn('scholars.id', $targetScholarIds)
                ->select('active_answers.*', 'scholars.id as scholar_id')
                ->get();
        } else {
            $answers = $answersQuery
                ->select('active_answers.*', 'scholars.id as scholar_id')
                ->get();
        }

        $fileColumnsMap = $this->activeAnswerFileColumns();
        $fileColumns = array_keys($fileColumnsMap);
        $disk = Storage::disk('public');
        $folderFiles = [];

        $scholarGroupedAnswers = $answers->groupBy('scholar_id');

        foreach ($scholarGroupedAnswers as $scholarId => $scholarAnswers) {
            $firstAnswer = $scholarAnswers->first();
            $nameSurname = trim(($firstAnswer->name ?? '').' '.($firstAnswer->surname ?? ''));
            $edType = $firstAnswer->educationType;
            $scholarDirectory = 'bursiyerler/'.$scholarId;

            $files = $disk->allFiles($scholarDirectory);

            if (empty($files)) {
                $folderFiles[] = [
                    'scholar_id' => $scholarId,
                    'name_surname' => $nameSurname,
                    'education_type' => $edType,
                    'period_id' => '-',
                    'matched_column' => '-',
                    'filename' => 'Klasör Boş / Bulunamadı',
                    'path' => '-',
                    'last_modified' => '-',
                ];
            } else {
                foreach ($files as $file) {
                    $cleanPath = '/'.ltrim($file, '/');
                    $storagePath = '/storage/'.ltrim($file, '/');
                    $matchedPeriod = null;
                    $matchedColTitle = null;

                    foreach ($scholarAnswers as $ans) {
                        foreach ($fileColumns as $col) {
                            $val = $ans->$col;
                            if (is_string($val) && $val !== '') {
                                $cleanVal = '/'.ltrim(preg_replace('#^/?storage/#', '', $val), '/');
                                if ($cleanVal === $cleanPath || $val === $storagePath || $val === $file) {
                                    $matchedPeriod = $ans->period_id;
                                    $matchedColTitle = $fileColumnsMap[$col] ?? $col;
                                    break 2;
                                }
                            }
                        }
                    }

                    $folderFiles[] = [
                        'scholar_id' => $scholarId,
                        'name_surname' => $nameSurname,
                        'education_type' => $edType,
                        'period_id' => $matchedPeriod ? (string) $matchedPeriod : '-',
                        'matched_column' => $matchedColTitle ? $matchedColTitle : '-',
                        'filename' => basename($file),
                        'path' => '/storage/'.ltrim($file, '/'),
                        'last_modified' => date('Y-m-d H:i:s', $disk->lastModified($file)),
                    ];
                }
            }
        }

        return $folderFiles;
    }

    public function resetFileRepairTestData(Request $request)
    {
        $periodId = (int) ($request->input('period_id') ?: 75);

        $period = Period::find($periodId);
        if (! $period) {
            $period = Period::create([
                'id' => $periodId,
                'title' => '2025-2026 Bahar Dönemi',
                'type' => 1,
                'status' => 1,
                'path' => '2025-2026-bahar-donemi',
                'start_time' => '2026-01-20',
                'end_time' => '2026-01-30',
                'is_started' => 1,
                'is_ended' => 0,
            ]);
        }

        $existingAnswers = ActiveAnswer::whereIn('educationType', ['ilkokul', 'ortaokul', 'lise'])
            ->with(['form.scholar'])
            ->get()
            ->filter(fn ($ans) => $ans->form && $ans->form->scholar)
            ->unique('form.scholar_id')
            ->take(40);

        $fileColumns = array_keys($this->activeAnswerFileColumns());
        $disk = Storage::disk('public');
        $processedCount = 0;
        $dummyPdfContent = '%PDF-1.4 %ÖÄÜß 1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj 2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj 3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] >> endobj xref 0 4 0000000000 65535 f 0000000015 00000 n 0000000068 00000 n 0000000135 00000 n trailer << /Size 4 /Root 1 0 R >> startxref 210 %%EOF';

        foreach ($existingAnswers as $oldAnswer) {
            $scholarId = $oldAnswer->form->scholar_id;

            $scholarForm = ScholarForm::firstOrCreate(
                [
                    'scholar_id' => $scholarId,
                    'period_id' => $periodId,
                ],
                [
                    'aday_id' => $oldAnswer->form->aday_id,
                    'islemi_yapan' => $oldAnswer->form->islemi_yapan ?? 'System',
                    'status' => $oldAnswer->form->status ?? 1,
                    'status_detail' => $oldAnswer->form->status_detail,
                ]
            );

            $activeAnswer = ActiveAnswer::where('form_id', $scholarForm->id)
                ->where('period_id', $periodId)
                ->first();

            if (! $activeAnswer) {
                $activeAnswer = $oldAnswer->replicate([
                    'id',
                    'created_at',
                    'updated_at',
                ]);
                $activeAnswer->form_id = $scholarForm->id;
                $activeAnswer->period_id = $periodId;
            }

            // Clear all file columns first to clean any old upload paths
            foreach ($fileColumns as $col) {
                $activeAnswer->$col = null;
            }

            // Set only test columns
            $activeAnswer->doc_fotograf = '/storage/bursiyerler/'.$scholarId.'/eski_foto.pdf';
            $activeAnswer->doc_transkript = '/storage/bursiyerler/'.$scholarId.'/eski_transkript.pdf';

            $activeAnswer->save();

            $scholarFolderRelative = 'bursiyerler/'.$scholarId;
            $disk->makeDirectory($scholarFolderRelative);

            // Clean existing files inside folder if any, then put test files
            $disk->put($scholarFolderRelative.'/eski_foto.pdf', $dummyPdfContent);
            $disk->put($scholarFolderRelative.'/eski_transkript.pdf', $dummyPdfContent);
            $disk->put($scholarFolderRelative.'/yeni_karne_2026.pdf', $dummyPdfContent);
            $disk->put($scholarFolderRelative.'/yeni_belge_2026.pdf', $dummyPdfContent);

            $processedCount++;
        }

        return response()->json([
            'status' => 'success',
            'message' => "Dönem {$periodId} için {$processedCount} bursiyerin test verileri ve storage dosyaları başarıyla sıfırlandı / oluşturuldu.",
            'count' => $processedCount,
        ]);
    }
}
