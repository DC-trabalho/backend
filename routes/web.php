<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::redirect('/dashboard', '/');

Route::middleware([
    'verified',
])->group(function () {

    Route::get('/', function () {
        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    })->name('home');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
});

Route::get('/category/{category}', function ($category) {
    return Inertia::render('Category', [
        'category' => $category,
    ]);
})->name('category');


Route::get('/product/{product}', function ($product) {
    return Inertia::render('Product', [
        'product' => $product,
    ]);
})->name('product');

Route::get('/profile/cart', function () {
    return Inertia::render('Profile/Cart');
})->name('cart');

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);

require __DIR__ . '/auth.php';
