<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AiService
{
    /**
     * Get AI response based on user tier.
     */
    public function getResponse(User $user, string $message)
    {
        // Check if user is active and not suspended
        if (!$user->isActive()) {
            throw new \Exception('Your account is not active. Please contact support.');
        }

        // Determine which AI model to use based on user tier
        if ($user->isPremium()) {
            return $this->getPremiumResponse($message);
        } else {
            return $this->getStandardResponse($message);
        }
    }

    /**
     * Get response from premium AI models.
     */
    private function getPremiumResponse(string $message)
    {
        // Try premium models first (for future implementation)
        // For now, use Groq API with premium settings
        
        $premiumResponse = $this->getGroqResponse($message, [
            'model' => 'llama-3.3-70b-versatile',
            'temperature' => 0.7,
            'max_tokens' => 3000,
            'top_p' => 0.95,
        ]);

        if ($premiumResponse !== null) {
            return $premiumResponse;
        }

        // Fallback to standard response if premium fails
        return $this->getStandardResponse($message);
    }

    /**
     * Get response from standard AI models.
     */
    private function getStandardResponse(string $message)
    {
        // Use standard Groq API settings
        $standardResponse = $this->getGroqResponse($message, [
            'model' => 'llama-3.3-70b-versatile',
            'temperature' => 0.7,
            'max_tokens' => 2048,
            'top_p' => 0.95,
        ]);

        if ($standardResponse !== null) {
            return $standardResponse;
        }

        // Fallback to intelligent responses
        return $this->getIntelligentFallbackResponse($message);
    }

    /**
     * Get response from Groq API.
     */
    private function getGroqResponse(string $message, array $settings = [])
    {
        try {
            $apiKey = env('GROQ_API_KEY');
            
            if (empty($apiKey)) {
                Log::warning('Groq API key not configured');
                return null;
            }

            $defaultSettings = [
                'model' => 'llama-3.3-70b-versatile',
                'temperature' => 0.7,
                'max_tokens' => 2048,
                'top_p' => 0.95,
                'stream' => false,
            ];

            $settings = array_merge($defaultSettings, $settings);

            $url = "https://api.groq.com/openai/v1/chat/completions";

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($url, [
                'model' => $settings['model'],
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ],
                'temperature' => $settings['temperature'],
                'max_tokens' => $settings['max_tokens'],
                'top_p' => $settings['top_p'],
                'stream' => $settings['stream'],
            ]);

            Log::info('Groq API Status:', ['status' => $response->status()]);
            Log::info('Groq API Response:', ['response' => $response->json()]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['choices']) && is_array($responseData['choices']) && count($responseData['choices']) > 0) {
                    $text = $responseData['choices'][0]['message']['content'] ?? null;
                        
                    if (!empty($text)) {
                        return $text;
                    }
                }
                
                Log::warning('Unexpected Groq API response structure:', $responseData);
                return null;
            } else {
                Log::error('Groq API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                if ($response->status() == 403) {
                    Log::error('Groq API Access Denied - Check API key permissions and network settings');
                } elseif ($response->status() == 429) {
                    Log::error('Groq API Rate Limit Exceeded');
                }
                
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Groq API Exception', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return null;
        }
    }

    /**
     * Get intelligent fallback response.
     */
    private function getIntelligentFallbackResponse(string $message)
    {
        $messageLower = strtolower(trim($message));
        
        // Knowledge base for common questions
        $responses = [
            'hello' => 'Hello! 👋 I\'m an AI assistant. How can I help you today?',
            'hi' => 'Hi there! 😊 I\'m here to help. What can I assist you with?',
            'hey' => 'Hey! 👋 I\'m ready to help you with any questions you have.',
            'how are you' => 'I\'m doing great, thank you for asking! 😊 As an AI, I don\'t experience emotions, but I\'m always ready to help you. What would you like to know?',
            'what is your name' => 'I\'m an AI Assistant! I\'m here to help answer your questions and have meaningful conversations.',
            'what can you do' => 'I can help you with:\n✓ Answering questions on various topics\n✓ Explaining concepts clearly\n✓ Providing coding help and examples\n✓ Assisting with research and learning\n✓ Writing and brainstorming\n✓ Problem-solving and analysis\n\nJust ask me anything!',
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

    /**
     * Get AI usage statistics.
     */
    public function getUsageStatistics()
    {
        // This would typically track API usage, but for now return basic info
        return [
            'api_provider' => 'Groq',
            'model_used' => 'llama-3.3-70b-versatile',
            'standard_max_tokens' => 2048,
            'premium_max_tokens' => 3000,
            'temperature' => 0.7,
            'top_p' => 0.95,
        ];
    }

    /**
     * Check if user has access to premium features.
     */
    public function hasPremiumAccess(User $user)
    {
        return $user->isPremium();
    }

    /**
     * Get available AI features for user.
     */
    public function getAvailableFeatures(User $user)
    {
        $baseFeatures = [
            'text_chat' => true,
            'longer_context' => false,
            'advanced_models' => false,
            'voice_chat' => false,
            'image_chat' => false,
        ];

        if ($user->isPremium()) {
            $baseFeatures['longer_context'] = true;
            $baseFeatures['advanced_models'] = true;
            $baseFeatures['voice_chat'] = true;
            $baseFeatures['image_chat'] = true;
        }

        return $baseFeatures;
    }
}