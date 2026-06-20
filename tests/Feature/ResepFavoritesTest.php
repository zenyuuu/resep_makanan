<?php

namespace Tests\Feature;

use App\Models\Resep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResepFavoritesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: User dapat favorite resep
     */
    public function test_user_dapat_favorite_resep()
    {
        $user = buatUserBiasa();
        $resep = buatResep();

        $response = $this->actingAs($user)
            ->post(route('reseps.favorite', $resep));

        $response->assertStatus(302); // Redirect
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'resep_id' => $resep->id,
        ]);
    }

    /**
     * Test: Guest tidak dapat favorite resep
     */
    public function test_guest_tidak_dapat_favorite_resep()
    {
        $resep = buatResep();

        $response = $this->post(route('reseps.favorite', $resep));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: User dapat melihat halaman favorites mereka
     */
    public function test_user_dapat_melihat_halaman_favorites_mereka()
    {
        $user = buatUserBiasa();
        $resep = buatResep();

        // Favorite resep
        $user->favoritedReseps()->attach($resep->id);

        $response = $this->actingAs($user)
            ->get(route('reseps.favorites'));

        $response->assertStatus(200);
    }

    /**
     * Test: Guest tidak dapat akses halaman favorites
     */
    public function test_guest_tidak_dapat_akses_halaman_favorites()
    {
        $response = $this->get(route('reseps.favorites'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Favorites page menampilkan resep yang di-favorite
     */
    public function test_favorites_page_menampilkan_resep_yang_di_favorite()
    {
        $user = buatUserBiasa();
        $resep1 = buatResep(overrides: ['judul' => 'Resep 1']);
        $resep2 = buatResep(overrides: ['judul' => 'Resep 2']);

        // Favorite hanya resep1
        $user->favoritedReseps()->attach($resep1->id);

        $response = $this->actingAs($user)
            ->get(route('reseps.favorites'));

        $response->assertSee('Resep 1');
    }

    /**
     * Test: User dapat unfavorite resep dengan favorite ulang
     */
    public function test_user_dapat_unfavorite_resep_dengan_favorite_ulang()
    {
        $user = buatUserBiasa();
        $resep = buatResep();

        // Favorite
        $user->favoritedReseps()->attach($resep->id);
        $this->assertTrue($resep->isFavoritedBy($user));

        // Unfavorite (favorite ulang)
        $user->favoritedReseps()->toggle($resep->id);
        $this->assertFalse($resep->fresh()->isFavoritedBy($user));
    }

    /**
     * Test: Favorite counter akurat
     */
    public function test_favorite_counter_akurat()
    {
        $resep = buatResep();
        $users = User::factory()->count(3)->create();

        // Semua user favorite resep
        foreach ($users as $user) {
            $resep->favorites()->attach($user->id);
        }

        $this->assertCount(3, $resep->favorites);
    }
}
