<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController; // <--- This line was missing!
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return redirect()->route('tweets.index');
    })->name('dashboard');
    

    // Tweet Routes
    Route::resource('tweets', TweetController::class)
        ->only(['index', 'store', 'edit', 'update', 'destroy']);

    // Like Route
    Route::post('/tweets/{tweet}/like', [TweetController::class, 'like'])->name('tweets.like');

    // Profile Routes (Breeze Defaults)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Profile Route (Feature 4)
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});

require __DIR__.'/auth.php';