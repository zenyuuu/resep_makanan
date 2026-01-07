<?php

namespace Tests\Feature;

use App\Models\Resep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResepPolicyEdgeCaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_resep_deleted_when_owner_deleted()
    {
        // if a user is deleted, their reseps should be cascade-deleted (db constraint)
        $user = User::factory()->create();
        $resep = Resep::factory()->create(['user_id' => $user->id]);

        $user->delete();

        $this->assertDatabaseMissing('reseps', ['id' => $resep->id]);
    }
}
