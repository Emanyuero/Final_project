<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JokeController;

Route::get('/joke', [JokeController::class, 'getJoke']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
