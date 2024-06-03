<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::post('/api/guests/checkin' , [GuestController::class , 'handleGuestCheckin']);

Route::get('/api/guests' , [GuestController::class , 'handleFetchGuests']);

Route::get('/api/guests/{id}' , [GuestController::class , 'handleFetchSingleGuest']);

Route::get('/api/guests/{id}/checkout' , [GuestController::class , 'handleGuestCheckout']);