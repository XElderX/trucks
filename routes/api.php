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
    Route::get('/{id}', [TruckController::class, 'read']);
    Route::put('/{id}', [TruckController::class, 'update']);
    Route::delete('/{id}', [TruckController::class, 'delete']);
});
