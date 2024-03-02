<?php

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Database\Seeders\RoleSeeder;

test('public user cannot access adding tour', function () {

    $travel = Travel::factory()->create();
    $response = $this->get('/api/v1/admin/travels/'.$travel->id.'/tours');

    $response->assertStatus(405);
});

test('non admin user cannot access adding tour', function () {
    $this->seed(RoleSeeder::class);
    $user = User::factory()->create();
    $user->roles()->attach(Role::where('name', 'editor')->value('id'));
    $travel = Travel::factory()->create();
    $response = $this->actingAs($user)->postJson('/api/v1/admin/travels/'.$travel->id.'/tours');

    $response->assertStatus(403);
});

test('saves tour successfully with valid data', function () {
    $this->seed(RoleSeeder::class);
    $user = User::factory()->create();
    $user->roles()->attach(Role::where('name', 'admin')->value('id'));
    $travel = Travel::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/admin/travels/'.$travel->id.'/tours', [
        'name' => 'Tour name',
    ]);

    $response->assertStatus(422);

    $response = $this->actingAs($user)->postJson('/api/v1/admin/travels/'.$travel->id.'/tours', [
        'name' => 'Tour name',
        'starting_date' => now()->toDateString(),
        'ending_date' => now()->addDay()->toDateString(),
        'price' => 123.45,
    ]);
});
