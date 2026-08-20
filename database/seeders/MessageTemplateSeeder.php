<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MessageTemplate;

class MessageTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Başvuru Maili şablonu oluştur
        MessageTemplate::create([
            'title' => 'Başvuru Maili',
            'slug' => 'basvuru-maili',
            'content' => '<div style="font-family: arial, helvetica, sans-serif; background-color: #0a783d; color: #ffffff; padding: 20px; text-align: justify;">
                <div style="margin-bottom: 10px;">
                    <strong>Sayın {{name}} {{surname}} ;</strong>
                </div>
                
                <div style="margin-bottom: 15px;"></div>
                
                <div style="margin-bottom: 10px;">
                    Mülakat sonucu burs almaya hak kazandınız, tebrikler.
                </div>
                
                <div style="margin-bottom: 10px;">
                    Başarılarınızın devamını dileriz!...
                </div>
                
                <div style="margin-bottom: 15px;"></div>
                
                <div style="margin-bottom: 10px;">
                    Sevgilerimizle,
                </div>
                
                <div style="margin-bottom: 15px;"></div>
                
                <div style="margin-bottom: 5px;">
                    <strong>Süreyya Ağaoğlu Çocuk Dostları Derneği</strong>
                </div>
                
                <div>
                    <strong>Süreyya Ağaoğlu Eğitim ve Öğretim Vakfı</strong>
                </div>
            </div>',
            'parameters' => json_encode(['name', 'surname'])
        ]);
    }
}
