<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/server-time', function (Request $request) {
    return response()->json(['time' => now()->toIso8601String()]);
});

Route::apiResource('/transactions', \App\Http\Controllers\Api\TransactionsController::class)
    ->only(['index', 'update'])
    ->middleware(\App\Http\Middleware\AuthenticateApiKey::class);

