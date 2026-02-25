<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatSession;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        // Get current session or create a new one
        $sessionId = session('chat_session_id');
        
        // Check if session exists and is valid
        if ($sessionId) {
            $session = ChatSession::find($sessionId);
            if (!$session) {
                // Session doesn't exist (was deleted), create a new one
                $session = ChatSession::create([
                    'user_id' => auth()->id(),
                    'name' => 'New Conversation',
                ]);
                session(['chat_session_id' => $session->id]);
                $sessionId = $session->id;
            }
        } else {
            // No session in session storage, create a new one
            $session = ChatSession::create([
                'user_id' => auth()->id(),
                'name' => 'New Conversation',
            ]);
            session(['chat_session_id' => $session->id]);
            $sessionId = $session->id;
        }

        // Get messages for current session
        // Double-check that the session still exists before fetching messages
        $session = ChatSession::find($sessionId);
        if (!$session) {
            // Session was deleted, create a new one and update session storage
            $session = ChatSession::create([
                'user_id' => auth()->id(),
                'name' => 'New Conversation',
            ]);
            session(['chat_session_id' => $session->id]);
            $sessionId = $session->id;
        }
        
        $chats = Chat::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Get chat history for sidebar
        $chatHistory = ChatSession::where('user_id', auth()->id())
            ->orWhereNull('user_id')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('pinned_at', 'desc')
            ->orderBy('last_message_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('chat.index', compact('chats', 'chatHistory', 'sessionId'));
    }

    public function getMessages()
    {
        $sessionId = session('chat_session_id');
        if (!$sessionId) {
            return response()->json([]);
        }

        // Check if session exists before fetching messages
        $session = ChatSession::find($sessionId);
        if (!$session) {
            // Session doesn't exist, clear the session and return empty messages
            session()->forget('chat_session_id');
            return response()->json([]);
        }

        $chats = Chat::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($chats);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $sessionId = session('chat_session_id');
        if (!$sessionId) {
            // Create new session
            $session = ChatSession::create([
                'user_id' => auth()->id(),
                'name' => 'New Conversation',
            ]);
            session(['chat_session_id' => $session->id]);
            $sessionId = $session->id;
        }

        // Save user message
        $userChat = Chat::create([
            'user_id' => auth()->id() ?? null,
            'session_id' => $sessionId,
            'message' => $request->message,
            'role' => 'user',
        ]);

        // Get AI response using the new service
        $aiService = new AiService();
        $aiResponse = $aiService->getResponse(auth()->user(), $request->message);

        // Save assistant response
        $assistantChat = Chat::create([
            'user_id' => auth()->id() ?? null,
            'session_id' => $sessionId,
            'message' => $aiResponse,
            'role' => 'assistant',
        ]);

        // Update session last message time
        $session = ChatSession::find($sessionId);
        if ($session) {
            $session->updateLastMessageTime();
        }

        // Generate chat name after first user message
        $this->generateChatNameForSession($sessionId);

        return response()->json([
            'user_message' => $userChat,
            'assistant_message' => $assistantChat,
        ]);
    }

    private function generateChatNameForSession($sessionId)
    {
        // Generate a name based on the first user message
        $firstUserMessage = Chat::where('session_id', $sessionId)
            ->where('role', 'user')
            ->orderBy('created_at', 'asc')
            ->first();

        if ($firstUserMessage && !$this->isSessionNamed($sessionId)) {
            $message = $firstUserMessage->message;
            $name = $this->generateNameFromMessage($message);
            
            // Update session name
            $session = ChatSession::find($sessionId);
            if ($session) {
                $session->name = $name;
                $session->save();
            }
        }
    }

    private function isSessionNamed($sessionId)
    {
        $session = ChatSession::find($sessionId);
        return $session && $session->name && $session->name !== 'New Conversation';
    }

    public function newChat(Request $request)
    {
        // Create new chat session
        $session = ChatSession::create([
            'user_id' => auth()->id(),
            'name' => 'New Conversation',
        ]);
        
        session(['chat_session_id' => $session->id]);
        
        return response()->json([
            'session_id' => $session->id,
            'session_name' => $session->name,
        ]);
    }

    public function loadChat(Request $request, $sessionId)
    {
        $session = ChatSession::find($sessionId);
        
        if (!$session) {
            return response()->json(['error' => 'Chat session not found'], 404);
        }

        // Update current session
        session(['chat_session_id' => $sessionId]);
        
        // Get messages for this session
        $chats = Chat::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'session' => $session,
            'messages' => $chats,
        ]);
    }

    public function getChatHistory(Request $request)
    {
        $chatHistory = ChatSession::where('user_id', auth()->id())
            ->orWhereNull('user_id')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('pinned_at', 'desc')
            ->orderBy('last_message_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json($chatHistory);
    }

    public function generateChatName(Request $request)
    {
        $sessionId = $request->input('session_id');
        $messages = Chat::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->limit(5)
            ->get();

        if ($messages->isEmpty()) {
            return response()->json(['name' => 'New Conversation']);
        }

        // Generate a name based on the first user message
        $firstUserMessage = $messages->firstWhere('role', 'user');
        if ($firstUserMessage) {
            $message = $firstUserMessage->message;
            $name = $this->generateNameFromMessage($message);
            
            // Update session name
            $session = ChatSession::find($sessionId);
            if ($session) {
                $session->name = $name;
                $session->save();
            }

            return response()->json(['name' => $name]);
        }

        return response()->json(['name' => 'New Conversation']);
    }

    private function generateNameFromMessage($message)
    {
        // Simple logic to generate a name from the first message
        $message = trim($message);
        $message = preg_replace('/[^\w\s]/', '', $message);
        $words = explode(' ', $message);
        
        if (count($words) > 4) {
            $name = implode(' ', array_slice($words, 0, 4)) . '...';
        } else {
            $name = $message;
        }

        return strlen($name) > 30 ? substr($name, 0, 27) . '...' : $name;
    }

    // Rename chat endpoint
    public function renameChat(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:chat_sessions,id',
            'name' => 'required|string|max:60',
        ]);

        $session = ChatSession::find($request->session_id);

        // Check ownership
        if ($session->user_id !== auth()->id() && $session->user_id !== null) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $session->name = $request->name;
        $session->save();

        return response()->json([
            'success' => true,
            'session' => $session,
        ]);
    }

    // Pin/Unpin chat endpoint
    public function togglePinChat(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:chat_sessions,id',
        ]);

        $session = ChatSession::find($request->session_id);

        // Check ownership
        if ($session->user_id !== auth()->id() && $session->user_id !== null) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $session->togglePin();

        return response()->json([
            'success' => true,
            'session' => $session,
        ]);
    }

    // Delete chat endpoint
    public function deleteChat(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:chat_sessions,id',
        ]);

        $session = ChatSession::find($request->session_id);

        // Check ownership
        if ($session->user_id !== auth()->id() && $session->user_id !== null) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete related messages first
        Chat::where('session_id', $session->id)->delete();
        
        // Delete the session
        $session->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chat deleted successfully',
        ]);
    }

}
