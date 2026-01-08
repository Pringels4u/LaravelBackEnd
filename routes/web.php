<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsFavoriteController;
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
Route::post('/news/{newsItem}/favorite', [NewsFavoriteController::class, 'toggle'])->name('news.favorite.toggle')->middleware('auth');
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin routes (grouped under /admin with name prefix 'admin.')
// Protected by both auth and admin middleware alias (see bootstrap/app.php)
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('news', NewsController::class)->except(['index', 'show']);
    Route::resource('faq', FaqController::class)->except(['index']);
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    // Admin user management
    Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('users/{user}/toggle-admin', [\App\Http\Controllers\Admin\UserController::class, 'toggleAdmin'])->name('users.toggleAdmin');
});



// Publieke profiel route
Route::get('/user/{user:username}', [UserController::class, 'show'])->name('user.show');

require __DIR__.'/auth.php';
