

<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

require __DIR__.'/api.php';
require __DIR__.'/auth.php';

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


