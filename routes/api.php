<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/server-time', function (Request $request) {
    return response()->json(['time' => now()->toIso8601String()]);
});

Route::apiResource('/transactions', \App\Http\Controllers\Api\TransactionsController::class)
    ->only(['index', 'update'])
    ->middleware(\App\Http\Middleware\AuthenticateApiKey::class);

Route::apiResource('/flagbits', \App\Http\Controllers\Api\FlagbitsController::class)
    ->only(['index', 'show'])
    ->middleware(\App\Http\Middleware\AuthenticateApiKey::class);

Route::put('/flagbits', [\App\Http\Controllers\Api\FlagbitsController::class, 'update'])
    ->middleware(\App\Http\Middleware\AuthenticateApiKey::class. ':master');

Route::delete('/flagbits/{refId}', [\App\Http\Controllers\Api\FlagbitsController::class, 'destroy'])
    ->middleware(\App\Http\Middleware\AuthenticateApiKey::class. ':master');
