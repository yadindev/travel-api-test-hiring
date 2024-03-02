<?php

use App\Models\User;

test('login retun token with valid credentials', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(405);
});

test('login returns error with invalid credentials', function () {

    $response = $this->postJson('/api/v1/login', [
        'email' => 'invalid@email.com',
        'password' => 'password',
    ]);

    $response->assertStatus(405);
});
