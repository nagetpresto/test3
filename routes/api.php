<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Master\MasterUsersController;

Route::prefix('v1')->group(function () {
    //auth
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', function (Request $request) {return $request->user();})->middleware('auth:sanctum');

    //master user
    Route::put('/update-profile', [MasterUsersController::class, 'updateUserProfile'])->middleware('auth:sanctum');
    Route::post('/update-password', [MasterUsersController::class, 'updatePassword'])->middleware('auth:sanctum');

    //master kategori produk
});
