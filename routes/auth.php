<?php

use App\Http\Controllers\Registerwithotpcontroller;
use App\Http\Controllers\OtpController;

// This file is now handled by web.php
// Authentication routes are defined in web.php to avoid conflicts
Route::middleware('guest')->group(function () {
    Route::get('register', [Registerwithotpcontroller::class, 'create'])->name('register.create');
    Route::post('register', [Registerwithotpcontroller::class, 'store'])->name('register.store');
    Route::get('otp/verify', [Registerwithotpcontroller::class, 'showVerifyForm'])->name('otp.verify.form');
    Route::post('otp/verify', [Registerwithotpcontroller::class, 'verify'])->name('otp.verify');
    Route::post('otp/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');
    Route::get('otp/status', [OtpController::class, 'checkOtpStatus'])->name('otp.status');
});
