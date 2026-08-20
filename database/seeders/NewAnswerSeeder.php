<?php

namespace Database\Seeders;

use App\Models\NewAnswer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sample = NewAnswer::first();

        if (!$sample) {
            $this->command->error('Veritabanında örnek kayıt bulunamadı. Lütfen önce bir kayıt ekleyin.');
            return;
        }

        $names = ['Ali', 'Ayşe', 'Mehmet', 'Fatma', 'Can', 'Zeynep', 'Burak', 'Elif', 'Gökhan', 'Selin', 'Murat', 'Merve', 'Emre', 'Derya', 'Kaan'];
        $surnames = ['Yılmaz', 'Kaya', 'Demir', 'Çelik', 'Yıldız', 'Öztürk', 'Aydın', 'Özdemir', 'Arslan', 'Doğan', 'Şahin', 'Bulut', 'Yavuz'];

        for ($i = 0; $i < 20; $i++) {
            $newName = $names[array_rand($names)];
            $newSurname = $surnames[array_rand($surnames)];
            $newTc = (string)rand(10000000000, 99999999999);
            
            // TC No çakışmasını engellemek için kontrol
            while (NewAnswer::where('tc_no', $newTc)->exists()) {
                $newTc = (string)rand(10000000000, 99999999999);
            }

            $newRecord = $sample->replicate();
            $newRecord->name = $newName;
            $newRecord->surname = $newSurname;
            $newRecord->tc_no = $newTc;
            
            // Email genelde unique olduğu için rastgelelik ekliyoruz
            $newRecord->email = Str::lower(Str::slug($newName . $newSurname)) . rand(1000, 9999) . '@example.com';
            
            // Diğer muhtemel unique alanlar (varsa) temizlenebilir veya güncellenebilir
            
            $newRecord->save();
        }

        $this->command->info('20 adet yeni aday başarıyla oluşturuldu.');
    }
}
