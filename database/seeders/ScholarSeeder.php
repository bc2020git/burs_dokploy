<?php

namespace Database\Seeders;

use App\Models\Scholar;
use App\Models\ScholarForm;
use App\Models\ActiveAnswer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Period;
use App\Models\User;
use App\Models\NewAnswer;
class ScholarSeeder extends Seeder
{
    public function run()
    {
        // Örnek öğrenciler
        $scholars = [
            [
                'name' => 'Fatmanur ',
                'surname' => 'Ocalan',
                'email' => 'fatmanurocalan@gmail.com',
                'password' => Hash::make('ogrenci123'),
                'tc_no' => '12345678901',
                'tel_no' => '05555555555',
                'status' => 0,
            ],
            [
                'name' => 'Ayşe',
                'surname' => 'Demir',
                'email' => 'ayse.demir@example.com',
                'password' => Hash::make('ogrenci123'),
                'tc_no' => '12345678902',
                'tel_no' => '05555555556',
                'status' => 0,
            ],
            [
                'name' => 'Mehmet',
                'surname' => 'Kaya',
                'email' => 'mehmet.kaya@example.com',
                'password' => Hash::make('ogrenci123'),
                'tc_no' => '12345678903',
                'tel_no' => '05555555557',
                'status' => 1,
            ],
            [
                'name' => 'Can',
                'surname' => 'Kaya',
                'email' => 'can.kaya@example.com',
                'password' => Hash::make('ogrenci123'),
                'tc_no' => '12345678904',
                'tel_no' => '05555555558',
                'status' => 1,
            ],
            [
                'name' => 'Veli',
                'surname' => 'Kavlak',
                'email' => 'veli.kavlak@example.com',
                'password' => Hash::make('ogrenci123'),
                'tc_no' => '12345678905',
                'tel_no' => '05555555555',
                'status' => 1,
            ],
            [
                'name' => 'Oğuz',
                'surname' => 'Atay',
                'email' => 'oguz.atay@example.com',
                'password' => Hash::make('ogrenci123'),
                'tc_no' => '12345678906',
                'tel_no' => '05555555555',
                'status' => 2,
            ],
            [
                'name' => 'Mehmet',
                'surname' => 'Akif',
                'email' => 'mehmet.akif@example.com',
                'password' => Hash::make('ogrenci123'),
                'tc_no' => '12345678907',
                'tel_no' => '05555555555',
                'status' => 2,
            ],
            [
                'name' => 'Ali',
                'surname' => 'Yılmaz',
                'email' => 'ali.yilmaz@example.com',
                'password' => Hash::make('ogrenci123'),
                'tc_no' => '12345678908',
                'tel_no' => '05555555555',
                'status' => 3,
            ],
            [
                'name' => 'Ayşe',
                'surname' => 'Kılıç',
                'email' => 'ayse.kilic@example.com',
                'password' => Hash::make('ogrenci123'),
                'tc_no' => '12345678909',
                'tel_no' => '05555555555',
                'status' => 3,
            ],
            [
                'name' => 'Turgut',
                'surname' => 'Uyar',
                'email' => 'turgut.uyar@example.com',
                'password' => Hash::make('ogrenci123'),
                'tc_no' => '12345678910',
                'tel_no' => '05555555555',
                'status' => 4,
            ],
        ];

        foreach ($scholars as $scholarData) {
            $newAnswerCheck = NewAnswer::where('tc_no',$scholarData['tc_no'])->first();
            if($newAnswerCheck){
                $newAnswerCheck->email = $scholarData['email'];
                $newAnswerCheck->save();
                continue;
            }
            else{
                $newAnswer = new NewAnswer();
                $newAnswer->name = $scholarData['name'];
                $newAnswer->surname = $scholarData['surname'];
                $newAnswer->tc_no = $scholarData['tc_no'];
                $newAnswer->email = $scholarData['email'];
                $newAnswer->tel_no = $scholarData['tel_no'];
                $newAnswer->status = $scholarData['status'];
                $newAnswer->islemi_yapan = 'Admin';
                $newAnswer->educationType =  'lise';
                $newAnswer->save();
            }
            $scholarData['aday_id'] = $newAnswer->id;
            $user = User::first();
            // TC numarasına göre scholar'ı kontrol et
            $scholar = Scholar::firstOrCreate(
                ['tc_no' => $scholarData['tc_no']], // Arama kriteri
                $scholarData // Eğer bulunamazsa oluşturulacak veri
            );

            // Scholar'ın formu var mı kontrol et
            $form = ScholarForm::firstOrCreate(
                [
                    'scholar_id' => $scholar->id,
                    'period_id' => Period::where('status', 1)->where('type', 0)->first()->id
                ],
                [
                    'status' => 3,
                ]
            );

            // Form cevaplarını kontrol et
            ActiveAnswer::firstOrCreate(
                [
                    'form_id' => $form->id,
                    'tc_no' => $scholar->tc_no,
                ],
                [
                    'form_id' => $form->id,
                    'name' => $scholar->name,
                    'surname' => $scholar->surname,
                    'tc_no' => $scholar->tc_no,
                    'tel_no' => $scholar->tel_no,
                    'status' => $scholar->status,
                    'aday_turu' => 'Dernek',
                    'status' => 3,
                    'b_dob' => '1990-01-01',
                    'registered_city' => 'Seçiniz',
                    'registered_district' => 'Seçiniz',
                    'born_city' => 'Seçiniz',
                    'born_district' => 'Seçiniz',
                    'gender' => 'Erkek',
                    'maritality' => 'Evli',
                    'nationality' => 'Türkiye',
                    'educationType' => 'lise',

                ]
            );
        }
    }
}
