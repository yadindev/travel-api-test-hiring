<?php

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Database\Seeders\RoleSeeder;

test('public user cannot access adding travel', function () {
    $response = $this->postJson('/api/v1/admin/travels');

    $response->assertStatus(401);
});

test('non admin user cannot access adding travel', function () {

    $this->seed(RoleSeeder::class);
    $user = User::factory()->create();
    $user->roles()->attach(Role::where('name', 'editor')->value('id'));
    $response = $this->actingAs($user)->postJson('/api/v1/admin/travels');

    $response->assertStatus(403);
});

test('save travel succefully with valid data', function () {

    $this->seed(RoleSeeder::class);
    $user = User::factory()->create();
    $user->roles()->attach(Role::where('name', 'admin')->value('id'));

    $response = $this->actingAs($user)->postJson('/api/v1/admin/travels', [
        'name' => 'Travel name',
    ]);
    $response->assertStatus(422);

    $response = $this->actingAs($user)->postJson('/api/v1/admin/travels', [
        'name' => 'Travel name',
        'is_public' => 1,
        'description' => 'Travel description',
        'number_of_days' => 4,
    ]);
    $response->assertStatus(201);
});

test('updates travel successfully with valid data', function () {
    $this->seed(RoleSeeder::class);
    $user = User::factory()->create();
    $user->roles()->attach(Role::where('name', 'editor')->value('id'));
    $travel = Travel::factory()->create();

    $response = $this->actingAs($user)->putJson('/api/v1/admin/travels/'.$travel->id, [
        'name' => 'Travel name updated',
    ]);
    $response->assertStatus(422);

    $response = $this->actingAs($user)->putJson('/api/v1/admin/travels/'.$travel->id, [
        'name' => 'Travel name updated',
        'is_public' => 1,
        'description' => 'Some description',
        'number_of_days' => 5,
    ]);
    $response->assertStatus(200);

    $response = $this->get('/api/v1/travels/');
    $response->assertJsonFragment(['name' => 'Travel name updated']);
});
