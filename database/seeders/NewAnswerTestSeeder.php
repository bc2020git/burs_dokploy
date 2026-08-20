<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewAnswer;
use Illuminate\Support\Facades\DB;

class NewAnswerTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Performans için transaction kullan
        DB::transaction(function () {
            $batchSize = 1000; // Her seferde 1000 kayıt ekle
            $totalRecords = 13000;
            
            for ($i = 1; $i <= $totalRecords; $i++) {
                $data[] = [
                    'name' => 'name' . $i,
                    'surname' => 'surname' . $i,
                    'tc_no' => str_pad($i, 10, '0', STR_PAD_LEFT), // 0000000001 formatında
                    'email' => 'email' . $i . '@yopmail.com',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // Her 1000 kayıtta bir veritabanına yaz
                if ($i % $batchSize == 0 || $i == $totalRecords) {
                    NewAnswer::insert($data);
                    $data = []; // Array'i temizle
                    
                    // İlerleme durumunu göster
                    $this->command->info("Eklenen kayıt sayısı: $i / $totalRecords");
                }
            }
        });
        
        $this->command->info('13000 test kaydı başarıyla eklendi!');
    }
}
