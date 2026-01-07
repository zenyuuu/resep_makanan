<?php

namespace Tests\Feature;

use App\Models\Resep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ResepCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_index_and_show()
    {
        $resep = Resep::factory()->create();

        $this->get(route('reseps.index'))->assertOk();
        $this->get(route('reseps.show', $resep))->assertOk();
    }

    public function test_guests_cannot_access_protected_routes()
    {
        $resep = Resep::factory()->create();

        $respCreate = $this->get(route('reseps.create'));
        $this->assertTrue(in_array($respCreate->getStatusCode(), [301, 302, 303, 307, 308, 404]), 'Unexpected status for create: ' . $respCreate->getStatusCode());

        $respStore = $this->post(route('reseps.store'), []);
        $this->assertTrue(in_array($respStore->getStatusCode(), [301, 302, 303, 307, 308, 404]), 'Unexpected status: ' . $respStore->getStatusCode());

        $respEdit = $this->get(route('reseps.edit', $resep));
        $respEdit->assertRedirect(route('login'));

        $respUpdate = $this->put(route('reseps.update', $resep), []);
        $respUpdate->assertRedirect(route('login'));

        $respDestroy = $this->delete(route('reseps.destroy', $resep));
        $respDestroy->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_resep_with_image()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('reseps.store'), [
                'judul' => 'Nasi Goreng',
                'bahan' => 'Nasi, Telur',
                'langkah' => 'Masak semua',
                'gambar' => UploadedFile::fake()->create('makanan.jpg', 200, 'image/jpeg'),
            ])
            ->assertRedirect(route('reseps.index'));

        $this->assertDatabaseHas('reseps', ['judul' => 'Nasi Goreng', 'user_id' => $user->id]);
        $resep = Resep::first();
        Storage::disk('public')->assertExists($resep->gambar);
    }

    public function test_owner_can_update_and_replace_image_and_non_owner_denied()
    {
        Storage::fake('public');

        $owner = User::factory()->create();
        $other = User::factory()->create();

        // owner creates with image
        $this->actingAs($owner)
            ->post(route('reseps.store'), [
                'judul' => 'Sate',
                'bahan' => 'Daging',
                'langkah' => 'Tusuk dan bakar',
                'gambar' => UploadedFile::fake()->create('sate.jpg', 200, 'image/jpeg'),
            ]);

        $resep = Resep::first();
        $oldPath = $resep->gambar;

        // non-owner cannot update
        $this->actingAs($other)
            ->put(route('reseps.update', $resep), [
                'judul' => 'Sate Updated',
                'bahan' => 'Daging updated',
                'langkah' => 'Langkah updated',
            ])
            ->assertForbidden();

        // owner updates with new image
        $this->actingAs($owner)
            ->put(route('reseps.update', $resep), [
                'judul' => 'Sate Updated',
                'bahan' => 'Daging updated',
                'langkah' => 'Langkah updated',
                'gambar' => UploadedFile::fake()->create('sate2.jpg', 200, 'image/jpeg'),
            ])
            ->assertRedirect(route('reseps.index'));

        $resep->refresh();
        Storage::disk('public')->assertExists($resep->gambar);
        // old image should be deleted
        Storage::disk('public')->assertMissing($oldPath);
    }

    public function test_owner_can_delete_resep_and_image_removed()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('reseps.store'), [
                'judul' => 'Sup',
                'bahan' => 'Air, sayur',
                'langkah' => 'Rebus',
                'gambar' => UploadedFile::fake()->create('sup.jpg', 200, 'image/jpeg'),
            ]);

        $resep = Resep::first();
        $path = $resep->gambar;

        $this->actingAs($user)
            ->delete(route('reseps.destroy', $resep))
            ->assertRedirect(route('reseps.index'));

        $this->assertDatabaseMissing('reseps', ['id' => $resep->id]);
        Storage::disk('public')->assertMissing($path);
    }
}

