<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat History Report - {{ $user->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 20mm 20mm 40mm 20mm; /* top right bottom left - extra bottom margin for footer */
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
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
        
        .user-info .left, .user-info .right {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border-left: 3px solid #007bff;
        }
        
        .chat-container {
            margin-bottom: 40px;
        }
        
        .session-header {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #495057;
        }
        
        .message-container {
            display: flex;
            margin-bottom: 20px;
            align-items: flex-start;
        }
        
        .message {
            flex: 1;
            padding: 15px;
            border-radius: 8px;
            max-width: 70%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .user-message {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            margin-left: auto;
            text-align: right;
        }
        
        .ai-message {
            background: #f1f3f4;
            border-left: 4px solid #6c757d;
            margin-right: auto;
            text-align: left;
        }
        
        .message-content {
            margin-bottom: 8px;
            white-space: pre-wrap;
        }
        
        .message-time {
            font-size: 12px;
            color: #6c757d;
            font-style: italic;
        }
        
        /* DOMPDF Footer Styles - More compatible approach */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            border-top: 1px solid #dee2e6;
            padding: 10px 20mm;
            font-size: 12px;
            color: #6c757d;
            background: white;
            z-index: 1000;
        }
        
        /* DOMPDF-compatible footer layout using table display */
        .footer-table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
        }
        
        .footer-cell {
            vertical-align: middle;
        }
        
        .footer-left {
            text-align: left;
            width: 30%;
        }
        
        .footer-center {
            text-align: center;
            width: 40%;
        }
        
        .footer-right {
            text-align: right;
            width: 30%;
        }
        
        /* Ensure content doesn't overlap with footer */
        body {
            padding-bottom: 60px; /* Add space for footer */
        }
        
        .page-break {
            page-break-before: always;
        }
        
        /* DOMPDF page numbering using built-in placeholders */
        .page-number::before {
            content: counter(page);
        }
        
        .page-count::before {
            content: counter(pages);
        }
        
        
        .no-messages {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            margin: 40px 0;
        }
        
        .report-meta {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Chat History Report</h1>
        <div class="user-info">
            <div class="left">
                <strong>User Information:</strong><br>
                Name: {{ $user->name }}<br>
                Email: {{ $user->email }}<br>
                Role: {{ $user->role?->display_name ?? 'No Role' }}<br>
                Status: {{ $user->is_active ? 'Active' : 'Inactive' }}
            </div>
            <div class="right">
                <strong>Report Details:</strong><br>
                Generated: {{ now()->format('F j, Y \a\t g:i A') }}<br>
                Report Type: Chat History<br>
                User ID: {{ $user->id }}
            </div>
        </div>
    </div>

    <div class="report-meta">
        This report contains all chat conversations between {{ $user->name }} and the AI system.
        Messages are organized by chat session and displayed in chronological order.
    </div>

    @php
        $messagesPerPage = 20;
        $chunks = $messages->chunk($messagesPerPage);
        $totalPages = $chunks->count();
    @endphp

    <style>
        /* Set total pages as CSS custom property */
        :root {
            --total-pages: {{ $totalPages }};
        }
    </style>

    @if($messages->isEmpty())
        <div class="no-messages">
            No chat messages found for this user.
        </div>
    @else

        @foreach($chunks as $index => $chunk)
            @if($index > 0)
                <div class="page-break"></div>
            @endif

            <div class="chat-container">
                @foreach($chunk as $message)
                    @if($loop->first || $message->session_id != $messages[$loop->index - 1]->session_id)
                        <div class="session-header">
                            Chat Session: {{ $message->session?->name ?? 'Unnamed Session' }}
                            @if($message->session)
                                (Started: {{ $message->session->created_at->format('F j, Y \a\t g:i A') }})
                            @endif
                        </div>
                    @endif

                    <div class="message-container">
                        @if($message->role === 'user')
                            <div class="message user-message">
                                <div class="message-content">{{ $message->message }}</div>
                                <div class="message-time">
                                    {{ $message->created_at->format('F j, Y \a\t g:i A') }}
                                </div>
                            </div>
                        @else
                            <div class="message ai-message">
                                <div class="message-content">{{ $message->message }}</div>
                                <div class="message-time">
                                    {{ $message->created_at->format('F j, Y \a\t g:i A') }}
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach

        <div class="footer">
            <table class="footer-table">
                <tr>
                    <td class="footer-cell footer-left">System Generated</td>
                    <td class="footer-cell footer-center"></td>
                    <td class="footer-cell footer-right">
                        Page <span class="page-number"></span> 
                    </td>
                </tr>
            </table>
        </div>
    @endif
</body>
</html>
