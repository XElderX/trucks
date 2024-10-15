<?php

use App\Http\Controllers\TruckController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'trucks'], function () {
    Route::get('/', [TruckController::class, 'browse']);
    Route::post('/', [TruckController::class, 'create']);
    Route::put('/{id}', [TruckController::class, 'update']);  // Use PUT or PATCH for updates
    Route::delete('/{id}', [TruckController::class, 'delete']);
});
