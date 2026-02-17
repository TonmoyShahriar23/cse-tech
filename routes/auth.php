<?php

// This file is now handled by web.php
// Authentication routes are defined in web.php to avoid conflicts
Route::middleware('guest')->group(function () {


    Route::get('register',[RegisterController::class,'create'])
    ->name('register');
    // Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    // Route::post('login', 'Auth\LoginController@login');
    // Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    // Route::post('register', 'Auth\RegisterController@register');
});