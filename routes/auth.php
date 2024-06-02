<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/api/auth/login', [AuthController::class , 'handleLogin']);

Route::post('/api/auth/{id}/change_password', [AuthController::class, 'handleChangePassword']);

Route::post('/api/auth/password/reset_token', [AuthController::class, 'handleGenerateResetToken']);

Route::get('/api/auth/tokens', [AuthController::class, 'handleFetchResetTokens']);

Route::post('/api/auth/reset_password', [AuthController::class, 'handleResetPassword']);