<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Registerwithotpcontroller;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\PaymentRedirectController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Welcome & Authentication ---
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Registration & OTP ---
Route::get('/register', [Registerwithotpcontroller::class, 'create'])->name('register.create');
Route::post('/register', [Registerwithotpcontroller::class, 'store'])->name('register.store');
Route::get('/otp/verify', [Registerwithotpcontroller::class, 'showVerifyForm'])->name('otp.verify.form');
Route::post('/otp/verify', [Registerwithotpcontroller::class, 'verify'])->name('otp.verify');
Route::post('/otp/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');
Route::get('/otp/status', [OtpController::class, 'checkOtpStatus'])->name('otp.status');

// --- Authenticated User Routes ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Password Update
    Route::put('/password', function (Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ]);
        $request->user()->update(['password' => bcrypt($validated['password'])]);
        return back()->with('status', 'password-updated');
    })->name('password.update');

    // Chat System
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
    Route::post('/new-chat', [ChatController::class, 'newChat'])->name('new.chat');
    Route::get('/load-chat/{sessionId}', [ChatController::class, 'loadChat'])->name('load.chat');
    Route::get('/chat-history', [ChatController::class, 'getChatHistory'])->name('chat.history');
    Route::post('/generate-chat-name', [ChatController::class, 'generateChatName'])->name('generate.chat.name');
    Route::post('/rename-chat', [ChatController::class, 'renameChat'])->name('rename.chat');
    Route::post('/toggle-pin-chat', [ChatController::class, 'togglePinChat'])->name('toggle.pin.chat');
    Route::post('/delete-chat', [ChatController::class, 'deleteChat'])->name('delete.chat');
});

// --- Student Management (CRUD) ---
Route::resource('students', StudentController::class);

// --- Pricing & Subscription ---
Route::get('/pricing', function() {
    return view('pricing.index');
})->name('pricing.index');

// --------------------------------------------------------------------------
// SSLCOMMERZ PAYMENT INTEGRATION
// --------------------------------------------------------------------------

// Initiation
Route::post('/pay', [SslCommerzPaymentController::class, 'index'])->name('payment.init');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

// Callback URLs (Gateways targets these)
Route::match(['get', 'post'], '/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);

// Final Success View & Invoice
Route::get('/payment/success-view', [SslCommerzPaymentController::class, 'successPage'])->name('payment.success');
Route::get('/payment/invoice/download', [SslCommerzPaymentController::class, 'generateInvoice'])->name('invoice.generate');

// Example/Test Routes
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);
Route::get('/payment', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

// --------------------------------------------------------------------------

// --- Diagnostics & API Imports ---
require __DIR__.'/api.php';
require __DIR__.'/admin.php';

Route::get('/test-groq', function() { /* Groq testing logic... */ });

// Session helpers for testing
Route::post('/set-session-test', function(\Illuminate\Http\Request $request) {
    session($request->all());
    return response()->json(['success' => true, 'message' => 'Session data set']);
});

Route::post('/clear-session-test', function() {
    session()->flush();
    return response()->json(['success' => true, 'message' => 'Session cleared']);
});