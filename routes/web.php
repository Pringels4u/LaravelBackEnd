<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\NewsController;

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

// Admin routes (beveiligd met middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin/news', NewsController::class)->except(['index', 'show']);
    Route::resource('admin/faq', FaqController::class)->except(['index']);
});

require __DIR__.'/auth.php';
