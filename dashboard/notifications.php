<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Resonance</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
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

        :root:not([data-theme="dark"]) .notifications-card,
        :root:not([data-theme="dark"]) .notification-item {
            background: #ffffff !important;
        }

        .main-content {
            padding: 2rem 0;
            min-height: calc(100vh - 80px);
            margin-top: 80px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .notifications-header {
            margin-bottom: 2rem;
        }

        .notifications-header h1 {
            margin: 0 0 0.5rem 0;
            color: var(--text-primary);
        }

        .notifications-header p {
            margin: 0;
            color: var(--text-secondary);
            font-family: 'Work Sans', sans-serif;
        }

        .mailbox-container {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px var(--shadow-sm);
        }

        .mailbox-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .mailbox-header h2 {
            margin: 0;
            color: var(--text-primary);
            font-family: 'Work Sans', sans-serif;
        }

        .notification-count {
            color: var(--text-secondary);
            font-family: 'Work Sans', sans-serif;
            font-size: 0.9rem;
        }

        .notifications-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .notification-item {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .notification-item.unread {
            border-left: 4px solid #c93a1f;
        }

        .notification-item:hover {
            background: var(--input-bg);
            box-shadow: 0 2px 8px var(--shadow-sm);
            transform: translateY(-2px);
        }

        .notification-item:last-child {
            margin-bottom: 0;
        }

        .notification-header-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .notification-icon.like {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .notification-icon.comment {
            background: rgba(201, 58, 31, 0.1);
            color: #c93a1f;
        }

        .notification-user-info {
            flex: 1;
        }

        .notification-user-name {
            font-weight: 600;
            color: var(--text-primary);
            font-family: 'Work Sans', sans-serif;
            margin: 0 0 0.25rem 0;
        }

        .notification-action {
            color: var(--text-secondary);
            font-family: 'Work Sans', sans-serif;
            font-size: 0.9rem;
            margin: 0;
        }

        .notification-time {
            color: var(--text-secondary);
            font-family: 'Work Sans', sans-serif;
            font-size: 0.75rem;
            margin-left: auto;
        }

        .notification-content {
            margin-top: 0.75rem;
            padding-left: 3.25rem;
        }

        .notification-post-preview {
            color: var(--text-secondary);
            font-family: 'Work Sans', sans-serif;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            font-style: italic;
        }

        .notification-comment {
            background: var(--card-bg);
            border-left: 3px solid #c93a1f;
            padding: 0.75rem;
            border-radius: 4px;
            margin-top: 0.5rem;
        }

        .notification-comment-text {
            color: var(--text-primary);
            font-family: 'Work Sans', sans-serif;
            font-size: 0.9rem;
            margin: 0;
            font-style: italic;
        }

        .notification-comment-text::before {
            content: '"';
        }

        .notification-comment-text::after {
            content: '"';
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            margin: 0 0 0.5rem 0;
            color: var(--text-primary);
            font-family: 'Work Sans', sans-serif;
        }

        .empty-state p {
            margin: 0;
            font-family: 'Work Sans', sans-serif;
        }

        /* Notification Icon Styles */
        .notification-icon-wrapper {
            position: relative;
            display: inline-block;
            margin-right: 1rem;
        }

        .notification-btn {
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s ease;
            position: relative;
        }

        .notification-btn:hover {
            color: #c93a1f;
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Work Sans', sans-serif;
            font-size: 0.7rem;
            font-weight: 600;
            border: 2px solid var(--card-bg);
            min-width: 18px;
            padding: 0 2px;
        }

        .notification-badge.hidden {
            display: none;
        }

        .loading {
            text-align: center;
            padding: 3rem;
            color: var(--text-secondary);
            font-family: 'Work Sans', sans-serif;
        }

        .mark-read-btn {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Work Sans', sans-serif;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .mark-read-btn:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav">
            <div class="nav-brand">
                <a href="index.php" class="logo-link">
                    <img src="../assets/images/resonance.png" alt="Resonance Logo" class="logo-image">
                    <h1 class="logo">Resonance</h1>
                </a>
            </div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="profile/account.php" class="nav-link">My Account</a></li>
                <li class="nav-item"><a href="profile/settings.php" class="nav-link">Settings</a></li>
            </ul>
            <div class="nav-actions">
                <div class="notification-icon-wrapper">
                    <a href="notifications.php" class="notification-btn" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge hidden" id="notificationBadge">0</span>
                    </a>
                </div>
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

    <main class="main-content">
        <div class="container">
            <div class="notifications-header">
                <h1>Notifications</h1>
                <p>Your mailbox for post likes and comments</p>
            </div>

            <div class="mailbox-container">
                <div class="mailbox-header">
                    <h2><i class="fas fa-inbox"></i> Inbox</h2>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span class="notification-count" id="notificationCount">Loading...</span>
                        <button class="mark-read-btn" id="markAllReadBtn">Mark all read</button>
                    </div>
                </div>

                <div id="notificationsContainer">
                    <div class="loading">Loading notifications...</div>
                </div>
            </div>
        </div>
    </main>

    <script src="../assets/js/theme.js"></script>
    <script type="module">
        import { requireLogin, logout } from '../assets/js/auth.js';

        // Ensure user is logged in
        requireLogin();

        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logoutBtn');
            logoutBtn.addEventListener('click', logout);

            // Load notifications
            loadNotifications();
            loadNotificationCount();

            // Mark all read button
            document.getElementById('markAllReadBtn').addEventListener('click', markAllRead);
        });

        async function loadNotifications() {
            const token = localStorage.getItem('session_token');
            if (!token) {
                window.location.href = '../auth/login.html';
                return;
            }

            const container = document.getElementById('notificationsContainer');
            const countElement = document.getElementById('notificationCount');

            try {
                const response = await fetch('../api/get_notifications.php', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    if (response.status === 401) {
                        localStorage.removeItem('session_token');
                        window.location.href = '../auth/login.html';
                        return;
                    }
                    throw new Error('Failed to load notifications');
                }

                const data = await response.json();
                const notifications = data.notifications || [];

                // Update count
                const unreadCount = notifications.filter(n => !n.is_read).length;
                countElement.textContent = `${notifications.length} notification${notifications.length !== 1 ? 's' : ''} (${unreadCount} unread)`;

                if (notifications.length === 0) {
                    container.innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h3>No notifications yet</h3>
                            <p>You'll see likes and comments on your posts here</p>
                        </div>
                    `;
                    return;
                }

                // Render notifications
                container.innerHTML = '<ul class="notifications-list"></ul>';
                const list = container.querySelector('.notifications-list');

                notifications.forEach(notification => {
                    const item = document.createElement('li');
                    item.className = 'notification-item' + (notification.is_read ? '' : ' unread');
                    item.dataset.id = notification.id;
                    
                    const timeAgo = getTimeAgo(notification.created_at);
                    const userName = `${notification.from_first_name} ${notification.from_last_name}`;
                    const username = notification.from_username ? `@${notification.from_username}` : '';

                    if (notification.type === 'like') {
                        item.innerHTML = `
                            <div class="notification-header-row">
                                <div class="notification-icon like">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="notification-user-info">
                                    <p class="notification-user-name">${userName} ${username}</p>
                                    <p class="notification-action">liked your post</p>
                                </div>
                                <span class="notification-time">${timeAgo}</span>
                            </div>
                            <div class="notification-content">
                                <div class="notification-post-preview">${truncateText(notification.post_content, 100)}</div>
                            </div>
                        `;
                    } else if (notification.type === 'comment') {
                        item.innerHTML = `
                            <div class="notification-header-row">
                                <div class="notification-icon comment">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div class="notification-user-info">
                                    <p class="notification-user-name">${userName} ${username}</p>
                                    <p class="notification-action">commented on your post</p>
                                </div>
                                <span class="notification-time">${timeAgo}</span>
                            </div>
                            <div class="notification-content">
                                <div class="notification-post-preview">${truncateText(notification.post_content, 100)}</div>
                                <div class="notification-comment">
                                    <p class="notification-comment-text">${escapeHtml(notification.comment_content || '')}</p>
                                </div>
                            </div>
                        `;
                    }

                    // Make notification clickable (navigate to post and mark as read)
                    item.addEventListener('click', async function() {
                        await markAsRead(notification.id);
                        window.location.href = `blog/posts.php#post-${notification.post_id}`;
                    });

                    list.appendChild(item);
                });

            } catch (error) {
                console.error('Error loading notifications:', error);
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Error loading notifications</h3>
                        <p>Please try again later</p>
                    </div>
                `;
            }
        }

        async function loadNotificationCount() {
            const token = localStorage.getItem('session_token');
            if (!token) return;
            
            try {
                const response = await fetch('../api/get_notification_count.php', {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                });

                if (!response.ok) return;

                const data = await response.json();
                const count = data.unread_count || 0;
                const badge = document.getElementById('notificationBadge');
                
                if (count > 0) {
                    badge.textContent = count > 99 ? '99+' : count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            } catch (error) {
                console.error('Error loading notification count:', error);
            }
        }

        async function markAsRead(notificationId) {
            const token = localStorage.getItem('session_token');
            if (!token) return;

            try {
                await fetch('../api/mark_notification_read.php', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ notification_id: notificationId })
                });
            } catch (error) {
                console.error('Error marking notification as read:', error);
            }
        }

        async function markAllRead() {
            const token = localStorage.getItem('session_token');
            if (!token) return;

            try {
                await fetch('../api/mark_notification_read.php', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ mark_all: true })
                });

                // Reload notifications
                loadNotifications();
                loadNotificationCount();
            } catch (error) {
                console.error('Error marking all as read:', error);
            }
        }

        function getTimeAgo(dateString) {
            const now = new Date();
            const date = new Date(dateString);
            const diffInSeconds = Math.floor((now - date) / 1000);

            if (diffInSeconds < 60) {
                return 'just now';
            } else if (diffInSeconds < 3600) {
                const minutes = Math.floor(diffInSeconds / 60);
                return `${minutes} minute${minutes !== 1 ? 's' : ''} ago`;
            } else if (diffInSeconds < 86400) {
                const hours = Math.floor(diffInSeconds / 3600);
                return `${hours} hour${hours !== 1 ? 's' : ''} ago`;
            } else if (diffInSeconds < 604800) {
                const days = Math.floor(diffInSeconds / 86400);
                return `${days} day${days !== 1 ? 's' : ''} ago`;
            } else {
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: date.getFullYear() !== now.getFullYear() ? 'numeric' : undefined });
            }
        }

        function truncateText(text, maxLength) {
            if (!text) return '';
            if (text.length <= maxLength) return escapeHtml(text);
            return escapeHtml(text.substring(0, maxLength)) + '...';
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>

