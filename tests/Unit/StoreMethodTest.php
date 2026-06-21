<?php
// tests/Unit/StoreMethodTest.php
// Unit Test: store() method — Basis Path Testing (V(G) = 5)

use App\Models\Resep;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// PATH 1: User login + ada gambar
test('[Path 1] store() menyimpan gambar dan resep jika user login dan ada file gambar', function () {
    Storage::fake('public');
    $user = buatUserBiasa();
    $file = UploadedFile::fake()->create('resep.jpg', 200, 'image/jpeg');

    $response = $this->actingAs($user)->post(route('reseps.store'), [
        'judul'   => 'Nasi Goreng',
        'bahan'   => 'Nasi, Telur',
        'langkah' => 'Panaskan minyak, masukkan telur, aduk nasi',
        'gambar'  => $file,
    ]);

    $response->assertRedirect(route('reseps.index'));
    $resep = Resep::first();
    expect($resep)->not->toBeNull();
    expect($resep->user_id)->toBe($user->id);
    Storage::disk('public')->assertExists($resep->gambar);
});

// PATH 2: User login + TIDAK ada gambar
test('[Path 2] store() menyimpan resep tanpa gambar jika user login', function () {
    $user = buatUserBiasa();

    $response = $this->actingAs($user)->post(route('reseps.store'), [
        'judul'   => 'Soto Ayam',
        'bahan'   => 'Ayam, Kunyit',
        'langkah' => 'Rebus ayam dengan rempah',
    ]);

    $response->assertRedirect(route('reseps.index'));
    $resep = Resep::first();
    expect($resep->gambar)->toBeNull();
    expect($resep->user_id)->toBe($user->id);
});

// PATH 3: Guest + env=local + DB kosong (User::first() = null)
test('[Path 3] store() membuat user dev jika env local dan DB user kosong', function () {
    // Pastikan tidak ada user di DB
    User::truncate();

    $response = $this->post(route('reseps.store'), [
        'judul'   => 'Resep Dev',
        'bahan'   => 'Bahan test',
        'langkah' => 'Langkah test',
    ]);

    // Di env testing (local), resep tetap tersimpan dengan user dev yang dibuat factory
    $response->assertRedirect(route('reseps.index'));
    expect(Resep::count())->toBe(1);
    expect(User::where('email', 'local@example.com')->exists())->toBeTrue();
});

// PATH 4: Guest + env=local + User::first() ada
test('[Path 4] store() menggunakan user pertama jika env local dan ada user di DB', function () {
    $existingUser = buatUserBiasa();

    $response = $this->post(route('reseps.store'), [
        'judul'   => 'Resep Local',
        'bahan'   => 'Bahan',
        'langkah' => 'Langkah',
    ]);

    $response->assertRedirect(route('reseps.index'));
    $resep = Resep::first();
    expect($resep->user_id)->toBe($existingUser->id);
});

// PATH 5: Guest + env=production → abort 403
test('[Path 5] store() mengembalikan 403 jika guest dan env bukan local', function () {
    // Simulasi env production dengan mocking app()->environment()
    app()->detectEnvironment(fn() => 'production');

    $response = $this->post(route('reseps.store'), [
        'judul'   => 'Resep Prod',
        'bahan'   => 'Bahan',
        'langkah' => 'Langkah',
    ]);

    $response->assertStatus(403);
});
