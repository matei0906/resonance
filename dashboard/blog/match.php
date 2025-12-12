<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Match - Resonance</title>
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

        :root:not([data-theme="dark"]) .match-card {
            background: #ffffff !important;
        }

        /* Dropdown Navigation */
        .nav-item.has-dropdown {
            position: relative;
        }

        .nav-item.has-dropdown .nav-link {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .nav-item.has-dropdown .nav-link i {
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }

        .nav-item.has-dropdown:hover .nav-link i {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            padding: 0.5rem 0;
            min-width: 140px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .nav-item.has-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 0.25rem 1rem;
            color: var(--text-primary);
            text-decoration: none;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .dropdown-item:hover {
            color: #9b2c1a;
        }

        .dropdown-item.active {
            color: #9b2c1a;
            font-weight: 600;
        }

        .main-content {
            padding: 2rem 0;
            min-height: calc(100vh - 80px);
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .page-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .matches-grid {
            display: grid;
            gap: 1.5rem;
        }

        .match-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px var(--shadow-sm);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .match-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px var(--shadow-md);
        }

        .match-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .match-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #9b2c1a 0%, #ff8a3d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            flex-shrink: 0;
            overflow: hidden;
        }

        .match-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .match-info {
            flex: 1;
        }

        .match-name {
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .match-username {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .match-score {
            text-align: center;
        }

        .score-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #9b2c1a 0%, #ff8a3d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.25rem;
        }

        .score-value {
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
        }

        .score-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .match-details {
            border-top: 1px solid var(--border-color);
            padding-top: 1rem;
        }

        .common-section {
            margin-bottom: 0.75rem;
        }

        .common-section:last-child {
            margin-bottom: 0;
        }

        .common-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #9b2c1a;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .common-label i {
            width: 16px;
        }

        .common-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .common-tag {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            color: var(--text-primary);
            font-weight: 500;
        }

        .no-common {
            color: var(--text-secondary);
            font-size: 0.8rem;
            font-style: italic;
        }

        .loading-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--border-color);
            border-top-color: #9b2c1a;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .match-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .match-actions .btn {
            flex: 1;
            text-align: center;
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }

        /* Score color variations based on percentage */
        .score-high { background: linear-gradient(135deg, #28a745 0%, #5cb85c 100%); }
        .score-medium { background: linear-gradient(135deg, #ff8a3d 0%, #ffc107 100%); }
        .score-low { background: linear-gradient(135deg, #9b2c1a 0%, #dc3545 100%); }

        .breakdown-bar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .breakdown-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            width: 100px;
        }

        .breakdown-progress {
            flex: 1;
            height: 6px;
            background: var(--border-color);
            border-radius: 3px;
            overflow: hidden;
        }

        .breakdown-fill {
            height: 100%;
            background: linear-gradient(90deg, #9b2c1a, #ff8a3d);
            border-radius: 3px;
            transition: width 0.5s ease;
        }

        .breakdown-value {
            font-size: 0.75rem;
            color: var(--text-secondary);
            width: 35px;
            text-align: right;
        }

        /* Skill Exchange Section */
        .skill-exchange {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .skill-exchange-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            padding: 0.5rem 0.75rem;
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(32, 201, 151, 0.1) 100%);
            border-radius: 8px;
            border-left: 3px solid #28a745;
        }

        .skill-exchange-item.you-teach {
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.1) 0%, rgba(0, 86, 179, 0.1) 100%);
            border-left-color: #007bff;
        }

        .skill-exchange-icon {
            font-size: 0.9rem;
            margin-top: 2px;
        }

        .skill-exchange-item:not(.you-teach) .skill-exchange-icon {
            color: #28a745;
        }

        .skill-exchange-item.you-teach .skill-exchange-icon {
            color: #007bff;
        }

        .skill-exchange-text {
            flex: 1;
            font-size: 0.85rem;
            color: var(--text-primary);
        }

        .skill-exchange-text strong {
            font-weight: 600;
        }

        .skill-instruments {
            color: #9b2c1a;
            font-weight: 600;
        }

        /* Social Links Dropdown */
        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-dropdown {
            position: relative;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-secondary);
            color: var(--text-primary);
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .social-link:hover {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            transform: translateY(-3px);
        }

        .social-dropdown-menu {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.5rem 0;
            margin-bottom: 0.5rem;
            min-width: 180px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px var(--shadow-sm);
            z-index: 100;
        }

        .social-dropdown:hover .social-dropdown-menu {
            opacity: 1;
            visibility: visible;
        }

        .social-dropdown-item {
            display: block;
            padding: 0.6rem 1rem;
            color: var(--text-primary);
            text-decoration: none;
            transition: background 0.2s;
            font-size: 0.9rem;
        }

        .social-dropdown-item:hover {
            background: var(--bg-secondary);
            color: #ff6b35;
        }

        .social-dropdown-item i {
            margin-right: 0.5rem;
            width: 16px;
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
                <li class="nav-item has-dropdown">
                    <a href="../index.php" class="nav-link">Dashboard <i class="fas fa-chevron-down"></i></a>
                    <div class="dropdown-menu">
                        <a href="posts.php" class="dropdown-item">Posts</a>
                        <a href="match.php" class="dropdown-item active">Smart Match</a>
                        <a href="direct-message.php" class="dropdown-item">Messages</a>
                    </div>
                </li>
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

    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-magic"></i> Smart Match</h1>
                <p class="page-subtitle">Find musicians who share your musical interests and availability</p>
            </div>

            <div id="loadingState" class="loading-state">
                <div class="loading-spinner"></div>
                <p>Finding your best matches...</p>
            </div>

            <div id="emptyState" class="empty-state" style="display: none;">
                <i class="fas fa-users-slash"></i>
                <h3>No matches found</h3>
                <p>Update your preferences in Settings to find musicians who resonate with you!</p>
                <a href="../profile/settings.php" class="btn btn-primary" style="margin-top: 1rem;">Update Preferences</a>
            </div>

            <div id="matchesContainer" class="matches-grid" style="display: none;">
                <!-- Matches will be loaded here -->
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
                        <li><a href="../index.php">Dashboard</a></li>
                        <li><a href="../profile/settings.php">Settings</a></li>
                        <li><a href="../profile/account.php">Account</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <div class="social-dropdown">
                            <div class="social-link" aria-label="GitHub">
                                <i class="fab fa-github"></i>
                            </div>
                            <div class="social-dropdown-menu">
                                <a href="https://github.com/matei0906/" class="social-dropdown-item" target="_blank">
                                    <i class="fas fa-user"></i> Matei Stoica
                                </a>
                                <a href="https://github.com/brzozs" class="social-dropdown-item" target="_blank">
                                    <i class="fas fa-user"></i> Sebastian Brzozowski
                                </a>
                            </div>
                        </div>
                        <div class="social-dropdown">
                            <div class="social-link" aria-label="LinkedIn">
                                <i class="fab fa-linkedin"></i>
                            </div>
                            <div class="social-dropdown-menu">
                                <a href="https://www.linkedin.com/in/matei-stoica-698aa4348/" class="social-dropdown-item" target="_blank">
                                    <i class="fas fa-user"></i> Matei Stoica
                                </a>
                                <a href="https://www.linkedin.com/in/sebastian-brzozowski-848069358/" class="social-dropdown-item" target="_blank">
                                    <i class="fas fa-user"></i> Sebastian Brzozowski
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Resonance. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../../assets/js/theme.js"></script>
    <script type="module">
        import { checkSession, requireLogin, logout } from '../../assets/js/auth.js';

        document.addEventListener('DOMContentLoaded', () => {
            requireLogin();
            document.getElementById('logoutBtn').addEventListener('click', logout);
            loadNotificationCount();
            loadMatches();
        });

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

        async function loadMatches() {
            const token = localStorage.getItem('session_token');
            if (!token) return;

            const loadingState = document.getElementById('loadingState');
            const emptyState = document.getElementById('emptyState');
            const matchesContainer = document.getElementById('matchesContainer');

            try {
                const response = await fetch('../../api/get_matches.php', {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to load matches');
                }

                const data = await response.json();

                loadingState.style.display = 'none';

                if (!data.matches || data.matches.length === 0) {
                    emptyState.style.display = 'block';
                    return;
                }

                matchesContainer.style.display = 'grid';
                matchesContainer.innerHTML = data.matches.map(match => createMatchCard(match)).join('');

            } catch (error) {
                console.error('Error loading matches:', error);
                loadingState.innerHTML = `
                    <i class="fas fa-exclamation-circle" style="font-size: 3rem; margin-bottom: 1rem; color: #dc3545;"></i>
                    <p>Failed to load matches. Please try again later.</p>
                `;
            }
        }

        function createMatchCard(match) {
            const user = match.user;
            const percentage = match.match_percentage;
            const common = match.common_interests;
            const breakdown = match.breakdown;
            const skillExchange = match.skill_exchange || { can_teach_you: [], you_can_teach: [] };

            // Determine score color class
            let scoreClass = 'score-low';
            if (percentage >= 70) scoreClass = 'score-high';
            else if (percentage >= 40) scoreClass = 'score-medium';

            // Get initials for avatar fallback
            const initials = user.name ? user.name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2) : '?';

            // Avatar HTML
            const avatarContent = user.profile_photo 
                ? `<img src="../../${user.profile_photo}" alt="${user.name}">`
                : initials;

            // Build common sections (only genres and availability)
            const sections = [
                { key: 'genres', label: 'Common Genres', icon: 'fa-music' },
                { key: 'availability', label: 'Common Availability', icon: 'fa-clock' }
            ];

            const commonSectionsHtml = sections.map(section => {
                const items = common[section.key] || [];
                if (items.length === 0) return '';
                
                return `
                    <div class="common-section">
                        <div class="common-label">
                            <i class="fas ${section.icon}"></i>
                            ${section.label}
                        </div>
                        <div class="common-tags">
                            ${items.map(item => `<span class="common-tag">${capitalizeFirst(item)}</span>`).join('')}
                        </div>
                    </div>
                `;
            }).join('');

            // Build breakdown bars
            const breakdownHtml = Object.entries(breakdown).map(([category, data]) => {
                const label = category === 'instrument_interests' ? 'Interest' : capitalizeFirst(category);
                const percent = Math.round((data.score / data.max) * 100);
                return `
                    <div class="breakdown-bar">
                        <span class="breakdown-label">${label}</span>
                        <div class="breakdown-progress">
                            <div class="breakdown-fill" style="width: ${percent}%"></div>
                        </div>
                        <span class="breakdown-value">${percent}%</span>
                    </div>
                `;
            }).join('');

            // Build skill exchange section
            let skillExchangeHtml = '';
            const canTeachYou = skillExchange.can_teach_you || [];
            const youCanTeach = skillExchange.you_can_teach || [];
            
            if (canTeachYou.length > 0 || youCanTeach.length > 0) {
                let exchangeItems = '';
                
                if (canTeachYou.length > 0) {
                    const instruments = canTeachYou.map(i => capitalizeFirst(i)).join(', ');
                    exchangeItems += `
                        <div class="skill-exchange-item">
                            <i class="fas fa-lightbulb skill-exchange-icon"></i>
                            <div class="skill-exchange-text">
                                <strong>${escapeHtml(user.name.split(' ')[0])}</strong> knows <span class="skill-instruments">${instruments}</span>
                            </div>
                        </div>
                    `;
                }
                
                if (youCanTeach.length > 0) {
                    const instruments = youCanTeach.map(i => capitalizeFirst(i)).join(', ');
                    exchangeItems += `
                        <div class="skill-exchange-item you-teach">
                            <i class="fas fa-search skill-exchange-icon"></i>
                            <div class="skill-exchange-text">
                                <strong>${escapeHtml(user.name.split(' ')[0])}</strong> is looking for <span class="skill-instruments">${instruments}</span>
                            </div>
                        </div>
                    `;
                }
                
                skillExchangeHtml = `<div class="skill-exchange">${exchangeItems}</div>`;
            }

            return `
                <div class="match-card">
                    <div class="match-header">
                        <div class="match-avatar">${avatarContent}</div>
                        <div class="match-info">
                            <div class="match-name">${escapeHtml(user.name || 'Unknown User')}</div>
                            <div class="match-username">@${escapeHtml(user.username || 'unknown')}</div>
                        </div>
                        <div class="match-score">
                            <div class="score-circle ${scoreClass}">
                                <span class="score-value">${percentage}%</span>
                            </div>
                            <div class="score-label">Match</div>
                        </div>
                    </div>
                    
                    ${breakdownHtml ? `<div style="margin-bottom: 1rem;">${breakdownHtml}</div>` : ''}
                    
                    ${commonSectionsHtml ? `<div class="match-details">${commonSectionsHtml}</div>` : ''}
                    
                    ${skillExchangeHtml}
                    
                    <div class="match-actions">
                        <a href="direct-message.php?user_id=${user.id}" class="btn btn-primary">
                            <i class="fas fa-envelope"></i> Message
                        </a>
                    </div>
                </div>
            `;
        }

        function capitalizeFirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>
