<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Publieke routes (voor iedereen zichtbaar)
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{newsItem}', [NewsController::class, 'show'])->name('news.show');

// Admin routes (Voor nu even alleen op auth, we voegen de admin-check zo toe)
Route::middleware(['auth'])->group(function () {
    Route::resource('admin/news', NewsController::class)->except(['index', 'show']);
    Route::resource('admin/faq', FaqController::class)->except(['index']);
});



// Publieke profiel route
Route::get('/user/{user:username}', [UserController::class, 'show'])->name('user.show');

require __DIR__.'/auth.php';
