<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JokeController;

Route::get('/', [JokeController::class, 'home'])->name('home');
Route::get('/saved', [JokeController::class, 'saved'])->name('jokes.saved');
Route::get('/search', [JokeController::class, 'search'])->name('jokes.search');

// API route for getting joke
Route::get('/api/joke', [JokeController::class, 'getJoke']);

// API route for saving joke via AJAX POST
Route::post('/api/save', [JokeController::class, 'save'])->name('api.jokes.save');
