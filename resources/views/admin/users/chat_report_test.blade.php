<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat History Report Test - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 20px;
        }
        
        .header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        
        .user-info {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 14px;
        }
        
        .session-header {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #495057;
        }
        
        .message-wrapper {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .user-message {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
        }
        
        .ai-message {
            background-color: #f5f5f5;
            border-left: 4px solid #757575;
        }
        
        .message-content {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .message-meta {
            font-size: 12px;
            color: #666;
            font-style: italic;
        }
        
        .debug-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Chat History Report (TEST VERSION)</h1>
        <div class="user-info">
            <div>
                <strong>User:</strong> {{ $user->name }} ({{ $user->email }})
            </div>
            <div>
                <strong>Total Messages:</strong> {{ $messages->count() }}
            </div>
        </div>
    </div>

    <div class="debug-info">
        <strong>Debug Info:</strong><br>
        Message roles found: {{ $messages->pluck('role')->unique()->implode(', ') }}<br>
        User messages: {{ $messages->where('role', 'user')->count() }}<br>
        AI messages: {{ $messages->where('role', 'assistant')->count() }}<br>
        Other roles: {{ $messages->whereNotIn('role', ['user', 'assistant'])->pluck('role')->unique()->implode(', ') }}
    </div>

    @if($messages->isEmpty())
        <div style="text-align: center; color: #6c757d; font-style: italic; margin: 40px 0;">
            No chat messages found for this user.
        </div>
    @else
        <div>
            @foreach($messages as $message)
                @if($loop->first || $message->session_id != $messages[$loop->index - 1]->session_id)
                    <div class="session-header">
                        Chat Session: {{ $message->session?->name ?? 'Unnamed Session' }}
                        @if($message->session)
                            (Started: {{ $message->session->created_at->format('F j, Y \a\t g:i A') }})
                        @endif
                    </div>
                @endif

                <div class="message-wrapper {{ $message->role === 'user' ? 'user-message' : 'ai-message' }}">
                    <div class="message-meta">
                        Role: <strong>{{ $message->role }}</strong> | 
                        Time: {{ $message->created_at->format('F j, Y \a\t g:i A') }}
                    </div>
                    <div class="message-content">
                        <strong>{{ $message->role === 'user' ? 'User' : 'AI' }}:</strong><br>
                        {{ $message->message }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</body>
</html>