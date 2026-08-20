<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\EnvanterCikis;
use App\Models\EnvanterGiris;
use App\Models\Sube;
use App\Models\TeslimDokuman;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnvanterCikisTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function teslim_kisi_ad_sifrelenir_ve_dogruca_desifrelenir()
    {
        $envanter = EnvanterCikis::create([
            'teslim_kisi_ad' => 'Ahmet',
            // diğer zorunlu alanlar...
        ]);

        // Veritabanında şifreli mi?
        $raw = $envanter->getRawAttribute('teslim_kisi_ad');
        $this->assertNotEquals('Ahmet', $raw);

        // Modelden okunduğunda deşifrelenmiş mi?
        $this->assertEquals('Ahmet', $envanter->teslim_kisi_ad);
    }

    /** @test */
    public function envanter_iliskisi_dogru_calismali()
    {
        $giris = EnvanterGiris::factory()->create();
        $envanter = EnvanterCikis::create([
            'envanter_giris_id' => $giris->id,
            // diğer zorunlu alanlar...
        ]);
        $this->assertEquals($giris->id, $envanter->envanter->id);
    }
}
