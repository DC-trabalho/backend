<?php

use Illuminate\Support\Facades\Route;
use Modules\Teste\Http\Controllers\TesteController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('teste', TesteController::class)->names('teste');
});
