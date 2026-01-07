<?php

namespace Tests\Feature;

use App\Models\Resep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResepPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_is_paginated()
    {
        // create 25 reseps
        Resep::factory()->count(25)->create();

        $response = $this->get(route('reseps.index'));

        $reseps = $response->viewData('reseps');
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $reseps);
        $this->assertCount(9, $reseps->items());

        // page 3 should contain remaining 7 items
        $responsePage3 = $this->get(route('reseps.index', ['page' => 3]));
        $resepsPage3 = $responsePage3->viewData('reseps');
        $this->assertCount(7, $resepsPage3->items());
    }
}
