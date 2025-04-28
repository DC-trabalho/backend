<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController; 

Route::middleware('guest')->group(function () {
    Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('socialite.redirect');
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('socialite.callback');
});