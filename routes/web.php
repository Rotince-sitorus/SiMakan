<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;

Route::get('/', [MenuController::class, 'index']);
Route::get('/menu', [MenuController::class, 'index']);
Route::post('/order', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);