<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\json;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to Dalil API']);
});


require __DIR__ . '/auth.php';
