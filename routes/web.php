<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TextController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route(Auth::check() ? 'home' : 'about'));
Route::get('/about', AboutController::class)->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/home', HomeController::class)->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('texts', TextController::class)->only(['store', 'update', 'destroy']);
    Route::resource('medias', MediaController::class)->only(['store', 'destroy']);
});

require __DIR__ . '/auth.php';
