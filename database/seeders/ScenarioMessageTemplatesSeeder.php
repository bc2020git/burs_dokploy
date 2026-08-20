<?php

namespace Database\Seeders;

use App\Models\MessageTemplate;
use Illuminate\Database\Seeder;

/**
 * "Belge Eksik" sebep metni için dört senaryo şablonu.
 * Başlıklar MessageTemplate çözümlemesi ile birebir: önek + "Belge Eksik".
 *
 * Çalıştırma: php artisan db:seed --class=ScenarioMessageTemplatesSeeder
 */
class ScenarioMessageTemplatesSeeder extends Seeder
{
    private const SEBEP = 'Belge Eksik';

    public function run(): void
    {
        $params = ['name', 'surname', 'sebep', 'aciklama'];

        MessageTemplate::updateOrCreate(
            ['slug' => 'aday-burs-iade-belge-eksik'],
            [
                'title' => 'Aday - Burs İade - '.self::SEBEP,
                'content' => $this->adayIadeHtml(),
                'parameters' => $params,
            ]
        );

        MessageTemplate::updateOrCreate(
            ['slug' => 'aday-burs-red-belge-eksik'],
            [
                'title' => 'Aday - Burs Red - '.self::SEBEP,
                'content' => $this->adayRedHtml(),
                'parameters' => $params,
            ]
        );

        MessageTemplate::updateOrCreate(
            ['slug' => 'kayit-yenileme-iade-belge-eksik'],
            [
                'title' => 'Kayıt Yenileme - İade - '.self::SEBEP,
                'content' => $this->kyIadeHtml(),
                'parameters' => $params,
            ]
        );

        MessageTemplate::updateOrCreate(
            ['slug' => 'kayit-yenileme-red-belge-eksik'],
            [
                'title' => 'Kayıt Yenileme - Red - '.self::SEBEP,
                'content' => $this->kyRedHtml(),
                'parameters' => $params,
            ]
        );
    }

    private function adayIadeHtml(): string
    {
        return <<<'HTML'
<div style="font-family: arial, helvetica, sans-serif; padding: 20px;">
    <p>Sayın _name_ _surname_,</p>
    <p>Burs başvurunuz <strong>belge eksikliği</strong> nedeniyle iade edilmiştir.</p>
    <p>Sebep: <strong>_sebep_</strong></p>
    <p>Açıklama: _aciklama_</p>
    <p>Eksik belgeleri tamamladığınızda süreç hakkında bilgilendirileceksiniz.</p>
    <p>Saygılarımızla,</p>
</div>
HTML;
    }

    private function adayRedHtml(): string
    {
        return <<<'HTML'
<div style="font-family: arial, helvetica, sans-serif; padding: 20px;">
    <p>Sayın _name_ _surname_,</p>
    <p>Burs başvurunuz <strong>belge eksikliği</strong> nedeniyle reddedilmiştir.</p>
    <p>Sebep: <strong>_sebep_</strong></p>
    <p>Açıklama: _aciklama_</p>
    <p>Saygılarımızla,</p>
</div>
HTML;
    }

    private function kyIadeHtml(): string
    {
        return <<<'HTML'
<div style="font-family: arial, helvetica, sans-serif; padding: 20px;">
    <p>Sayın _name_ _surname_,</p>
    <p>Kayıt yenileme başvurunuz <strong>belge eksikliği</strong> nedeniyle iade edilmiştir.</p>
    <p>Sebep: <strong>_sebep_</strong></p>
    <p>Açıklama: _aciklama_</p>
    <p>Eksik belgeleri tamamlamanızı rica ederiz.</p>
    <p>Saygılarımızla,</p>
</div>
HTML;
    }

    private function kyRedHtml(): string
    {
        return <<<'HTML'
<div style="font-family: arial, helvetica, sans-serif; padding: 20px;">
    <p>Sayın _name_ _surname_,</p>
    <p>Kayıt yenileme başvurunuz <strong>belge eksikliği</strong> nedeniyle reddedilmiştir.</p>
    <p>Sebep: <strong>_sebep_</strong></p>
    <p>Açıklama: _aciklama_</p>
    <p>Saygılarımızla,</p>
</div>
HTML;
    }
}
