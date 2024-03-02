<?php

use App\Models\Tour;
use App\Models\Travel;

test('tour list by travel slug return correct tours', function () {
    $travel = Travel::factory()->create();
    $tour = Tour::factory()->create(['travel_id' => $travel->id]);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
    $response->assertJsonFragment(['id' => $tour->id]);
});

test('tour price is shown correctly', function () {
    $travel = Travel::factory()->create();
    Tour::factory()->create([
        'travel_id' => $travel->id,
        'price' => 123.45,
    ]);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
    $response->assertJsonFragment(['price' => '123.45']);
});

test('tour list returns pagination', function () {
    $travel = Travel::factory()->create();
    Tour::factory(16)->create(['travel_id' => $travel->id]);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

    $response->assertStatus(200);
    $response->assertJsonCount(15, 'data');
    $response->assertJsonPath('meta.last_page', 2);
});

test('tours list sorts by starting date correctly', function () {
    $travel = Travel::factory()->create();
    $laterTour = Tour::factory()->create([
        'travel_id' => $travel->id,
        'starting_date' => now()->addDays(2),
        'ending_date' => now()->addDays(3),
    ]);
    $earlierTour = Tour::factory()->create([
        'travel_id' => $travel->id,
        'starting_date' => now(),
        'ending_date' => now()->addDays(1),
    ]);

    $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');

    $response->assertStatus(200);
    $response->assertJsonPath('data.0.id', $earlierTour->id);
    $response->assertJsonPath('data.1.id', $laterTour->id);
});
