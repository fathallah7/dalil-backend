<?php

use App\Http\Controllers\LinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\json;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('links', LinkController::class);

});


require __DIR__ . '/auth.php';
