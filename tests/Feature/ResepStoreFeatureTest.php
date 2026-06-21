<?php

namespace Tests\Feature;

use App\Models\Resep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ResepStoreFeatureTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================
    // 1. GUEST - tidak bisa store
    // =========================================================

    public function test_guest_cannot_store_resep()
    {
        $response = $this->post(route('reseps.store'), [
            'judul'   => 'Nasi Goreng',
            'bahan'   => 'Nasi, Telur, Kecap',
            'langkah' => 'Panaskan minyak, masukkan nasi, aduk rata.',
        ]);

        // harus redirect ke login (302) atau forbidden
        $this->assertTrue(
            in_array($response->getStatusCode(), [301, 302, 303, 307, 308, 403]),
            'Guest seharusnya tidak bisa store, status: ' . $response->getStatusCode()
        );

        $this->assertDatabaseMissing('reseps', ['judul' => 'Nasi Goreng']);
    }

    // =========================================================
    // 2. STORE SUKSES - tanpa gambar
    // =========================================================

    public function test_authenticated_user_can_store_resep_without_image()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reseps.store'), [
            'judul'   => 'Mie Goreng',
            'bahan'   => 'Mie, Telur, Kecap Manis',
            'langkah' => 'Rebus mie, tumis bumbu, campur semua.',
        ]);

        $response->assertRedirect(route('reseps.index'));

        $this->assertDatabaseHas('reseps', [
            'judul'   => 'Mie Goreng',
            'user_id' => $user->id,
        ]);
    }

    // =========================================================
    // 3. STORE SUKSES - dengan gambar
    // =========================================================

    public function test_authenticated_user_can_store_resep_with_image()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reseps.store'), [
            'judul'   => 'Ayam Bakar',
            'bahan'   => 'Ayam, Bumbu Bakar, Kecap',
            'langkah' => 'Marinasi ayam, bakar hingga matang.',
            'gambar'  => UploadedFile::fake()->create('ayam.jpg', 500, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('reseps.index'));

        $resep = Resep::where('judul', 'Ayam Bakar')->first();

        $this->assertNotNull($resep);
        $this->assertEquals($user->id, $resep->user_id);
        Storage::disk('public')->assertExists($resep->gambar);
    }

    // =========================================================
    // 4. STORE SUKSES - gambar PNG
    // =========================================================

    public function test_store_resep_accepts_png_image()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)->post(route('reseps.store'), [
            'judul'   => 'Soto Ayam',
            'bahan'   => 'Ayam, Kunyit, Salam, Serai',
            'langkah' => 'Rebus ayam dengan bumbu hingga matang.',
            'gambar'  => UploadedFile::fake()->create('soto.png', 300, 'image/png'),
        ])->assertRedirect(route('reseps.index'));

        $resep = Resep::where('judul', 'Soto Ayam')->first();
        $this->assertNotNull($resep->gambar);
        Storage::disk('public')->assertExists($resep->gambar);
    }

    // =========================================================
    // 5. STORE SUKSES - resep tersimpan dengan user_id yang benar
    // =========================================================

    public function test_store_assigns_correct_user_id()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('reseps.store'), [
            'judul'   => 'Gado-Gado',
            'bahan'   => 'Sayuran, Tahu, Tempe, Saus Kacang',
            'langkah' => 'Rebus sayuran, siram dengan saus kacang.',
        ]);

        $resep = Resep::where('judul', 'Gado-Gado')->first();

        $this->assertNotNull($resep);
        $this->assertEquals($user->id, $resep->user_id);
    }

    // =========================================================
    // 6. VALIDASI - judul wajib diisi
    // =========================================================

    public function test_store_fails_when_judul_is_missing()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reseps.store'), [
            'bahan'   => 'Nasi, Telur',
            'langkah' => 'Masak sampai matang.',
        ]);

        $response->assertSessionHasErrors('judul');
        $this->assertDatabaseCount('reseps', 0);
    }

    // =========================================================
    // 7. VALIDASI - bahan wajib diisi
    // =========================================================

    public function test_store_fails_when_bahan_is_missing()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reseps.store'), [
            'judul'   => 'Nasi Uduk',
            'langkah' => 'Masak nasi dengan santan.',
        ]);

        $response->assertSessionHasErrors('bahan');
        $this->assertDatabaseCount('reseps', 0);
    }

    // =========================================================
    // 8. VALIDASI - langkah wajib diisi
    // =========================================================

    public function test_store_fails_when_langkah_is_missing()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reseps.store'), [
            'judul' => 'Nasi Kuning',
            'bahan' => 'Nasi, Kunyit, Santan',
        ]);

        $response->assertSessionHasErrors('langkah');
        $this->assertDatabaseCount('reseps', 0);
    }

    // =========================================================
    // 9. VALIDASI - judul max 255 karakter
    // =========================================================

    public function test_store_fails_when_judul_exceeds_max_length()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reseps.store'), [
            'judul'   => str_repeat('A', 256),
            'bahan'   => 'Bahan-bahan',
            'langkah' => 'Langkah-langkah memasak.',
        ]);

        $response->assertSessionHasErrors('judul');
        $this->assertDatabaseCount('reseps', 0);
    }

    // =========================================================
    // 10. VALIDASI - file bukan gambar ditolak
    // =========================================================

    public function test_store_fails_when_gambar_is_not_an_image()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reseps.store'), [
            'judul'   => 'Rawon',
            'bahan'   => 'Daging, Kluwak, Bumbu',
            'langkah' => 'Masak daging dengan bumbu rawon.',
            'gambar'  => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors('gambar');
        $this->assertDatabaseCount('reseps', 0);
    }

    // =========================================================
    // 11. VALIDASI - gambar melebihi ukuran 2MB
    // =========================================================

    public function test_store_fails_when_gambar_exceeds_max_size()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reseps.store'), [
            'judul'   => 'Rendang',
            'bahan'   => 'Daging, Santan, Bumbu Rendang',
            'langkah' => 'Masak daging dengan bumbu hingga kering.',
            'gambar'  => UploadedFile::fake()->create('besar.jpg', 3000, 'image/jpeg'), // 3MB
        ]);

        $response->assertSessionHasErrors('gambar');
        $this->assertDatabaseCount('reseps', 0);
    }

    // =========================================================
    // 12. STORE - gambar disimpan di folder reseps/
    // =========================================================

    public function test_store_saves_image_in_reseps_folder()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)->post(route('reseps.store'), [
            'judul'   => 'Bakso',
            'bahan'   => 'Daging Sapi, Tepung Kanji',
            'langkah' => 'Giling daging, bentuk bulat, rebus.',
            'gambar'  => UploadedFile::fake()->create('bakso.jpg', 200, 'image/jpeg'),
        ]);

        $resep = Resep::where('judul', 'Bakso')->first();

        $this->assertNotNull($resep->gambar);
        $this->assertStringStartsWith('reseps/', $resep->gambar);
        Storage::disk('public')->assertExists($resep->gambar);
    }

    // =========================================================
    // 13. STORE - redirect dengan pesan sukses
    // =========================================================

    public function test_store_redirects_with_success_message()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reseps.store'), [
            'judul'   => 'Opor Ayam',
            'bahan'   => 'Ayam, Santan, Bumbu Opor',
            'langkah' => 'Masak ayam dengan santan dan bumbu.',
        ]);

        $response->assertRedirect(route('reseps.index'));
        $response->assertSessionHas('success');
    }

    // =========================================================
    // 14. STORE - data tersimpan di database
    // =========================================================

    public function test_store_saves_all_fields_correctly_in_database()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('reseps.store'), [
            'judul'   => 'Pecel Lele',
            'bahan'   => 'Lele, Sambal Pecel, Lalapan',
            'langkah' => 'Goreng lele, sajikan dengan sambal dan lalapan.',
        ]);

        $this->assertDatabaseHas('reseps', [
            'judul'   => 'Pecel Lele',
            'bahan'   => 'Lele, Sambal Pecel, Lalapan',
            'langkah' => 'Goreng lele, sajikan dengan sambal dan lalapan.',
            'user_id' => $user->id,
        ]);
    }
}