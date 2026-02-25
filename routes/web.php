

<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// Root route - this will handle 127.0.0.1:8000
Route::get('/', function () {
    return redirect()->route('login');
});

// Regular user dashboard
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Email Verification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/dashboard');
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

// Password Update Routes
Route::middleware(['auth'])->group(function () {
    Route::put('/password', function (Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ]);

        $request->user()->update([
            'password' => bcrypt($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    })->name('password.update');
});

// OTP Registration routes (override default register route)
Route::get('/register', [App\Http\Controllers\Registerwithotpcontroller::class, 'create'])->name('register.create');
Route::post('/register', [App\Http\Controllers\Registerwithotpcontroller::class, 'store'])->name('register.store');
Route::get('/otp/verify', [App\Http\Controllers\Registerwithotpcontroller::class, 'showVerifyForm'])->name('otp.verify.form');
Route::post('/otp/verify', [App\Http\Controllers\Registerwithotpcontroller::class, 'verify'])->name('otp.verify');
Route::post('/otp/resend', [App\Http\Controllers\OtpController::class, 'resendOtp'])->name('otp.resend');
Route::get('/otp/status', [App\Http\Controllers\OtpController::class, 'checkOtpStatus'])->name('otp.status');

// Authentication routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

require __DIR__.'/api.php';
require __DIR__.'/admin.php';

// Test route for debugging Groq API
Route::get('/test-groq', function() {
    $apiKey = env('GROQ_API_KEY');
    
    Log::info('Testing Groq API connection...');
    Log::info('API Key: ' . substr($apiKey, 0, 10) . '...');
    
    if (empty($apiKey)) {
        return response()->json([
            'success' => false,
            'error' => 'GROQ_API_KEY is not configured'
        ]);
    }
    
    try {
        $url = "https://api.groq.com/openai/v1/chat/completions";
        
        Log::info('Making request to: ' . $url);
        
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json',
        ])->timeout(30)->post($url, [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Hello, test message'
                ]
            ],
            'temperature' => 0.7,
            'max_tokens' => 100,
            'top_p' => 0.95,
            'stream' => false
        ]);

        Log::info('Response Status: ' . $response->status());
        Log::info('Response Body: ' . json_encode($response->json()));

        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['choices']) && count($responseData['choices']) > 0) {
                $text = $responseData['choices'][0]['message']['content'] ?? null;
                if (!empty($text)) {
                    Log::info('✅ Success! Got response: ' . substr($text, 0, 100) . '...');
                    return response()->json([
                        'success' => true,
                        'message' => 'Groq API is working!',
                        'response' => $text
                    ]);
                } else {
                    Log::error('❌ Error: No content in response');
                    return response()->json([
                        'success' => false,
                        'error' => 'No content in response'
                    ]);
                }
            } else {
                Log::error('❌ Error: No choices in response');
                return response()->json([
                    'success' => false,
                    'error' => 'No choices in response'
                ]);
            }
        } else {
            Log::error('❌ Error: Request failed with status ' . $response->status());
            Log::error('Error body: ' . $response->body());
            return response()->json([
                'success' => false,
                'error' => 'Request failed',
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }
        
    } catch (\Exception $e) {
        Log::error('❌ Exception: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
});

Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/messages', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
Route::post('/send-message', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('send.message');
Route::post('/new-chat', [App\Http\Controllers\ChatController::class, 'newChat'])->name('new.chat');
Route::get('/load-chat/{sessionId}', [App\Http\Controllers\ChatController::class, 'loadChat'])->name('load.chat');
Route::get('/chat-history', [App\Http\Controllers\ChatController::class, 'getChatHistory'])->name('chat.history');
Route::post('/generate-chat-name', [App\Http\Controllers\ChatController::class, 'generateChatName'])->name('generate.chat.name');

// Chat management endpoints
Route::post('/rename-chat', [App\Http\Controllers\ChatController::class, 'renameChat'])->name('rename.chat');
Route::post('/toggle-pin-chat', [App\Http\Controllers\ChatController::class, 'togglePinChat'])->name('toggle.pin.chat');
Route::post('/delete-chat', [App\Http\Controllers\ChatController::class, 'deleteChat'])->name('delete.chat');


