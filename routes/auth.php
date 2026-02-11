<?php

use Illuminate\Support\Facades\Route;

// Simple authentication routes without laravel/ui dependency
Route::get('/login', function() {
    return redirect()->route('chat.index');
})->name('login');

Route::get('/register', function() {
    return redirect()->route('chat.index');
})->name('register');

Route::get('/password/reset', function() {
    return redirect()->route('chat.index');
})->name('password.request');
