<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Resonance</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.8; }
        }

        @keyframes slideUp {
            from { 
                opacity: 0; 
                transform: translateY(40px);
            }
            to { 
                opacity: 1; 
                transform: translateY(0);
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow: hidden;
        }
        
        body {
            background: #0a0a0a;
            animation: fadeIn 0.5s ease-out;
        }

        /* Header */
        .header {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            z-index: 1000 !important;
            background: rgba(20, 20, 20, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            transition: top 0.5s ease-out !important;
        }

        [data-theme="light"] .header {
            background: rgba(232, 232, 232, 0.95) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
        }

        .header.hidden {
            top: -100px !important;
        }

        /* Hover trigger zone at top of screen */
        .header-trigger {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            height: 50px !important;
            z-index: 1001 !important;
            background: transparent !important;
        }

        [data-theme="light"] .header {
            background: rgba(240, 240, 240, 0.95);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        #logoutBtn {
            cursor: pointer;
        }

        /* Tagline at top */
        .tagline-header {
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 100;
            text-align: center;
            pointer-events: none;
            opacity: 0;
            animation: slideUp 0.8s ease-out 0.3s forwards;
        }

        .tagline-header .tagline {
            font-family: 'Work Sans', sans-serif;
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: 5px;
            text-transform: uppercase;
            font-weight: 500;
            margin: 0;
        }

        [data-theme="light"] .tagline-header .tagline {
            color: rgba(0, 0, 0, 0.5);
        }

        /* Split panels container */
        .panels-container {
            display: flex;
            height: 100vh;
            padding-top: 0;
        }

        /* Individual panel */
        .panel {
            flex: 1;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: flex 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .panel::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.15;
            transition: opacity 0.5s ease;
        }

        .panel:hover {
            flex: 2;
        }

        .panel:hover::before {
            opacity: 0.3;
        }

        /* Panel backgrounds */
        .panel.match::before {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .panel.posts::before {
            background: linear-gradient(135deg, #ff8a3d 0%, #ff6b35 100%);
        }

        .panel.messages::before {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        /* Panel dividers */
        .panel:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 15%;
            height: 70%;
            width: 1px;
            background: linear-gradient(
                to bottom,
                transparent,
                rgba(255, 255, 255, 0.2) 20%,
                rgba(255, 255, 255, 0.2) 80%,
                transparent
            );
            z-index: 10;
        }

        [data-theme="light"] .panel:not(:last-child)::after {
            background: linear-gradient(
                to bottom,
                transparent,
                rgba(0, 0, 0, 0.1) 20%,
                rgba(0, 0, 0, 0.1) 80%,
                transparent
            );
        }

        /* Panel content */
        .panel-content {
            position: relative;
            z-index: 5;
            text-align: center;
            padding: 2rem;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.6s ease-out forwards;
        }

        .panel:nth-child(1) .panel-content { animation-delay: 0.5s; }
        .panel:nth-child(2) .panel-content { animation-delay: 0.65s; }
        .panel:nth-child(3) .panel-content { animation-delay: 0.8s; }

        /* Icon container */
        .panel-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: white;
            position: relative;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            animation: float 4s ease-in-out infinite;
        }

        .panel:nth-child(2) .panel-icon { animation-delay: -1.5s; }
        .panel:nth-child(3) .panel-icon { animation-delay: -3s; }

        .panel:hover .panel-icon {
            transform: scale(1.15);
        }

        /* Icon backgrounds */
        .panel.match .panel-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.4),
                        0 0 60px rgba(102, 126, 234, 0.2);
        }

        .panel.posts .panel-icon {
            background: linear-gradient(135deg, #ff8a3d 0%, #ff6b35 100%);
            box-shadow: 0 10px 40px rgba(255, 138, 61, 0.4),
                        0 0 60px rgba(255, 138, 61, 0.2);
        }

        .panel.messages .panel-icon {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            box-shadow: 0 10px 40px rgba(17, 153, 142, 0.4),
                        0 0 60px rgba(17, 153, 142, 0.2);
        }

        /* Glow ring */
        .panel-icon::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid transparent;
            opacity: 0;
            transition: all 0.4s ease;
        }

        .panel:hover .panel-icon::before {
            opacity: 1;
        }

        .panel.match:hover .panel-icon::before {
            border-color: rgba(102, 126, 234, 0.5);
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.3);
        }

        .panel.posts:hover .panel-icon::before {
            border-color: rgba(255, 138, 61, 0.5);
            box-shadow: 0 0 30px rgba(255, 138, 61, 0.3);
        }

        .panel.messages:hover .panel-icon::before {
            border-color: rgba(17, 153, 142, 0.5);
            box-shadow: 0 0 30px rgba(17, 153, 142, 0.3);
        }

        /* Panel title */
        .panel-title {
            font-family: 'Work Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.75rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.4s ease;
        }

        [data-theme="light"] .panel-title {
            color: #1a1a1a;
        }

        .panel:hover .panel-title {
            letter-spacing: 4px;
        }

        /* Panel description */
        .panel-desc {
            font-family: 'Work Sans', sans-serif;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.5);
            max-width: 200px;
            margin: 0 auto;
            line-height: 1.6;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.4s ease 0.1s;
        }

        [data-theme="light"] .panel-desc {
            color: rgba(0, 0, 0, 0.5);
        }

        .panel:hover .panel-desc {
            opacity: 1;
            transform: translateY(0);
        }

        /* Enter indicator */
        .panel-enter {
            position: absolute;
            bottom: 3rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Work Sans', sans-serif;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0;
            transition: all 0.4s ease 0.2s;
        }

        [data-theme="light"] .panel-enter {
            color: rgba(0, 0, 0, 0.3);
        }

        .panel:hover .panel-enter {
            opacity: 1;
        }

        .panel-enter i {
            font-size: 0.7rem;
            animation: pulse 1.5s ease-in-out infinite;
        }

        /* Background particles */
        .particles {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 138, 61, 0.3);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        [data-theme="light"] .particle {
            background: rgba(255, 138, 61, 0.2);
        }

        /* Light mode adjustments */
        [data-theme="light"] body {
            background: #f5f5f5;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .panels-container {
                flex-direction: column;
            }

            .panel:not(:last-child)::after {
                right: 15%;
                left: 15%;
                top: auto;
                bottom: 0;
                width: 70%;
                height: 1px;
                background: linear-gradient(
                    to right,
                    transparent,
                    rgba(255, 255, 255, 0.2) 20%,
                    rgba(255, 255, 255, 0.2) 80%,
                    transparent
                );
            }

            .tagline-header {
                top: 40px;
            }

            .tagline-header .tagline {
                font-size: 0.9rem;
                letter-spacing: 3px;
            }

            .panel-icon {
                width: 70px;
                height: 70px;
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }

            .panel-title {
                font-size: 1.2rem;
            }

            .panel-desc {
                opacity: 1;
                transform: translateY(0);
                font-size: 0.8rem;
            }

            .panel-enter {
                bottom: 1.5rem;
                opacity: 1;
            }
        }

        @media (max-width: 480px) {
            .dashboard-title-overlay h1 {
                font-size: 2.5rem;
                letter-spacing: 4px;
            }
        }
    </style>
</head>
<body>
    <!-- Invisible trigger zone for header -->
    <div class="header-trigger" id="headerTrigger"></div>
    
    <header class="header" id="mainHeader">
        <nav class="nav">
            <div class="nav-brand">
                <a href="index.php" class="logo-link">
                    <img src="../assets/images/resonance.png" alt="Resonance Logo" class="logo-image">
                    <h1 class="logo">Resonance</h1>
                </a>
            </div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="profile/account.php" class="nav-link">My Account</a></li>
                <li class="nav-item"><a href="profile/settings.php" class="nav-link">Settings</a></li>
            </ul>
            <div class="nav-actions">
                <a href="notifications.php" class="notification-btn" id="notificationBtn" aria-label="Notifications" style="background: none; border: none; color: var(--text-primary); font-size: 1.25rem; cursor: pointer; padding: 0.5rem; margin-right: 1rem; position: relative; text-decoration: none;">
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

    <!-- Floating particles background -->
    <div class="particles" id="particles"></div>

    <!-- Tagline -->
    <div class="tagline-header">
        <p class="tagline">Choose your path</p>
    </div>

    <!-- Split panels -->
    <main class="panels-container">
        <a href="blog/match.php" class="panel match">
            <div class="panel-content">
                <div class="panel-icon">
                    <i class="fas fa-music"></i>
                </div>
                <h2 class="panel-title">Match</h2>
                <p class="panel-desc">Find musicians who share your vibe</p>
            </div>
            <div class="panel-enter">
                <span>Enter</span>
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>

        <a href="blog/posts.php" class="panel posts">
            <div class="panel-content">
                <div class="panel-icon">
                    <i class="fas fa-pen-fancy"></i>
                </div>
                <h2 class="panel-title">Posts</h2>
                <p class="panel-desc">Share and discover opportunities</p>
            </div>
            <div class="panel-enter">
                <span>Enter</span>
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>

        <a href="blog/direct-message.php" class="panel messages">
            <div class="panel-content">
                <div class="panel-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <h2 class="panel-title">Messages</h2>
                <p class="panel-desc">Connect with your matches</p>
            </div>
            <div class="panel-enter">
                <span>Enter</span>
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
    </main>

    <script src="../assets/js/auth.js"></script>
    <script src="../assets/js/theme.js"></script>
    
    <!-- Header animation script -->
    <script>
        (function() {
            window.addEventListener('load', function() {
                var header = document.getElementById('mainHeader');
                var trigger = document.getElementById('headerTrigger');
                var hideTimeout = null;
                var isHovering = false;
                
                if (!header || !trigger) return;

                // Slide up after 1.2 seconds
                setTimeout(function() {
                    if (!isHovering) {
                        header.classList.add('hidden');
                    }
                }, 1200);

                function showHeader() {
                    isHovering = true;
                    // Cancel any pending hide
                    if (hideTimeout) {
                        clearTimeout(hideTimeout);
                        hideTimeout = null;
                    }
                    header.classList.remove('hidden');
                }

                function scheduleHide() {
                    isHovering = false;
                    // Wait 2 seconds before hiding
                    hideTimeout = setTimeout(function() {
                        if (!isHovering) {
                            header.classList.add('hidden');
                        }
                    }, 1000);
                }

                // Show on hover
                trigger.onmouseenter = showHeader;
                header.onmouseenter = showHeader;

                // Schedule hide when leaving
                header.onmouseleave = function(e) {
                    var related = e.relatedTarget;
                    if (related !== trigger && !(trigger.contains && trigger.contains(related))) {
                        scheduleHide();
                    }
                };

                trigger.onmouseleave = function(e) {
                    var related = e.relatedTarget;
                    if (related !== header && !(header.contains && header.contains(related))) {
                        scheduleHide();
                    }
                };
            });
        })();
    </script>

    <script type="module">
        import { checkSession, requireLogin, logout } from '../assets/js/auth.js';

        console.log('Dashboard loading, checking session...');
        requireLogin();

        // Create floating particles
        function createParticles() {
            const container = document.getElementById('particles');
            const particleCount = 30;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (6 + Math.random() * 4) + 's';
                particle.style.opacity = 0.1 + Math.random() * 0.3;
                particle.style.width = (2 + Math.random() * 4) + 'px';
                particle.style.height = particle.style.width;
                container.appendChild(particle);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logoutBtn');
            logoutBtn.addEventListener('click', logout);
            
            createParticles();
            loadNotificationCount();
        });

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
</body>
</html>
