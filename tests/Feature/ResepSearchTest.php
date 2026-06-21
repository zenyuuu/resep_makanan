<?php

namespace Tests\Feature;

use App\Models\Resep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResepSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: User dapat search resep berdasarkan judul
     */
    public function test_user_dapat_search_resep_berdasarkan_judul()
    {
        $user = buatUserBiasa();
        
        buatResep($user, ['judul' => 'Nasi Goreng']);
        buatResep($user, ['judul' => 'Mie Ayam']);
        buatResep($user, ['judul' => 'Nasi Kuning']);

        $response = $this->get(route('reseps.index', ['search' => 'Nasi']));

        $response->assertStatus(200);
        $response->assertSee('Nasi Goreng');
        $response->assertSee('Nasi Kuning');
    }

    /**
     * Test: User dapat search resep berdasarkan bahan
     */
    public function test_user_dapat_search_resep_berdasarkan_bahan()
    {
        $user = buatUserBiasa();
        
        buatResep($user, [
            'judul' => 'Resep 1',
            'bahan' => 'Daging sapi, Bawang',
        ]);
        buatResep($user, [
            'judul' => 'Resep 2',
            'bahan' => 'Telur, Kecap manis',
        ]);

        $response = $this->get(route('reseps.index', ['search' => 'Daging']));

        $response->assertStatus(200);
        $response->assertSee('Resep 1');
    }

    /**
     * Test: Search case-insensitive
     */
    public function test_search_case_insensitive()
    {
        $user = buatUserBiasa();
        buatResep($user, ['judul' => 'Nasi Goreng']);

        $response1 = $this->get(route('reseps.index', ['search' => 'nasi']));
        $response2 = $this->get(route('reseps.index', ['search' => 'NASI']));
        $response3 = $this->get(route('reseps.index', ['search' => 'NaSi']));

        $response1->assertSee('Nasi Goreng');
        $response2->assertSee('Nasi Goreng');
        $response3->assertSee('Nasi Goreng');
    }

    /**
     * Test: Search dengan query kosong menampilkan semua resep
     */
    public function test_search_dengan_query_kosong_menampilkan_semua_resep()
    {
        $user = buatUserBiasa();
        
        buatResep($user, ['judul' => 'Resep 1']);
        buatResep($user, ['judul' => 'Resep 2']);
        buatResep($user, ['judul' => 'Resep 3']);

        $response = $this->get(route('reseps.index'));

        $response->assertStatus(200);
        $this->assertGreaterThanOrEqual(3, $response->viewData('reseps')->count());
    }

    /**
     * Test: Search tidak menemukan hasil yang sesuai
     */
    public function test_search_tidak_menemukan_hasil()
    {
        $user = buatUserBiasa();
        buatResep($user, ['judul' => 'Nasi Goreng']);

        $response = $this->get(route('reseps.index', ['search' => 'Pizza']));

        $reseps = $response->viewData('reseps');
        $this->assertCount(0, $reseps->items());
    }

    /**
     * Test: Search dengan special characters
     */
    public function test_search_dengan_special_characters()
    {
        $user = buatUserBiasa();
        buatResep($user, ['judul' => "Resep's Special"]);

        $response = $this->get(route('reseps.index', ['search' => "'"]));

        $response->assertStatus(200);
    }
}
