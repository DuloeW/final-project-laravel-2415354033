<?php

use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource("srvices", ServiceController::class);
Route::patch("/services/{service}/activate", [
    ServiceController::class, 
    "activate"
]);
Route::patch("/services/{service}/deactivate", [
    ServiceController::class, 
    "deactivate"
]);
