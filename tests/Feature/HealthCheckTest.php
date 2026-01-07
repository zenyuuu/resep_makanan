<?php

use function Pest\Laravel\getJson;

it('returns healthy status', function () {
    getJson(route('health'))
        ->assertOk()
        ->assertJson(['status' => 'ok']);
});
