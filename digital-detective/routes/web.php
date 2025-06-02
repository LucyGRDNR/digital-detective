<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\WelcomeController;

Route::get('/story/{storyId}', [StoryController::class, 'show'])->name('show.story');

Route::get('/play/{story}', [GameController::class, 'play'])->name('play.story');

Route::get('/chapter/{chapter}', [GameController::class, 'loadChapter']);

Route::post('/submit-answer/{chapter}', [GameController::class, 'submitAnswer'])->name('submit.answer');

Route::get('/', [WelcomeController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
