<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IuranDonasiController;
use App\Http\Controllers\BuktiTransferController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/berita/{id}', [BeritaController::class, 'show']);
Route::post('/berita', [BeritaController::class, 'store']);
Route::put('/berita/{id}', [BeritaController::class, 'update']);
Route::delete('/berita/{id}', [BeritaController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/iurandonasi', [IuranDonasiController::class, 'index']);
    Route::post('/iurandonasi', [IuranDonasiController::class, 'store']);
    Route::put('/iurandonasi/{id}', [IuranDonasiController::class, 'update']);
    Route::delete('/iurandonasi/{id}', [IuranDonasiController::class, 'destroy']);
        Route::get('/iurandonasi/{id}', [IuranDonasiController::class, 'show']);
});

Route::post('/bukti-transfer', [BuktiTransferController::class, 'store'])->middleware('auth:sanctum');