<?php

use Illuminate\Support\Facades\Route;
use Modules\Teste\Http\Controllers\TesteController;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('teste', TesteController::class)->names('teste');
});

Route::get('testea', function () {
    return Inertia::render('Teste::Welcome');
});