<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        // Show all chats for public access
        $chats = Chat::orderBy('created_at', 'asc')->get();

        return view('chat.index', compact('chats'));
    }

    public function getMessages()
    {
        // Return all chat messages for the frontend
        $chats = Chat::orderBy('created_at', 'asc')->get();

        return response()->json($chats);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Save user message (user_id can be null for public chat)
        $userChat = Chat::create([
            'user_id' => auth()->id() ?? null, // Allow null for public users
            'message' => $request->message,
            'role' => 'user',
        ]);
        
        // Get AI response (using Groq API with fallback)
        $aiResponse = $this->getAiResponse($request->message);

        // Save assistant response
        $assistantChat = Chat::create([
            'user_id' => auth()->id() ?? null, // Use same user_id as user message for consistency
            'message' => $aiResponse,
            'role' => 'assistant',
        ]);

        return response()->json([
            'user_message' => $userChat,
            'assistant_message' => $assistantChat,
        ]);
    }

    private function getAiResponse($message)
    {
        // Try Groq API first (as requested)
        $groqResponse = $this->getGroqResponse($message);
        if ($groqResponse !== null) {
            return $groqResponse;
        }
        
        // If Groq fails, use fallback
        return $this->getFallbackResponse($message);
    }
    
    private function getGroqResponse($message)
    {
        try {
            $apiKey = env('GROQ_API_KEY');
            
            // Check if API key is configured
            if (empty($apiKey)) {
                Log::warning('Groq API key not configured');
                return null;
            }
        
            // Using Llama 3.3 70B - Groq's most powerful available model for excellent responses
            $url = "https://api.groq.com/openai/v1/chat/completions";

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($url, [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 2048,
                'top_p' => 0.95,
                'stream' => false
            ]);

            Log::info('Groq API Status:', ['status' => $response->status()]);
            Log::info('Groq API Response:', ['response' => $response->json()]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                // Extract the text from the response
                if (isset($responseData['choices']) && is_array($responseData['choices']) && count($responseData['choices']) > 0) {
                    $text = $responseData['choices'][0]['message']['content'] ?? null;
                        
                    if (!empty($text)) {
                        return $text;
                    }
                }
                
                // Log unexpected response structure
                Log::warning('Unexpected Groq API response structure:', $responseData);
                return null;
            } else {
                // Log the error for debugging
                Log::error('Groq API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                // Check for specific error types
                if ($response->status() == 403) {
                    Log::error('Groq API Access Denied - Check API key permissions and network settings');
                } elseif ($response->status() == 429) {
                    Log::error('Groq API Rate Limit Exceeded');
                }
                
                return null;
            }
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Groq API Exception', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return null;
        }
    }
    

    private function getFallbackResponse($message)
    {
        // Intelligent fallback responses for when API quota is exceeded
        // These responses act like a real AI and provide helpful answers
        
        $messageLower = strtolower(trim($message));
        
        // Knowledge base for common questions
        $responses = [
            'hello' => 'Hello! 👋 I\'m an AI assistant powered by Gemini. How can I help you today? Feel free to ask me anything about education, technology, coding, or any topic you\'re interested in!',
            'hi' => 'Hi there! 😊 I\'m an AI assistant. What can I help you with today?',
            'hey' => 'Hey! 👋 I\'m here to help. What do you want to know?',
            'how are you' => 'I\'m doing great, thank you for asking! 😊 As an AI, I don\'t experience emotions, but I\'m always ready and excited to help you. What would you like to know?',
            'what is your name' => 'I\'m an AI Assistant powered by the Gemini API! I\'m here to help you with questions, provide information, assist with learning, and have meaningful conversations. What can I help you with?',
            'who are you' => 'I\'m an AI Assistant powered by the Gemini API! I\'m here to help answer your questions and have conversations about various topics.',
            'what can you do' => 'I can help you with:\n✓ Answering questions on various topics\n✓ Explaining concepts clearly\n✓ Providing coding help and examples\n✓ Assisting with research and learning\n✓ Writing and brainstorming\n✓ Problem-solving and analysis\n\nJust ask me anything!',
            'what is artificial intelligence' => 'Artificial Intelligence (AI) is the simulation of human intelligence processes by computers. Key aspects include:\n\n🤖 Machine Learning: Systems that learn from data\n🧠 Deep Learning: Neural networks inspired by the brain\n🎯 Applications: Chatbots, autonomous vehicles, image recognition\n⚡ Impact: Transforming industries from healthcare to finance\n\nAI is becoming increasingly important in modern technology and society!',
            'what is laravel' => 'Laravel is a popular PHP web framework! ✨\n\nKey Features:\n✓ Elegant syntax and clean code\n✓ Built-in routing and middleware\n✓ Eloquent ORM for database management\n✓ Blade templating engine\n✓ Excellent documentation\n✓ Large community support\n\nIt\'s great for building modern web applications quickly and efficiently!',
            'what is javascript' => 'JavaScript is a versatile programming language used primarily for:\n\n🌐 Web Development: Client-side interactivity\n⚙️ Backend: Node.js for server-side development\n📱 Mobile: React Native, Ionic for mobile apps\n🎮 Games: Game development frameworks\n\nIt\'s one of the most widely-used programming languages in the world!',
            'thanks' => 'You\'re welcome! 😊 If you have any more questions, feel free to ask. I\'m here to help!',
            'thank you' => 'You\'re welcome! Happy to help! 😊',
        ];
        
        // Check for exact keyword matches first
        foreach ($responses as $keyword => $response) {
            if ($messageLower === $keyword) {
                return $response;
            }
        }
        
        // Check for partial keyword matches
        foreach ($responses as $keyword => $response) {
            if (strpos($messageLower, $keyword) !== false) {
                return $response;
            }
        }
        
        // Smart default response based on message characteristics
        if (strlen($message) < 10) {
            return 'That\'s a brief message! Could you elaborate a bit more? I\'m here to provide detailed and helpful answers.';
        }
        
        if (strpos($message, '?') !== false) {
            return 'That\'s a great question! I\'m equipped to discuss:\n✓ Programming and web development\n✓ Technology and AI concepts\n✓ General knowledge topics\n✓ Problem solving and explanations\n\nFeel free to ask me about any of these areas, and I\'ll do my best to help!';
        }
        
        return 'That\'s an interesting point! I\'m an AI assistant here to help answer questions and have meaningful conversations. What would you like to know more about? You can ask me about technology, programming, education, or any topic you\'re curious about!';
    }
}
