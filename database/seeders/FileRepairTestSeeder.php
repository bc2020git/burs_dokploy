<?php

namespace Database\Seeders;

use App\Models\ActiveAnswer;
use App\Models\Period;
use App\Models\Scholar;
use App\Models\ScholarForm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileRepairTestSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Period 75 kontrol et veya oluştur
        $period = Period::find(75);
        if (! $period) {
            $period = Period::create([
                'id' => 75,
                'title' => '2025-2026 Bahar Dönemi',
                'type' => 1,
                'status' => 1,
                'path' => '2025-2026-bahar-donemi',
                'start_time' => '2026-01-20',
                'end_time' => '2026-01-30',
                'is_started' => 1,
                'is_ended' => 0,
            ]);
            $this->command->info('Period 75 oluşturuldu.');
        } else {
            $this->command->info('Period 75 mevcut: ' . $period->title);
        }

        // 2. ilkokul, ortaokul, lise türünde active_answers verisi olan benzersiz bursiyerleri bul
        $existingAnswers = ActiveAnswer::whereIn('educationType', ['ilkokul', 'ortaokul', 'lise'])
            ->with(['form.scholar'])
            ->get()
            ->filter(fn ($ans) => $ans->form && $ans->form->scholar)
            ->unique('form.scholar_id')
            ->take(40);

        if ($existingAnswers->count() < 40) {
            $this->command->warn('İlkokul/ortaokul/lise türünde yetersiz bursiyer bulundu: ' . $existingAnswers->count());
        }

        $this->command->info('İşlenecek bursiyer sayısı: ' . $existingAnswers->count());

        $disk = Storage::disk('public');
        $processedCount = 0;

        foreach ($existingAnswers as $oldAnswer) {
            $scholarId = $oldAnswer->form->scholar_id;

            // 3. scholar_forms kaydı oluştur / klonla (period_id = 75)
            $scholarForm = ScholarForm::firstOrCreate(
                [
                    'scholar_id' => $scholarId,
                    'period_id' => 75,
                ],
                [
                    'aday_id' => $oldAnswer->form->aday_id,
                    'islemi_yapan' => $oldAnswer->form->islemi_yapan ?? 'Seeder',
                    'status' => $oldAnswer->form->status ?? 1,
                    'status_detail' => $oldAnswer->form->status_detail,
                ]
            );

            // 4. active_answers kaydı oluştur / klonla (period_id = 75)
            $activeAnswer = ActiveAnswer::where('form_id', $scholarForm->id)
                ->where('period_id', 75)
                ->first();

            if (! $activeAnswer) {
                $activeAnswer = $oldAnswer->replicate([
                    'id',
                    'created_at',
                    'updated_at',
                ]);
                $activeAnswer->form_id = $scholarForm->id;
                $activeAnswer->period_id = 75;
            }

            // Dosya yollarını sıfırla ve sadece silinecek 2 eski dosya yolunu ekle
            $activeAnswer->doc_fotograf = '/storage/bursiyerler/' . $scholarId . '/eski_foto.pdf';
            $activeAnswer->doc_transkript = '/storage/bursiyerler/' . $scholarId . '/eski_transkript.pdf';
            $activeAnswer->doc_Karne = null;
            $activeAnswer->doc_ogrenciBelgesi = null;
            $activeAnswer->doc_kimlik = null;

            $activeAnswer->save();

            // 5. Fiziksel dosya yapısını storage/bursiyerler/{scholar_id}/ klasöründe hazırlayalım
            $scholarFolderRelative = 'bursiyerler/' . $scholarId;
            $disk->makeDirectory($scholarFolderRelative);

            // Eski dosyalar (DB sütunlarında tanımlı olan ve silinecek dosyalar)
            $dummyPdfContent = '%PDF-1.4 %ÖÄÜß 1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj 2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj 3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] >> endobj xref 0 4 0000000000 65535 f 0000000015 00000 n 0000000068 00000 n 0000000135 00000 n trailer << /Size 4 /Root 1 0 R >> startxref 210 %%EOF';
            
            $disk->put($scholarFolderRelative . '/eski_foto.pdf', $dummyPdfContent);
            $disk->put($scholarFolderRelative . '/eski_transkript.pdf', $dummyPdfContent);

            // Yeni candidate dosyalar (Seçilen tarih aralığında bulunacak 2 yeni yüklenmiş dosya)
            $disk->put($scholarFolderRelative . '/yeni_karne_2026.pdf', $dummyPdfContent);
            $disk->put($scholarFolderRelative . '/yeni_belge_2026.pdf', $dummyPdfContent);

            $processedCount++;
        }

        $this->command->info("Başarıyla {$processedCount} adet bursiyer için period_id=75 verileri ve storage dosyaları oluşturuldu.");
    }
}
