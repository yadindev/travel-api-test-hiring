<?php

use App\Models\Travel;

test('travel list returns a paginated data correctly', function () {

    Travel::factory(16)->create(['is_public' => true]);

    $response = $this->get('/api/v1/travels');

    $response->assertStatus(200);
    $response->assertJsonCount(15, 'data');
    $response->assertJsonPath('meta.last_page', 2);
});

test('travel list shows only public recods', function () {

    $publicTravel = Travel::factory()->create(['is_public' => true]);
    Travel::factory()->create(['is_public' => false]);

    $response = $this->get('/api/v1/travels');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
    $response->assertJsonPath('data.0.name', $publicTravel->name);
});
