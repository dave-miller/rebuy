<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('auth:sanctum')->namespace('App\Http\Controllers\API')->group(function () {
        Route::get('/pomodoros/{uuid}', 'PomodoroController@show');
        Route::get('/pomodoros', 'PomodoroController@index');
    });


    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/login', [AuthController::class, 'login']);