<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

use App\Http\Controllers\MercadoPagoController; 

Route::get('/checkout', [MercadoPagoController::class, 'checkout'])->name('mercadopago.checkout');
Route::get('/checkout/success', [MercadoPagoController::class, 'success'])->name('mercadopago.success');
Route::get('/checkout/pending', [MercadoPagoController::class, 'pending'])->name('mercadopago.pending');
Route::get('/checkout/failure', [MercadoPagoController::class, 'failure'])->name('mercadopago.failure');

require __DIR__.'/auth.php';