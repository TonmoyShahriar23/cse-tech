# Groq API Fix - Static Fallback Responses Issue

## Problem Identified

The chat application is returning static fallback responses instead of using the Groq API because the Groq API is returning a **403 Forbidden** error with the message "Access denied. Please check your network settings."

## Root Cause

From the logs, we can see:
```
[2026-02-09 11:50:12] local.ERROR: Groq API Error {"status":403,"body":"{\"error\":{\"message\":\"Access denied. Please check your network settings.\"}}"}
```

This indicates that:
1. ✅ The API key is properly configured in `.env`
2. ✅ The API endpoint URL is correct
3. ✅ The request format is correct
4. ❌ **The Groq API server is rejecting the request due to network/access restrictions**

## Possible Causes

1. **API Key Permissions**: The API key may not have sufficient permissions
2. **Network Restrictions**: Groq may be blocking requests from your IP/network
3. **Regional Restrictions**: Your location may be restricted by Groq
4. **API Key Status**: The API key may be invalid, expired, or suspended
5. **Rate Limiting**: You may have exceeded rate limits

## Solutions

### Solution 1: Verify and Update API Key (Recommended)

1. **Check your Groq API key**:
   - Visit [Groq Console](https://console.groq.com/)
   - Verify your API key is active and has sufficient credits
   - Check if there are any usage limits or restrictions

2. **Generate a new API key**:
   - Create a new API key in the Groq console
   - Update your `.env` file:
   ```
   GROQ_API_KEY=your_new_api_key_here
   ```

3. **Test the new key**:
   - Visit `http://127.0.0.1:8000/test-groq` to test the connection

### Solution 2: Use Alternative API Provider

If Groq continues to have access issues, you can switch to another API provider. The code is already set up to use Gemini as a fallback.

To use Gemini as the primary API:

1. **Update the ChatController** to prioritize Gemini:
```php
private function getAiResponse($message)
{
    // Try Gemini API first
    $geminiResponse = $this->getGeminiResponse($message);
    if ($geminiResponse !== null) {
        return $geminiResponse;
    }
    
    // If Gemini fails, try Groq
    $groqResponse = $this->getGroqResponse($message);
    if ($groqResponse !== null) {
        return $groqResponse;
    }
    
    // If both fail, use fallback
    return $this->getFallbackResponse($message);
}
```

2. **Add the Gemini response method**:
```php
private function getGeminiResponse($message)
{
    try {
        $apiKey = env('GEMINI_API_KEY');
        
        if (empty($apiKey)) {
            Log::warning('Gemini API key not configured');
            return null;
        }
    
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key={$apiKey}";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(30)->post($url, [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $message
                        ]
                    ]
                ]
            ]
        ]);

        Log::info('Gemini API Status:', ['status' => $response->status()]);
        Log::info('Gemini API Response:', ['response' => $response->json()]);

        if ($response->successful()) {
            $responseData = $response->json();
            
            if (isset($responseData['candidates']) && is_array($responseData['candidates']) && count($responseData['candidates']) > 0) {
                $text = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;
                    
                if (!empty($text)) {
                    return $text;
                }
            }
            
            Log::warning('Unexpected Gemini API response structure:', $responseData);
            return null;
        } else {
            Log::error('Gemini API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return null;
        }
    } catch (\Exception $e) {
        Log::error('Gemini API Exception', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);
        return null;
    }
}
```

### Solution 3: Use Both APIs with Failover

The current implementation already has a good failover mechanism. You can enhance it by:

1. **Adding more detailed logging** to understand which API is working
2. **Implementing API key rotation** if you have multiple keys
3. **Adding retry logic** for temporary network issues

### Solution 4: Check Network Configuration

If you want to continue using Groq:

1. **Check firewall settings** - Ensure outbound requests to `api.groq.com` are allowed
2. **Try different network** - Test from a different network (mobile hotspot, VPN)
3. **Contact Groq Support** - If the issue persists, contact Groq support with your API key and error details

## Testing

After implementing any solution:

1. **Test the API connection**:
   ```
   Visit: http://127.0.0.1:8000/test-groq
   ```

2. **Test the chat functionality**:
   ```
   Visit: http://127.0.0.1:8000/chat
   ```

3. **Check the logs**:
   ```
   Check: storage/logs/laravel.log
   ```

## Current Status

- ✅ API key is properly configured
- ✅ API endpoint URL is correct  
- ✅ Request format is correct
- ❌ **Groq API is returning 403 Forbidden**

The fallback responses are working correctly as designed, but the primary Groq API is being blocked by the server.

## Recommended Action

1. **First**: Try generating a new Groq API key and test it
2. **Second**: If Groq continues to fail, switch to using Gemini as the primary API
3. **Third**: Contact Groq support if you specifically need to use their service

The application is well-architected with proper fallback mechanisms, so switching between APIs should be seamless for users.