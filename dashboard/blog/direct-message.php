<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Resonance</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Light mode contrast improvements */
        :root:not([data-theme="dark"]) .header {
            background: #e8e8e8 !important;
            border-bottom: 1px solid #d0d0d0;
        }

        :root:not([data-theme="dark"]) body {
            background: #f0f0f0 !important;
        }

        :root:not([data-theme="dark"]) .messages-container {
            background: #ffffff !important;
        }

        :root:not([data-theme="dark"]) .dm-messages {
            background: #f5f5f5 !important;
        }

        :root:not([data-theme="dark"]) .dm-input {
            background: #ffffff !important;
            border-color: #d0d0d0 !important;
        }

        .messages-wrapper {
            max-width: 1400px;
            margin: 100px auto;
            padding: 0 20px;
            min-height: 60vh;
        }

        .messages-container {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 5px 20px var(--shadow-sm);
            display: grid;
            grid-template-columns: 320px 1fr;
            height: 600px;
            overflow: hidden;
        }

        .conversations-sidebar {
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            background: var(--bg-secondary);
        }

        .conversations-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--card-bg);
        }

        .conversations-header h3 {
            margin: 0;
            font-size: 1.1rem;
            color: var(--text-primary);
        }

        .conversations-list {
            flex: 1;
            overflow-y: auto;
            padding: 0.5rem 0;
        }

        .conversation-item {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: background 0.2s;
            border-left: 3px solid transparent;
        }

        .conversation-item:hover {
            background: var(--card-bg);
        }

        .conversation-item.active {
            background: var(--card-bg);
            border-left-color: #9b2c1a;
        }

        .conversation-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9b2c1a;
            flex-shrink: 0;
        }

        .conversation-info {
            flex: 1;
            min-width: 0;
        }

        .conversation-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }

        .conversation-preview {
            font-size: 0.85rem;
            color: var(--text-secondary);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .chat-area {
            display: flex;
            flex-direction: column;
        }

        .dm-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--card-bg);
        }

        .dm-recipient-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dm-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--bg-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9b2c1a;
            font-size: 1.25rem;
        }

        .dm-recipient-details h2 {
            margin: 0;
            font-size: 1.25rem;
            color: var(--text-primary);
        }

        .dm-recipient-details p {
            margin: 0.25rem 0 0 0;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .dm-messages {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
            background: var(--bg-secondary);
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .dm-placeholder {
            text-align: center;
            color: var(--text-secondary);
            margin: auto;
        }

        .dm-message {
            display: flex;
            gap: 0.75rem;
            max-width: 70%;
        }

        .dm-message.sent {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        .dm-message.received {
            align-self: flex-start;
        }

        .dm-message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--bg-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9b2c1a;
            flex-shrink: 0;
        }

        .dm-message-content {
            background: var(--card-bg);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .dm-message.sent .dm-message-content {
            background: #9b2c1a;
            color: white;
            border-color: #9b2c1a;
        }

        .dm-message-text {
            margin: 0;
            color: inherit;
            line-height: 1.4;
        }

        .dm-message-time {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        .dm-message.sent .dm-message-time {
            color: rgba(255, 255, 255, 0.7);
        }

        .dm-input-wrapper {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 0.75rem;
            align-items: center;
            background: var(--card-bg);
        }

        .dm-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 24px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-size: 0.95rem;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            outline: none;
        }

        .dm-input:focus {
            border-color: #9b2c1a;
        }

        .dm-send-btn {
            border-radius: 50%;
            width: 44px;
            height: 44px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dm-send-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <!-- Navigation Header -->
    <header class="header">
        <nav class="nav">
            <div class="nav-brand">
                <a href="../index.php" class="logo-link">
                    <img src="../../assets/images/resonance.png" alt="Resonance Logo" class="logo-image">
                    <h1 class="logo">Resonance</h1>
                </a>
            </div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="../index.php" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="../profile/account.php" class="nav-link">My Account</a></li>
                <li class="nav-item"><a href="../profile/settings.php" class="nav-link">Settings</a></li>
            </ul>
            <div class="nav-actions">
                <a href="../notifications.php" class="notification-btn" id="notificationBtn" aria-label="Notifications" style="background: none; border: none; color: var(--text-primary); font-size: 1.25rem; cursor: pointer; padding: 0.5rem; margin-right: 1rem; position: relative; text-decoration: none;">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge" id="notificationBadge" style="position: absolute; top: 0; right: 0; background: #dc3545; color: white; border-radius: 50%; width: 18px; height: 18px; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 600; display: none;">0</span>
                </a>
                <button class="btn btn-outline" id="logoutBtn">Log Out</button>
            </div>
            <button class="theme-toggle" aria-label="Toggle dark mode">
                <i class="fas fa-moon theme-icon"></i>
            </button>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>

    <main class="messages-wrapper">
        <div class="messages-container" id="messagesContainer">
            <!-- Conversations Sidebar -->
            <div class="conversations-sidebar">
                <div class="conversations-header">
                    <h3>Messages</h3>
                </div>
                <div class="conversations-list" id="conversationsList">
                    <div style="padding: 2rem 1rem; text-align: center; color: var(--text-secondary); font-size: 0.9rem;">
                        Loading conversations...
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="chat-area">
                <div class="dm-header" id="dmHeader">
                    <div class="dm-recipient-info">
                        <div class="dm-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="dm-recipient-details">
                            <h2 id="recipientName">Select a conversation</h2>
                            <p id="recipientStatus" class="ws-regular"></p>
                        </div>
                    </div>
                </div>
                <div class="dm-messages" id="dmMessages">
                    <p class="dm-placeholder">Select a conversation or click on a user's profile to start messaging!</p>
                </div>
                <div class="dm-input-wrapper" id="dmInputWrapper">
                    <input type="text" id="messageInput" placeholder="Type a message..." class="dm-input">
                    <button id="sendBtn" class="btn btn-primary dm-send-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                    <div class="footer-section">
                    <h3>Resonance</h3>
                    <p class="ws-regular">Break free from group chats,<br>join a musician-run community.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="../../index.html">Home</a></li>
                        <li><a href="../profile/account.php">My Account</a></li>
                        <li><a href="../profile/settings.php">Settings</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="https://github.com/matei0906/" class="social-link" aria-label="GitHub"><i class="fab fa-github"></i></a>
                        <a href="https://www.linkedin.com/in/matei-stoica-698aa4348/" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Resonance. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="../../assets/js/auth.js"></script>
    <script type="module">
        import { checkSession, requireLogin, logout } from '../../assets/js/auth.js';

        console.log('Messages page loading, checking session...');
        
        // Ensure user is logged in
        requireLogin();

        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logoutBtn');
            const messageInput = document.getElementById('messageInput');
            const sendBtn = document.getElementById('sendBtn');

            // Handle logout
            logoutBtn.addEventListener('click', logout);

            // Load notification count
            loadNotificationCount();

            // Load conversations
            loadConversations();

            // Get user_id from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const recipientUserId = urlParams.get('user_id');

            console.log('DM Page - URL params:', window.location.search);
            console.log('DM Page - Recipient User ID:', recipientUserId);

            if (recipientUserId) {
                console.log('Loading recipient info for user ID:', recipientUserId);
                loadConversation(recipientUserId);
            } else {
                console.log('No user_id parameter found in URL');
            }

            // Handle send button
            sendBtn.addEventListener('click', sendMessage);
            messageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
        });

        let currentRecipientId = null;

        async function loadConversations() {
            const token = localStorage.getItem('session_token');
            if (!token) return;

            try {
                const response = await fetch('../../api/get_conversations.php', {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to load conversations');
                }

                const data = await response.json();
                console.log('Conversations loaded:', data);

                const conversationsList = document.getElementById('conversationsList');

                if (data.success && data.conversations.length > 0) {
                    conversationsList.innerHTML = data.conversations.map(conv => `
                        <div class="conversation-item" onclick="loadConversation(${conv.user_id})" data-user-id="${conv.user_id}">
                            <div class="conversation-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="conversation-info">
                                <div class="conversation-name">${conv.first_name} ${conv.last_name}</div>
                                <div class="conversation-preview">${escapeHtml(conv.last_message || 'No messages yet')}</div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    conversationsList.innerHTML = `
                        <div style="padding: 2rem 1rem; text-align: center; color: var(--text-secondary); font-size: 0.9rem;">
                            No conversations yet.<br>Click on a user's profile to start messaging!
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error loading conversations:', error);
            }
        }

        async function loadConversation(userId) {
            currentRecipientId = userId;
            console.log('Loading conversation with user:', userId);

            // Update active state in sidebar
            document.querySelectorAll('.conversation-item').forEach(item => {
                if (item.dataset.userId == userId) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });

            // Load recipient info
            await loadRecipientInfo(userId);

            // Load messages
            await loadMessages(userId);

            // Update URL without reload
            const url = new URL(window.location);
            url.searchParams.set('user_id', userId);
            window.history.pushState({}, '', url);
        }

        async function loadMessages(userId) {
            const token = localStorage.getItem('session_token');
            if (!token) return;

            try {
                const response = await fetch(`../../api/get_messages.php?user_id=${userId}`, {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to load messages');
                }

                const data = await response.json();
                console.log('Messages loaded:', data);

                const dmMessages = document.getElementById('dmMessages');

                if (data.success && data.messages.length > 0) {
                    dmMessages.innerHTML = data.messages.map(msg => {
                        const messageClass = msg.is_sent ? 'sent' : 'received';
                        const time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
                        
                        return `
                            <div class="dm-message ${messageClass}">
                                <div class="dm-message-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="dm-message-content">
                                    <p class="dm-message-text">${escapeHtml(msg.message)}</p>
                                    <div class="dm-message-time">${time}</div>
                                </div>
                            </div>
                        `;
                    }).join('');

                    // Scroll to bottom
                    dmMessages.scrollTop = dmMessages.scrollHeight;
                } else {
                    dmMessages.innerHTML = '<p class="dm-placeholder">No messages yet. Start the conversation!</p>';
                }
            } catch (error) {
                console.error('Error loading messages:', error);
            }
        }

        async function loadRecipientInfo(userId) {
            const token = localStorage.getItem('session_token');
            if (!token) {
                console.error('No session token found');
                return;
            }

            console.log('Fetching user info for ID:', userId);

            try {
                const url = '../../api/get_account.php?user_id=' + userId;
                console.log('Fetching from:', url);
                
                const response = await fetch(url, {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                });

                console.log('Response status:', response.status);

                if (!response.ok) {
                    throw new Error('Failed to load user info');
                }

                const data = await response.json();
                console.log('Received data:', data);
                
                if (data.success) {
                    const fullName = `${data.user.first_name} ${data.user.last_name}`;
                    console.log('Setting recipient name to:', fullName);
                    
                    document.getElementById('recipientName').textContent = fullName;
                    document.getElementById('recipientStatus').textContent = 
                        data.user.email || 'Resonance User';
                    
                    console.log('Recipient loaded successfully');
                } else {
                    console.error('API returned success=false:', data);
                }
            } catch (error) {
                console.error('Error loading recipient info:', error);
                document.getElementById('recipientName').textContent = 'User';
                document.getElementById('recipientStatus').textContent = 'Unable to load user info';
            }
        }

        async function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const messageText = messageInput.value.trim();
            
            if (!messageText || !currentRecipientId) {
                console.log('Cannot send: no message or no recipient', {messageText, currentRecipientId});
                return;
            }

            const token = localStorage.getItem('session_token');
            if (!token) return;

            try {
                // Send to API
                const response = await fetch('../../api/send_message.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify({
                        receiver_id: currentRecipientId,
                        message: messageText
                    })
                });

                if (!response.ok) {
                    throw new Error('Failed to send message');
                }

                const data = await response.json();
                console.log('Message sent:', data);

                if (data.success) {
                    // Clear input
                    messageInput.value = '';

                    // Reload messages to show the new one
                    await loadMessages(currentRecipientId);

                    // Reload conversations to update preview
                    await loadConversations();

                    // Reactivate the current conversation
                    document.querySelectorAll('.conversation-item').forEach(item => {
                        if (item.dataset.userId == currentRecipientId) {
                            item.classList.add('active');
                        }
                    });
                }
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please try again.');
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Make loadConversation global for onclick handlers
        window.loadConversation = loadConversation;

        async function loadNotificationCount() {
            const token = localStorage.getItem('session_token');
            if (!token) return;
            
            try {
                const response = await fetch('../../api/get_notification_count.php', {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                });

                if (!response.ok) return;

                const data = await response.json();
                const count = data.unread_count || 0;
                const badge = document.getElementById('notificationBadge');
                
                if (badge) {
                    if (count > 0) {
                        badge.textContent = count > 99 ? '99+' : count;
                        badge.classList.remove('hidden');
                        badge.style.display = 'flex';
                    } else {
                        badge.classList.add('hidden');
                        badge.style.display = 'none';
                    }
                }
            } catch (error) {
                console.error('Error loading notification count:', error);
            }
        }
    </script>
    <script src="../../assets/js/theme.js"></script>
</body>
</html>

