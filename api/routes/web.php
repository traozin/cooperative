<?php

use App\Http\Controllers\CooperadoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('api.ping');
});

Route::prefix('api/v1')->group(function () {    
    Route::get('ping', function () {
        $start = hrtime(true);
        usleep(1000);
        $elapsed = (hrtime(true) - $start) / 1e+6;
        return response()->json(['message' => 'Pong! ' . round($elapsed, 2) . 'ms']);
    })->name('api.ping');

    // Define API resource routes for cooperados
    Route::apiResource('cooperados', CooperadoController::class);
});

