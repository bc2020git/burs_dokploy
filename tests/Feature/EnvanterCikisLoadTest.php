<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Artisan;
use App\Models\NewAnswer;

class EnvanterCikisControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */


    /** @test */
    public function sifreli_alanda_arama_dogru_sonuclar_doner()
    {
        $user = NewAnswer::factory()->create();
        $this->actingAs($user);

        NewAnswer::create([
            'name' => 'Veli',
            'tc' => '11111111111',
            // diğer zorunlu alanlar...
        ]);

        $response = $this->getJson(route('aday.data', ['name' => 'Veli']));
        $response->assertJsonFragment(['name' => 'Veli']);
    }


}
