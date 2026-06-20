<?php

use App\Models\Resep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Helper Functions
|--------------------------------------------------------------------------
|
| Helper functions untuk mengurangi kode yang berulang dalam test.
| Sesuaikan dengan struktur model di aplikasi Anda.
|
*/

/**
 * Membuat user biasa untuk testing
 */
function buatUserBiasa(): User
{
    return User::create([
        'name' => 'User Test ' . uniqid(),
        'email' => 'user' . uniqid() . '@test.com',
        'password' => Hash::make('password123'),
    ]);
}

/**
 * Membuat user dengan email custom
 */
function buatUserDenganEmail(string $email): User
{
    return User::create([
        'name' => ucfirst(explode('@', $email)[0]),
        'email' => $email,
        'password' => Hash::make('password123'),
    ]);
}

/**
 * Membuat resep untuk testing
 */
function buatResep(User $user = null, array $overrides = []): Resep
{
    $user ??= buatUserBiasa();

    return Resep::factory()->create(array_merge([
        'user_id' => $user->id,
        'judul' => 'Resep Test',
        'bahan' => 'Bahan test',
        'langkah' => 'Langkah test',
    ], $overrides));
}

/**
 * Membuat beberapa resep sekaligus
 */
function buatBeberapaResep(int $count = 5, User $user = null): \Illuminate\Database\Eloquent\Collection
{
    $user ??= buatUserBiasa();

    return Resep::factory()->count($count)->create(['user_id' => $user->id]);
}
