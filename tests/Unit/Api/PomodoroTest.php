<?php

use App\Models\Pomodoro;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

uses()->group('api');

beforeEach(function () {
    $this->user = User::factory()->create(['password' => Hash::make('password')]);
    Sanctum::actingAs($this->user);
});

it('can list Pomodoros for authenticated user', function () {
    Pomodoro::factory()->times(2)->create(['user_id' => $this->user->id]);
    // Pomodoro::factory()->create(['user_id' => $this->user->id]);

    $response = $this->getJson('/api/pomodoros');

    $response->assertStatus(200)
        ->assertJsonCount(2);
});

it('can retrieve a specific Pomodoro by UUID', function () {
    $pomodoro = Pomodoro::factory()->create(['user_id' => $this->user->id]);

    $response = $this->getJson('/api/pomodoros/' . $pomodoro->uuid);

    $response->assertStatus(200)
        ->assertJson(['uuid' => $pomodoro->uuid]);
});

it('returns generic error if Pomodoro with given UUID does not exist', function () {
    $nonExistingUuid = 'non-existing-uuid';

    $response = $this->getJson('/api/pomodoros/' . $nonExistingUuid);

    $response->assertStatus(404)
        ->assertJson(['message' => 'Pomodoro not found.']);
});