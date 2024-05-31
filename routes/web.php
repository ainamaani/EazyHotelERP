<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/token', function () {
    return csrf_token();
});


// include other route files
require __DIR__.'/user.php';
