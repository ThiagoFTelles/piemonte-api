<?php

use App\Http\Controllers\Api\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('addresses', AddressController::class);
Route::get('/postal-code-search/{code}', [AddressController::class, 'postalCodeSarch']);
Route::get('/street-search/{state}/{city}/{street}', [AddressController::class, 'streetSearch']);