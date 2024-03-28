<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a user', function () {
    $user = User::factory()->create();

    expect($user)->not->toBeNull();
});

it('can retrieve user settings as an array', function () {
    $user = User::factory()->create();

    expect($user->settings)->toBeArray();
});

it('has default settings when created', function () {
    $user = User::factory()->create();

    $defaultSettings = [
        'default' => true,
        'timer_duration' => 30,
    ];

    expect($user->settings)->toBe($defaultSettings);
});

it('can update user settings', function () {
    $user = User::factory()->create();
    $newSettings = [
        'default' => true,
        'timer_duration' => 30,
    ];

    $user->update(['settings' => $newSettings]);

    expect($user->settings)->toBe($newSettings);
});

it('can set and get specific settings', function () {
    $user = User::factory()->create();
    // $user->settings = [
    //     'default' => true,
    //     'timer_duration' => 30,
    // ];

    expect($user->settings['default'])->toBeTrue();
    expect($user->settings['timer_duration'])->toBe(30);
});

it('can access name attribute', function () {
    $user = User::factory()->create(['name' => 'John Doe']);

    expect($user->name)->toBe('John Doe');
});

it('can access email attribute', function () {
    $user = User::factory()->create(['email' => 'john@example.com']);

    expect($user->email)->toBe('john@example.com');
});

it('can access password attribute', function () {
    $plainTextPassword = 'password';
    $user = User::factory()->create(['password' => Hash::make($plainTextPassword)]);

    expect(Hash::check($plainTextPassword, $user->password))->toBeTrue();
});

it('can be deleted', function () {
    $user = User::factory()->create();

    $user->delete();

    expect(DB::table('users')->where('id', $user->id)->exists())->toBeFalse();
});