<?php

use App\Models\Pomodoro;
use App\Models\User;
use App\Models\PomodoroType;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('can create a Pomodoro', function () {
    $pomodoro = Pomodoro::factory()->create(['user_id' => $this->user->id]);

    expect($pomodoro)->not->toBeNull();
});

it('can set and get specific settings', function () {
    $pomodoro = Pomodoro::factory()->create(['user_id' => $this->user->id]);
    $pomodoro->settings = [
        'default' => true,
        'timer_duration' => 45,
    ];

    expect($pomodoro->settings['default'])->toBeTrue();
    expect($pomodoro->settings['timer_duration'])->toBe(45);
});

it('can access user_id attribute', function () {
    $pomodoro = Pomodoro::factory()->create(['user_id' => $this->user->id]);

    expect($pomodoro->user_id)->toBe($this->user->id);
});

it('can access pomodoro_type_id attribute', function () {
    $type = PomodoroType::all()->random()->id;
    $pomodoro = Pomodoro::factory()->create([
        'user_id' => $this->user->id,
        'type_id' => $type
    ]);

    expect($pomodoro->type_id)->toBe($type);
});

it('can access is_active attribute', function () {
    $pomodoro = Pomodoro::factory()->create([
        'user_id' => $this->user->id,
        'is_active' => true
    ]);

    expect($pomodoro->is_active)->toBeTrue();
});

it('can access duration attribute', function () {
    $pomodoro = Pomodoro::factory()->create([
        'user_id' => $this->user->id,
        'duration' => $this->user->settings['timer_duration']
    ]);

    expect($pomodoro->duration)->toBe( $this->user->settings['timer_duration'] );
});

// it('can be deleted', function () {
//     $pomodoro = Pomodoro::factory()->create();

//     $pomodoro->delete();

//     expect($pomodoro)->toBeDeleted();
// });
