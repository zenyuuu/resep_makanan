<?php

namespace Tests\Feature;

use App\Models\Resep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResepAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Owner dapat edit resepnya sendiri
     */
    public function test_owner_dapat_edit_resepnya_sendiri()
    {
        $owner = buatUserBiasa();
        $resep = buatResep($owner, ['judul' => 'Resep Original']);

        $response = $this->actingAs($owner)
            ->get(route('reseps.edit', $resep));

        $response->assertStatus(200);
        $response->assertSee('Resep Original');
    }

    /**
     * Test: User lain tidak dapat edit resep milik owner
     */
    public function test_user_lain_tidak_dapat_edit_resep_milik_owner()
    {
        $owner = buatUserBiasa();
        $otherUser = buatUserDenganEmail('other@test.com');
        $resep = buatResep($owner);

        $response = $this->actingAs($otherUser)
            ->get(route('reseps.edit', $resep));

        $response->assertStatus(403);
    }

    /**
     * Test: Owner dapat delete resepnya sendiri
     */
    public function test_owner_dapat_delete_resepnya_sendiri()
    {
        $owner = buatUserBiasa();
        $resep = buatResep($owner);

        $this->actingAs($owner)
            ->delete(route('reseps.destroy', $resep))
            ->assertRedirect();

        $this->assertDatabaseMissing('reseps', ['id' => $resep->id]);
    }

    /**
     * Test: User lain tidak dapat delete resep milik owner
     */
    public function test_user_lain_tidak_dapat_delete_resep_milik_owner()
    {
        $owner = buatUserBiasa();
        $otherUser = buatUserDenganEmail('other@test.com');
        $resep = buatResep($owner);

        $response = $this->actingAs($otherUser)
            ->delete(route('reseps.destroy', $resep));

        $response->assertStatus(403);
        $this->assertDatabaseHas('reseps', ['id' => $resep->id]);
    }

    /**
     * Test: Guest tidak dapat edit resep apapun
     */
    public function test_guest_tidak_dapat_edit_resep_apapun()
    {
        $resep = buatResep();

        $response = $this->get(route('reseps.edit', $resep));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Guest tidak dapat delete resep apapun
     */
    public function test_guest_tidak_dapat_delete_resep_apapun()
    {
        $resep = buatResep();

        $response = $this->delete(route('reseps.destroy', $resep));

        $response->assertRedirect(route('login'));
    }
}
