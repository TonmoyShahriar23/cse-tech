<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat History Report - {{ $user->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 20mm 25mm 20mm; /* Reduced top margin for header */
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        /* Fixed Header for every page */
        .page-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 12mm;
            background: white;
            border-bottom: 2px solid #007bff;
            padding: 0 20mm;
            z-index: 1000;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }
        
        .page-header h1 {
            color: #007bff;
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            line-height: 1.0;
            padding: 0;
            margin: 0;
        }
        
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            /* Fixed space for title to prevent chat overlap */
            margin-top: 16mm;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .main-container {
                padding: 0 15px;
            }
            
            .user-info {
                flex-direction: column;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .main-container {
                padding: 0 10px;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .user-info {
                font-size: 12px;
            }
            
            .user-info .left, .user-info .right {
                padding: 8px;
            }
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
        
        .session-header {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #495057;
        }
        
        /* Modern Chat Conversation Layout - PDF Optimized */
        .chat-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 25px;
            width: 100%;
        }
        
        .message-wrapper {
            display: flex;
            width: 100%;
            margin-bottom: 8px;
        }
        
        /* User messages - Right aligned */
        .user-message-wrapper {
            display: flex;
            justify-content: flex-end;
            width: 100%;
            padding: 0 20px;
        }
        
        .user-message-wrapper .message-bubble {
            max-width: 70%;
            margin-left: auto;
            margin-right: 0;
            text-align: left;
        }
        
        /* AI messages - Left aligned */
        .ai-message-wrapper {
            display: flex;
            justify-content: flex-start;
            width: 100%;
            padding: 0 20px;
        }
        
        .ai-message-wrapper .message-bubble {
            max-width: 70%;
            margin-right: auto;
            margin-left: 0;
            text-align: left;
        }
        
        .message-bubble {
            padding: 14px 18px;
            border-radius: 18px 18px 4px 18px;
            font-size: 12px;
            line-height: 1.6;
            word-wrap: break-word;
            word-break: break-word;
            border: 1px solid transparent;
            background: #ffffff;
            box-sizing: border-box;
            position: relative;
            min-width: 80px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        /* User message styling - Right side */
        .user-bubble {
            background: #0056b3; /* Solid fallback for PDF */
            background: linear-gradient(135deg, #0056b3, #003d82); /* Gradient for modern browsers */
            color: #180202 !important;
            border-radius: 18px 18px 18px 4px;
            box-shadow: 0 4px 12px rgba(0, 91, 179, 0.35);
            border: 1px solid rgba(0, 91, 179, 0.4);
            /* Professional touch - subtle texture */
            background-clip: padding-box;
            position: relative;
            z-index: 1;
        }
        
        /* AI message styling - Left side */
        .ai-bubble {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            color: #212529;
            border-radius: 18px 18px 4px 18px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.12);
            border: 1px solid rgba(0,0,0,0.08);
            /* Professional touch - subtle texture */
            background-clip: padding-box;
            position: relative;
            z-index: 1;
        }
        
        /* Message content styling */
        .message-content {
            margin: 0 0 8px 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.6;
            white-space: pre-wrap;
            word-break: break-word;
            letter-spacing: 0.2px;
            /* Ensure text inherits proper color */
            color: inherit;
        }
        
        .message-timestamp {
            font-size: 10px;
            color: #6c757d;
            font-weight: 500;
            letter-spacing: 0.3px;
            display: block;
            opacity: 0.85;
            font-style: italic;
        }
        
        /* Timestamp alignment - improved for better positioning */
        .user-timestamp {
            text-align: right;
            margin-top: 2px;
            padding-right: 2px;
        }
        
        .ai-timestamp {
            text-align: left;
            margin-top: 2px;
            padding-left: 2px;
        }
        
        /* Clear floats after each message pair */
        .message-wrapper:after {
            content: "";
            display: table;
            clear: both;
            height: 0;
            line-height: 0;
            font-size: 0;
        }
        
        /* Ensure proper spacing between messages */
        .chat-container:after {
            content: "";
            display: table;
            clear: both;
            height: 0;
            line-height: 0;
            font-size: 0;
        }
        
        /* Force proper container structure */
        .user-message-wrapper {
            min-height: 40px;
        }
        
        .ai-message-wrapper {
            min-height: 40px;
        }
        
        /* Ensure bubbles don't exceed page width */
        .message-bubble {
            box-sizing: border-box;
            max-width: calc(100% - 40px);
        }
        
        /* PDF-specific optimizations for multi-page reports */
        .message-wrapper {
            page-break-inside: avoid;
            break-inside: avoid;
            page-break-after: auto;
        }
        
        .message-bubble {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        /* Session headers should stay with first message */
        .session-header {
            page-break-after: avoid;
            margin-bottom: 12px;
        }
        
        /* Ensure proper text wrapping for long messages */
        .message-content {
            overflow-wrap: break-word;
            word-wrap: break-word;
            hyphens: auto;
            margin-bottom: 6px;
            /* Better line height for readability */
            line-height: 1.7;
        }
        
        /* Remove any animations that might not work in PDF */
        .message-bubble {
            animation: none !important;
            transform: none !important;
        }
        
        /* Enhanced visual separation between message pairs */
        .message-wrapper + .message-wrapper {
            margin-top: 16px;
        }
        
        /* Improved spacing between different user types */
        .user-message-wrapper + .user-message-wrapper,
        .ai-message-wrapper + .ai-message-wrapper {
            margin-bottom: 12px;
        }
        
        /* Subtle message indicators with better positioning */
        .user-bubble::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 12px;
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid rgba(0, 123, 255, 0.25);
            filter: blur(1px);
        }
        
        .ai-bubble::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 12px;
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid rgba(232, 234, 241, 0.9);
            filter: blur(1px);
        }
        
        /* Better spacing between different user types */
        .user-message-wrapper + .user-message-wrapper,
        .ai-message-wrapper + .ai-message-wrapper {
            margin-bottom: 8px;
        }
        
        /* Enhanced bubble styling for better readability */
        .message-bubble {
            max-width: 100%;
            word-break: break-word;
            hyphens: auto;
        }
        
        /* Ensure proper line height for long messages */
        .message-content {
            line-height: 1.6;
            margin-bottom: 4px;
        }
        
        /* Add subtle hover effect simulation for PDF (using box-shadow) */
        .user-bubble {
            transition: box-shadow 0.2s ease;
        }
        
        .ai-bubble {
            transition: box-shadow 0.2s ease;
        }
        
        
        /* DOMPDF Footer Styles - More compatible approach */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            border-top: 1px solid #dee2e6;
            padding: 6px 20mm;
            font-size: 11px;
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
        
        /* Reduce header spacing in main content area */
        .header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 0;
            margin-bottom: 0;
        }
        
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 20px;
            line-height: 1.0;
            padding-bottom: 0;
            margin-bottom: 0;
        }
        
        /* Ensure content doesn't overlap with header and footer */
        body {
            padding-top: 16mm; /* Add space for fixed header */
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
            margin-bottom: 0;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <!-- Fixed Header for every page -->
    <div class="page-header">
        <h1>Chat History Report of {{ $user->name }}</h1>
    </div>

    <div class="main-container">
        <!-- First page header with user details -->
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

                        @if($message->role === 'user')
                            <div class="message-wrapper user-message-wrapper">
                                <div class="message-bubble user-bubble">
                                    <div class="message-content">{{ $message->message }}</div>
                                    <div class="message-timestamp user-timestamp">
                                        {{ $message->created_at->format('F j, Y \a\t g:i A') }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="message-wrapper ai-message-wrapper">
                                <div class="message-bubble ai-bubble">
                                    <div class="message-content">{{ $message->message }}</div>
                                    <div class="message-timestamp ai-timestamp">
                                        {{ $message->created_at->format('F j, Y \a\t g:i A') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>

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
</body>
</html>
