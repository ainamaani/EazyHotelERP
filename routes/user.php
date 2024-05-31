<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/api/users/sign_up', [UserController::class , 'handleSignUp']);

Route::get('/api/users', [UserController::class , 'handleFetchUsers']);

Route::get('/api/users/{id}', [UserController::class , 'handleFetchSingleUser']);

Route::get('/api/users/{id}/delete', [UserController::class , 'handleDeleteUser']);

Route::get('/api/users/{id}/change_role', [UserController::class , 'handleChangeRole']);
