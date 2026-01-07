<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ResepValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_requires_required_fields()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('reseps.store'), [
                // missing judul
                'bahan' => 'Bahan',
                'langkah' => 'Langkah'
            ])
            ->assertSessionHasErrors('judul');
    }

    public function test_store_rejects_invalid_image()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('reseps.store'), [
                'judul' => 'Test',
                'bahan' => 'Bahan',
                'langkah' => 'Langkah',
                'gambar' => UploadedFile::fake()->create('doc.txt', 100, 'text/plain')
            ])
            ->assertSessionHasErrors('gambar');
    }
}
