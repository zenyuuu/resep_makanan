<?php

namespace Tests\Unit;

use App\Models\Resep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResepModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Resep memiliki relasi ke User
     */
    public function test_resep_memiliki_relasi_ke_user()
    {
        $user = User::factory()->create();
        $resep = Resep::factory()->create(['user_id' => $user->id]);

        expect($resep->user)->not->toBeNull();
        expect($resep->user->id)->toBe($user->id);
    }

    /**
     * Test: Resep memiliki semua field yang diperlukan
     */
    public function test_resep_memiliki_field_yang_diperlukan()
    {
        $user = User::factory()->create();
        $resep = Resep::factory()->create([
            'user_id' => $user->id,
            'judul' => 'Nasi Goreng',
            'bahan' => 'Nasi, Telur, Kecap Manis',
            'langkah' => 'Panaskan minyak, masukkan telur, campur nasi',
        ]);

        expect($resep->judul)->toBe('Nasi Goreng');
        expect($resep->bahan)->toContain('Telur');
        expect($resep->langkah)->toContain('minyak');
    }

    /**
     * Test: isFavoritedBy mengembalikan true jika user sudah favorite
     */
    public function test_isFavoritedBy_mengembalikan_true_jika_user_favorite()
    {
        $user = User::factory()->create();
        $resep = Resep::factory()->create();

        // Tambah ke favorite
        $resep->favorites()->attach($user->id);

        expect($resep->isFavoritedBy($user))->toBeTrue();
    }

    /**
     * Test: isFavoritedBy mengembalikan false jika user belum favorite
     */
    public function test_isFavoritedBy_mengembalikan_false_jika_user_tidak_favorite()
    {
        $user = User::factory()->create();
        $resep = Resep::factory()->create();

        expect($resep->isFavoritedBy($user))->toBeFalse();
    }

    /**
     * Test: Resep dapat memiliki banyak user yang favorite
     */
    public function test_resep_dapat_memiliki_banyak_favorites()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();
        $resep = Resep::factory()->create();

        $resep->favorites()->attach([$user1->id, $user2->id, $user3->id]);

        expect($resep->favorites()->count())->toBe(3);
        expect($resep->isFavoritedBy($user1))->toBeTrue();
        expect($resep->isFavoritedBy($user2))->toBeTrue();
        expect($resep->isFavoritedBy($user3))->toBeTrue();
    }

    /**
     * Test: Resep dapat di-favorite dan di-unfavorite
     */
    public function test_resep_dapat_di_favorite_dan_di_unfavorite()
    {
        $user = User::factory()->create();
        $resep = Resep::factory()->create();

        // Favorite
        $resep->favorites()->attach($user->id);
        expect($resep->isFavoritedBy($user))->toBeTrue();

        // Unfavorite
        $resep->favorites()->detach($user->id);
        expect($resep->isFavoritedBy($user))->toBeFalse();
    }

    /**
     * Test: User yang membuat resep dapat diakses
     */
    public function test_user_pembuat_resep_dapat_diakses()
    {
        $user = buatUserBiasa();
        $resep = buatResep($user, ['judul' => 'Resep Spesial']);

        expect($resep->user)->not->toBeNull();
        expect($resep->user->id)->toBe($user->id);
        expect($resep->user->name)->toBe($user->name);
    }

    /**
     * Test: Resep fillable bekerja dengan benar
     */
    public function test_resep_fillable_bekerja_dengan_benar()
    {
        $user = User::factory()->create();
        
        $resep = Resep::create([
            'judul' => 'Soto Ayam',
            'bahan' => 'Ayam, Kunyit, Jahe',
            'langkah' => 'Rebus ayam dengan rempah',
            'user_id' => $user->id,
        ]);

        expect($resep->judul)->toBe('Soto Ayam');
        expect($resep->user_id)->toBe($user->id);
    }
}
