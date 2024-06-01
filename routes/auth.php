<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/api/auth/login', [AuthController::class , 'handleLogin']);

Route::post('/api/auth/{id}/change_password', [AuthController::class, 'handleChangePassword']);