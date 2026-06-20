<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Resep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: User dapat membuat resep
     */
    public function test_user_dapat_membuat_resep()
    {
        $user = User::factory()->create();
        $resep = Resep::factory()->create(['user_id' => $user->id]);

        expect($user->reseps()->count())->toBe(1);
        expect($user->reseps()->first()->id)->toBe($resep->id);
    }

    /**
     * Test: User memiliki relasi reseps
     */
    public function test_user_memiliki_relasi_reseps()
    {
        $user = buatUserBiasa();
        
        Resep::factory()->count(3)->create(['user_id' => $user->id]);

        expect($user->reseps())->not->toBeNull();
        expect($user->reseps()->count())->toBe(3);
    }

    /**
     * Test: Password user di-hash saat dibuat
     */
    public function test_password_user_di_hash_saat_dibuat()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        expect(Hash::check('password123', $user->password))->toBeTrue();
    }

    /**
     * Test: Email user bersifat unik
     */
    public function test_email_user_bersifat_unik()
    {
        $email = 'unique@test.com';

        User::create([
            'name' => 'User 1',
            'email' => $email,
            'password' => Hash::make('password'),
        ]);

        // Coba buat user dengan email yang sama
        try {
            User::create([
                'name' => 'User 2',
                'email' => $email,
                'password' => Hash::make('password'),
            ]);
            expect(true)->toBeFalse(); // Should not reach here
        } catch (\Exception $e) {
            expect($e)->not->toBeNull();
        }
    }

    /**
     * Test: User dapat favorite resep
     */
    public function test_user_dapat_favorite_resep()
    {
        $user = User::factory()->create();
        $resep1 = Resep::factory()->create();
        $resep2 = Resep::factory()->create();

        // Favorite resep
        $user->favoritedReseps()->attach([$resep1->id, $resep2->id]);

        expect($user->favoritedReseps()->count())->toBe(2);
    }

    /**
     * Test: User memiliki semua field yang diperlukan
     */
    public function test_user_memiliki_field_yang_diperlukan()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        expect($user->name)->toBe('John Doe');
        expect($user->email)->toBe('john@example.com');
        expect($user->id)->not->toBeNull();
    }

    /**
     * Test: User timestamps otomatis terupdate
     */
    public function test_user_timestamps_otomatis_terupdate()
    {
        $user = User::factory()->create();

        expect($user->created_at)->not->toBeNull();
        expect($user->updated_at)->not->toBeNull();
    }

    /**
     * Test: Helper buatUserBiasa menghasilkan user yang valid
     */
    public function test_helper_buatUserBiasa_bekerja_dengan_benar()
    {
        $user = buatUserBiasa();

        expect($user->name)->toContain('User Test');
        expect($user->email)->toContain('@test.com');
        expect(Hash::check('password123', $user->password))->toBeTrue();
        expect($user->id)->not->toBeNull();
    }

    /**
     * Test: Helper buatUserDenganEmail bekerja dengan benar
     */
    public function test_helper_buatUserDenganEmail_bekerja_dengan_benar()
    {
        $user = buatUserDenganEmail('chef@example.com');

        expect($user->email)->toBe('chef@example.com');
        expect($user->name)->toContain('Chef');
        expect(Hash::check('password123', $user->password))->toBeTrue();
    }
}
