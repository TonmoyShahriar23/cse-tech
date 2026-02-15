<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background: #343541;
            color: #ececf1;
            height: 100vh;
            overflow: hidden;
        }

        .app-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: #202123;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 16px;
            border-bottom: 1px solid #4d4d4f;
        }

        .new-chat-btn {
            width: 100%;
            background: transparent;
            border: 1px solid #565869;
            color: white;
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            margin-bottom: 16px;
            transition: all 0.2s ease;
        }

        .new-chat-btn:hover {
            background: #343541;
        }

        .history-list {
            flex: 1;
            overflow-y: auto;
            padding: 8px;
        }

        .history-item {
            padding: 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: background 0.2s ease;
            position: relative;
        }

        .history-item:hover {
            background: #343541;
        }

        .history-item.active {
            background: #343541;
        }

        .history-item:hover .chat-options-btn {
            opacity: 1;
            pointer-events: auto;
        }

        .chat-options-btn {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            color: #8e8ea0;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
            opacity: 0;
            pointer-events: none;
            font-size: 16px;
        }

        .chat-options-btn:hover {
            color: #ececf1;
            background: #40414f;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 12px;
            background: #202123;
            border: 1px solid #4d4d4f;
            border-radius: 6px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: none;
            min-width: 160px;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-item {
            padding: 10px 16px;
            cursor: pointer;
            font-size: 14px;
            color: #ececf1;
            border-bottom: 1px solid #4d4d4f;
            transition: background 0.2s ease;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: #343541;
        }

        .dropdown-item.danger {
            color: #ff6b6b;
        }

        .dropdown-item.danger:hover {
            background: #3a1f1f;
        }

        .pin-indicator {
            color: #f1c40f;
            margin-right: 8px;
            font-size: 14px;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid #4d4d4f;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: #10a37f;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Main Chat Area */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .chat-header {
            padding: 16px;
            border-bottom: 1px solid #4d4d4f;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-title {
            font-size: 16px;
            font-weight: 600;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            padding-bottom: 100px;
        }

        .message-container {
            display: flex;
            gap: 24px;
            padding: 24px 0;
            max-width: 768px;
            margin: 0 auto;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .message-avatar {
            width: 36px;
            height: 36px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-avatar-bg {
            background: #5436DA;
        }

        .ai-avatar-bg {
            background: #10a37f;
        }

        .message-content {
            flex: 1;
            padding-top: 4px;
            line-height: 1.6;
            font-size: 16px;
        }

        .message-content pre {
            background: #0d1117;
            padding: 16px;
            border-radius: 8px;
            overflow-x: auto;
            margin: 12px 0;
            border: 1px solid #30363d;
        }

        .message-content code {
            background: rgba(0, 0, 0, 0.2);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }

        /* Input Area */
        .input-container {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 24px;
            background: linear-gradient(180deg, rgba(52,53,65,0) 0%, #343541 100%);
        }

        .input-wrapper {
            max-width: 768px;
            margin: 0 auto;
            position: relative;
        }

        .message-input {
            width: 100%;
            background: #40414f;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 16px 52px 16px 20px;
            color: white;
            font-size: 16px;
            resize: none;
            max-height: 200px;
            line-height: 1.5;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .message-input:focus {
            border-color: #10a37f;
        }

        .send-button {
            position: absolute;
            right: 12px;
            bottom: 12px;
            background: transparent;
            border: none;
            color: #8e8ea0;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: color 0.2s ease;
        }

        .send-button:hover {
            color: #ececf1;
        }

        .send-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .input-footer {
            text-align: center;
            margin-top: 12px;
            font-size: 12px;
            color: #8e8ea0;
        }

        /* Mobile Responsive */
        .mobile-menu-btn {
            display: none;
            background: transparent;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                z-index: 1000;
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .mobile-menu-btn {
                display: block;
            }

            .message-container {
                padding: 16px 0;
                gap: 16px;
            }

            .chat-messages {
                padding: 16px;
                padding-bottom: 120px;
            }

            .input-container {
                padding: 16px;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #565869;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6e6e80;
        }

        /* Typing Indicator */
        .typing-indicator {
            display: flex;
            gap: 4px;
            padding: 8px 0;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            background: #8e8ea0;
            border-radius: 50%;
            animation: typing 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes typing {
            0%, 80%, 100% { transform: scale(0.7); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }

        /* Message Actions */
        .message-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .message-container:hover .message-actions {
            opacity: 1;
        }

        .action-btn {
            background: transparent;
            border: 1px solid #565869;
            color: #8e8ea0;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background: #40414f;
            color: #ececf1;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <button class="new-chat-btn" id="newChatBtn">
                    <i class="fas fa-plus"></i>
                    New chat
                </button>
            </div>
            
            <div class="history-list" id="historyList">
                <!-- Chat history will be populated here -->
                <div class="history-item active">
                    <i class="fas fa-message"></i>
                    <span>Today's Conversation</span>
                </div>
                <div class="history-item">
                    <i class="fas fa-message"></i>
                    <span>Code Review Session</span>
                </div>
                <div class="history-item">
                    <i class="fas fa-message"></i>
                    <span>Project Planning</span>
                </div>
            </div>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">U</div>
                    <div>
                        <div class="user-name">User</div>
                        <div class="user-email text-xs text-gray-400">user@example.com</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="chat-header">
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="chat-title" id="chatTitle">Today's Conversation</div>
                <div></div> <!-- Spacer -->
            </div>
            
            <div class="chat-messages" id="chatMessages">
                <!-- Messages will appear here -->
                <div class="message-container">
                    <div class="message-avatar ai-avatar-bg">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="message-content">
                        Hello! I'm your AI assistant. How can I help you today?
                    </div>
                </div>
            </div>
            
            <div class="input-container">
                <div class="input-wrapper">
                    <textarea 
                        id="messageInput" 
                        class="message-input" 
                        placeholder="Message AI..."
                        rows="1"
                        oninput="autoResize(this)"
                    ></textarea>
                    <button 
                        id="sendButton" 
                        class="send-button"
                        title="Send message"
                    >
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <div class="input-footer">
                    AI can make mistakes. Consider checking important information.
                </div>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const chatMessages = document.getElementById('chatMessages');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        const newChatBtn = document.getElementById('newChatBtn');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const historyList = document.getElementById('historyList');
        const chatTitle = document.getElementById('chatTitle');
        
        // State
        let currentSessionId = null;

        // Auto-resize textarea
        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, 200) + 'px';
        }

        // Add message to chat
        function addMessage(content, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message-container';
            
            const avatarClass = isUser ? 'user-avatar-bg' : 'ai-avatar-bg';
            const avatarIcon = isUser ? 'fa-user' : 'fa-robot';
            
            messageDiv.innerHTML = `
                <div class="message-avatar ${avatarClass}">
                    <i class="fas ${avatarIcon}"></i>
                </div>
                <div class="message-content">
                    ${formatMessageContent(content)}
                    ${!isUser ? `
                        <div class="message-actions">
                            <button class="action-btn copy-btn" onclick="copyToClipboard(this)">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                            <button class="action-btn" onclick="regenerateResponse()">
                                <i class="fas fa-redo"></i> Regenerate
                            </button>
                        </div>
                    ` : ''}
                </div>
            `;
            
            chatMessages.appendChild(messageDiv);
            scrollToBottom();
        }

        // Format message content (simple markdown-like formatting)
        function formatMessageContent(content) {
            // Convert code blocks
            content = content.replace(/```([\s\S]*?)```/g, '<pre><code>$1</code></pre>');
            
            // Convert inline code
            content = content.replace(/`([^`]+)`/g, '<code>$1</code>');
            
            // Convert bold text
            content = content.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
            
            // Convert links
            content = content.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" target="_blank" style="color: #10a37f;">$1</a>');
            
            return content.replace(/\n/g, '<br>');
        }

        // Copy message to clipboard
        function copyToClipboard(button) {
            const messageContent = button.closest('.message-container').querySelector('.message-content');
            const textToCopy = messageContent.textContent.replace(/\n\n/g, '\n');
            
            navigator.clipboard.writeText(textToCopy).then(() => {
                const originalHtml = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check"></i> Copied!';
                button.style.color = '#10a37f';
                
                setTimeout(() => {
                    button.innerHTML = originalHtml;
                    button.style.color = '';
                }, 2000);
            });
        }

        // Regenerate response
        function regenerateResponse() {
            // Implementation for regenerating the last response
            console.log('Regenerate response');
        }

        // Show typing indicator
        function showTypingIndicator() {
            const typingDiv = document.createElement('div');
            typingDiv.className = 'message-container';
            typingDiv.id = 'typingIndicator';
            
            typingDiv.innerHTML = `
                <div class="message-avatar ai-avatar-bg">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-content">
                    <div class="typing-indicator">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                </div>
            `;
            
            chatMessages.appendChild(typingDiv);
            scrollToBottom();
        }

        // Remove typing indicator
        function removeTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            if (indicator) {
                indicator.remove();
            }
        }

        // Scroll to bottom of chat
        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Send message
        async function sendMessage() {
            const message = messageInput.value.trim();
            if (!message) return;

            // Check if we have a valid session before sending
            if (!currentSessionId) {
                // No active session, create a new one
                await createNewChat();
                // Retry sending the message after creating new chat
                messageInput.value = message; // Restore the message
                return sendMessage(); // Recursive call with new session
            }

            // Add user message
            addMessage(message, true);
            messageInput.value = '';
            autoResize(messageInput);
            sendButton.disabled = true;

            // Show typing indicator
            showTypingIndicator();

            try {
                // Send message to backend API
                const response = await fetch('/send-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        message: message
                    })
                });

                removeTypingIndicator();

                if (response.ok) {
                    const data = await response.json();
                    
                    // Add assistant response
                    addMessage(data.assistant_message.message, false);
                } else if (response.status === 404) {
                    // Session not found (likely deleted)
                    console.warn('Session not found, creating new chat...');
                    currentSessionId = null;
                    
                    // Clear current chat messages
                    chatMessages.innerHTML = `
                        <div class="message-container">
                            <div class="message-avatar ai-avatar-bg">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div class="message-content">
                                This chat no longer exists. Starting a new conversation...
                            </div>
                        </div>
                    `;
                    
                    // Create new chat session
                    await createNewChat();
                    
                    // Resend the message to the new session
                    messageInput.value = message; // Restore the message
                    return sendMessage(); // Recursive call with new session
                } else {
                    throw new Error('Failed to get response from server');
                }
                
            } catch (error) {
                removeTypingIndicator();
                addMessage("Sorry, I encountered an error processing your request. Please try again.");
                console.error('Error:', error);
            } finally {
                sendButton.disabled = false;
                messageInput.focus();
            }
        }

        // Create new chat
        async function createNewChat() {
            try {
                const response = await fetch('/new-chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    currentSessionId = data.session_id;
                    
                    // Clear chat messages
                    chatMessages.innerHTML = `
                        <div class="message-container">
                            <div class="message-avatar ai-avatar-bg">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div class="message-content">
                                Hello! I'm your AI assistant. How can I help you today?
                            </div>
                        </div>
                    `;
                    
                    // Add to history
                    const newHistoryItem = document.createElement('div');
                    newHistoryItem.className = 'history-item active';
                    newHistoryItem.innerHTML = `
                        <i class="fas fa-message"></i>
                        <span>${data.session_name}</span>
                    `;
                    
                    // Update other items
                    document.querySelectorAll('.history-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    
                    historyList.insertBefore(newHistoryItem, historyList.firstChild);
                    chatTitle.textContent = data.session_name;
                    scrollToBottom();
                    
                    // Refresh chat history
                    loadChatHistory();
                } else {
                    throw new Error('Failed to create new chat');
                }
            } catch (error) {
                console.error('Error creating new chat:', error);
                alert('Failed to create new chat. Please try again.');
            }
        }

        // Load chat history
        async function loadChatHistory() {
            try {
                const response = await fetch('/chat-history', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const history = await response.json();
                    renderChatHistory(history);
                }
            } catch (error) {
                console.error('Error loading chat history:', error);
            }
        }

        // Render chat history
        function renderChatHistory(history) {
            historyList.innerHTML = '';
            
            history.forEach((session, index) => {
                const historyItem = document.createElement('div');
                historyItem.className = index === 0 ? 'history-item active' : 'history-item';
                historyItem.dataset.sessionId = session.id;
                historyItem.dataset.isPinned = session.is_pinned || false;
                historyItem.innerHTML = `
                    ${session.is_pinned ? '<i class="pin-indicator fas fa-thumbtack"></i>' : '<i class="fas fa-message"></i>'}
                    <span>${session.name || 'New Conversation'}</span>
                    <button class="chat-options-btn" onclick="toggleDropdown(event, ${session.id})">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu" id="dropdown-${session.id}">
                        <div class="dropdown-item" onclick="renameChat(${session.id})">
                            <i class="fas fa-edit"></i> Rename
                        </div>
                        <div class="dropdown-item" onclick="togglePinChat(${session.id})">
                            <i class="fas fa-thumbtack"></i> ${session.is_pinned ? 'Unpin Chat' : 'Pin Chat'}
                        </div>
                        <div class="dropdown-item danger" onclick="deleteChat(${session.id})">
                            <i class="fas fa-trash"></i> Delete
                        </div>
                    </div>
                `;
                historyList.appendChild(historyItem);
            });
        }

        // Load specific chat
        async function loadChat(sessionId) {
            try {
                const response = await fetch(`/load-chat/${sessionId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    currentSessionId = data.session.id;
                    
                    // Update UI
                    document.querySelectorAll('.history-item').forEach(item => {
                        item.classList.remove('active');
                        if (item.dataset.sessionId == sessionId) {
                            item.classList.add('active');
                        }
                    });
                    
                    chatTitle.textContent = data.session.name || 'New Conversation';
                    
                    // Render messages
                    renderMessages(data.messages);
                    
                    // Close sidebar on mobile
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('active');
                    }
                } else if (response.status === 404) {
                    // Chat not found (likely deleted)
                    console.warn('Chat not found, likely deleted:', sessionId);
                    
                    // Remove from history if it exists
                    const historyItem = document.querySelector(`.history-item[data-session-id="${sessionId}"]`);
                    if (historyItem) {
                        historyItem.remove();
                    }
                    
                    // If this was the current chat, create a new one
                    if (currentSessionId == sessionId) {
                        currentSessionId = null;
                        
                        // Clear current chat messages
                        chatMessages.innerHTML = `
                            <div class="message-container">
                                <div class="message-avatar ai-avatar-bg">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <div class="message-content">
                                    This chat no longer exists. Starting a new conversation...
                                </div>
                            </div>
                        `;
                        
                        // Create new chat session
                        await createNewChat();
                    }
                } else {
                    throw new Error('Failed to load chat');
                }
            } catch (error) {
                console.error('Error loading chat:', error);
                // Don't show alert for 404 errors as we handle them gracefully above
                if (!error.message.includes('404')) {
                    alert('Failed to load chat. Please try again.');
                }
            }
        }

        // Render messages
        function renderMessages(messages) {
            chatMessages.innerHTML = '';
            
            messages.forEach(message => {
                addMessage(message.message, message.role === 'user');
            });
        }

        // Event Listeners
        messageInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        sendButton.addEventListener('click', sendMessage);
        newChatBtn.addEventListener('click', createNewChat);
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                e.target !== mobileMenuBtn && 
                !mobileMenuBtn.contains(e.target)) {
                sidebar.classList.remove('active');
            }
        });

        // Handle history item clicks
        historyList.addEventListener('click', (e) => {
            const historyItem = e.target.closest('.history-item');
            if (historyItem) {
                const sessionId = historyItem.dataset.sessionId;
                if (sessionId) {
                    loadChat(sessionId);
                }
            }
        });

        // Dropdown menu functionality
        function toggleDropdown(event, sessionId) {
            event.stopPropagation();
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu.id !== `dropdown-${sessionId}`) {
                    menu.classList.remove('active');
                }
            });
            
            // Toggle current dropdown
            const dropdown = document.getElementById(`dropdown-${sessionId}`);
            dropdown.classList.toggle('active');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.dropdown-menu') && !e.target.closest('.chat-options-btn')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('active');
                });
            }
        });

        // Close dropdowns on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('active');
                });
            }
        });

        // Rename chat functionality
        async function renameChat(sessionId) {
            const historyItem = document.querySelector(`.history-item[data-session-id="${sessionId}"]`);
            const span = historyItem.querySelector('span');
            const originalName = span.textContent;
            
            // Replace span with input
            span.innerHTML = `<input type="text" value="${originalName}" style="background: #343541; border: 1px solid #565869; color: white; padding: 4px 8px; border-radius: 4px; width: 100%;" />`;
            
            const input = span.querySelector('input');
            input.focus();
            input.select();
            
            // Handle save on Enter or blur
            const saveRename = async () => {
                const newName = input.value.trim();
                if (!newName || newName === originalName) {
                    span.textContent = originalName;
                    return;
                }
                
                try {
                    const response = await fetch('/rename-chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            session_id: sessionId,
                            name: newName
                        })
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        span.textContent = data.session.name;
                        
                        // Update current chat title if this is the active chat
                        if (currentSessionId == sessionId) {
                            chatTitle.textContent = data.session.name;
                        }
                    } else {
                        throw new Error('Failed to rename chat');
                    }
                } catch (error) {
                    console.error('Error renaming chat:', error);
                    span.textContent = originalName;
                    alert('Failed to rename chat. Please try again.');
                }
            };
            
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    saveRename();
                } else if (e.key === 'Escape') {
                    span.textContent = originalName;
                }
            });
            
            input.addEventListener('blur', saveRename);
        }

        // Pin/Unpin chat functionality
        async function togglePinChat(sessionId) {
            try {
                const response = await fetch('/toggle-pin-chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        session_id: sessionId
                    })
                });
                
                if (response.ok) {
                    const data = await response.json();
                    const historyItem = document.querySelector(`.history-item[data-session-id="${sessionId}"]`);
                    
                    // Update the UI immediately
                    const pinIcon = historyItem.querySelector('.pin-indicator');
                    const messageIcon = historyItem.querySelector('i.fas.fa-message');
                    
                    if (data.session.is_pinned) {
                        // Add pin indicator
                        if (!pinIcon) {
                            const pinSpan = document.createElement('i');
                            pinSpan.className = 'pin-indicator fas fa-thumbtack';
                            historyItem.insertBefore(pinSpan, historyItem.querySelector('span'));
                        }
                        if (messageIcon) {
                            messageIcon.className = 'fas fa-message';
                        }
                    } else {
                        // Remove pin indicator
                        if (pinIcon) {
                            pinIcon.remove();
                        }
                        if (messageIcon) {
                            messageIcon.className = 'fas fa-message';
                        }
                    }
                    
                    // Update dropdown menu text
                    const dropdown = document.getElementById(`dropdown-${sessionId}`);
                    const pinMenuItem = dropdown.querySelector('.dropdown-item:nth-child(2)');
                    pinMenuItem.innerHTML = `<i class="fas fa-thumbtack"></i> ${data.session.is_pinned ? 'Unpin Chat' : 'Pin Chat'}`;
                    
                    // Reorder the history items manually instead of reloading
                    const historyItems = Array.from(historyList.children);
                    const pinnedItems = historyItems.filter(item => item.querySelector('.pin-indicator'));
                    const unpinnedItems = historyItems.filter(item => !item.querySelector('.pin-indicator'));
                    
                    // Clear and reorder
                    historyList.innerHTML = '';
                    [...pinnedItems, ...unpinnedItems].forEach(item => {
                        historyList.appendChild(item);
                    });
                } else {
                    throw new Error('Failed to toggle pin');
                }
            } catch (error) {
                console.error('Error toggling pin:', error);
                alert('Failed to toggle pin. Please try again.');
            }
        }

        // Delete chat functionality
        async function deleteChat(sessionId) {
            if (!confirm('Are you sure you want to delete this chat? This action cannot be undone.')) {
                return;
            }
            
            try {
                const response = await fetch('/delete-chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        session_id: sessionId
                    })
                });
                
                if (response.ok) {
                    // Remove from UI
                    const historyItem = document.querySelector(`.history-item[data-session-id="${sessionId}"]`);
                    if (historyItem) {
                        historyItem.remove();
                    }
                    
                    // If this was the current chat, create a new one
                    if (currentSessionId == sessionId) {
                        // Clear current chat state immediately to prevent any loading attempts
                        currentSessionId = null;
                        
                        // Clear current chat messages
                        chatMessages.innerHTML = `
                            <div class="message-container">
                                <div class="message-avatar ai-avatar-bg">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <div class="message-content">
                                    Chat deleted successfully! Starting a new conversation...
                                </div>
                            </div>
                        `;
                        
                        // Create new chat session
                        const newResponse = await fetch('/new-chat', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (newResponse.ok) {
                            const data = await newResponse.json();
                            currentSessionId = data.session_id;
                            
                            // Update chat title
                            chatTitle.textContent = data.session_name;
                            
                            // Add new chat to history without reloading
                            const newHistoryItem = document.createElement('div');
                            newHistoryItem.className = 'history-item active';
                            newHistoryItem.dataset.sessionId = data.session_id;
                            newHistoryItem.innerHTML = `
                                <i class="fas fa-message"></i>
                                <span>${data.session_name}</span>
                                <button class="chat-options-btn" onclick="toggleDropdown(event, ${data.session_id})">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" id="dropdown-${data.session_id}">
                                    <div class="dropdown-item" onclick="renameChat(${data.session_id})">
                                        <i class="fas fa-edit"></i> Rename
                                    </div>
                                    <div class="dropdown-item" onclick="togglePinChat(${data.session_id})">
                                        <i class="fas fa-thumbtack"></i> Pin Chat
                                    </div>
                                    <div class="dropdown-item danger" onclick="deleteChat(${data.session_id})">
                                        <i class="fas fa-trash"></i> Delete
                                    </div>
                                </div>
                            `;
                            
                            // Update other items
                            document.querySelectorAll('.history-item').forEach(item => {
                                item.classList.remove('active');
                            });
                            
                            historyList.insertBefore(newHistoryItem, historyList.firstChild);
                        }
                    } else {
                        // Just remove the deleted item from history without reloading
                        const historyItem = document.querySelector(`.history-item[data-session-id="${sessionId}"]`);
                        if (historyItem) {
                            historyItem.remove();
                        }
                    }
                    
                    // Show success message
                    alert('Chat deleted successfully!');
                } else {
                    throw new Error('Failed to delete chat');
                }
            } catch (error) {
                console.error('Error deleting chat:', error);
                alert('Failed to delete chat. Please try again.');
            }
        }

        // Initialize
        messageInput.focus();
        loadChatHistory();
        scrollToBottom();
        
        // Add global error handling to catch any unexpected "Failed to load chat" errors
        window.addEventListener('unhandledrejection', (event) => {
            if (event.reason && event.reason.message && event.reason.message.includes('Failed to load chat')) {
                event.preventDefault();
                console.warn('Caught failed to load chat error, ignoring...');
            }
        });
    </script>
</body>
</html>