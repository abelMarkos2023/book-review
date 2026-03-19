<?php

use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Redirect root to tasks

Route::get('/after-login', function () {
    return redirect()->route('home');
})->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::resource('/books', AdminBookController::class);
    Route::resource('/users', AdminUserController::class)->only(['index', 'destroy']);

});
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Tasks routes – only accessible by authenticated users
Route::middleware('auth')->group(function () {
    // Review management
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

include __DIR__.'/auth.php';
