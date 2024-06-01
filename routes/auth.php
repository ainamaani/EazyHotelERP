<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/api/auth/login', [AuthController::class , 'handleLogin']);