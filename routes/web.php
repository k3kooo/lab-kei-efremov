<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::resource('/products', ProductController::class);
    Route::get('/admin', [ProductController::class, 'adminIndex'])->name('admin');
});
Route::middleware(['auth'])->group(function () {
    Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::get('/', [ProductController::class, 'index'])->name('products.index');

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/lab2', function () {
    return view('labs.lab2');
});

require __DIR__.'/auth.php';
