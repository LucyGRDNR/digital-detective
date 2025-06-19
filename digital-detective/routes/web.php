<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\GameController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [StoryController::class, 'index'])->name('home');
Route::post('/language-switch', [LanguageController::class, 'switchLanguage'])->name('language.switch');
Route::get('/stories/{story}', [StoryController::class, 'show'])->name('stories.show');


Route::middleware(['auth'])->group(function () {
    Route::get('/chapter/{chapter}', [GameController::class, 'loadChapter']);
    Route::post('/submit-answer/{chapter}', [GameController::class, 'submitAnswer'])->name('submit.answer');
    Route::get('/play/{story}', [GameController::class, 'play'])->name('play.story');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/story/create', [StoryController::class, 'create'])->name('story.create');
        Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
        Route::get('/stories/{story}/edit', [StoryController::class, 'edit'])->name('stories.edit');
        Route::put('/stories/{story}', [StoryController::class, 'update'])->name('stories.update');
        Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
    });

});