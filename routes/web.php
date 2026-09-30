<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;

// Halaman Mahasiswa
Route::get('/', [MenuController::class, 'index']);
Route::get('/menu', [MenuController::class, 'index']);

// Pemesanan
Route::post('/order', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);
Route::put('/order/{id}/status', [OrderController::class, 'updateStatus']);

// Kelola Menu (Admin)
Route::get('/admin/menu', [MenuController::class, 'adminIndex']);
Route::get('/admin/menu/tambah', [MenuController::class, 'create']);
Route::post('/admin/menu', [MenuController::class, 'store']);
Route::get('/admin/menu/{id}/edit', [MenuController::class, 'edit']);
Route::put('/admin/menu/{id}', [MenuController::class, 'update']);
Route::delete('/admin/menu/{id}', [MenuController::class, 'destroy']);