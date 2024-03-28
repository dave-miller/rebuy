<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

uses()->group('api');

it('can authenticate user and return token', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['token']);
});

it('fails to authenticate with invalid credentials', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'wrong_password',
    ]);

    $response->assertStatus(422)
        ->assertJson(['message' => 'The provided credentials are incorrect.']);
});

it('can access protected route with valid token', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->getJson('/api/user');
    $response->assertStatus(200);
});

it('fails to access protected route without token', function () {
    $response = $this->getJson('/api/user');
    $response->assertStatus(401)
        ->assertJson(['message' => 'Unauthenticated.']);
});
