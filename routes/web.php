<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PagesController;

Route::get('/', [PagesController::class, 'home']);
Route::get('/about', [PagesController::class, 'about']);
Route::get('/pegawai', [PegawaiController::class, 'index']);
Route::get('/pegawai/create', [PegawaiController::class, 'create']);
Route::post('/pegawai', [PegawaiController::class, 'store']);
Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy']);
Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit']);
Route::put('/pegawai/{id}', [PegawaiController::class, 'update']);