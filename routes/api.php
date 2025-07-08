<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/server-time', function () {
    return response()->json(['time' => now()->toIso8601String()]);
});
