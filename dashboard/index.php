<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Resonance</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Override body background for dashboard */
        html {
            height: 100%;
        }
        
        body {
            min-height: 100vh;
            margin: 0;
            padding: 80px 0 0 0;
            background: transparent !important;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Music background with blur */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100vw;
            height: 100vh;
            background-image: url('../assets/images/music.png');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            filter: blur(3px);
            z-index: -999;
            transition: filter 0.3s ease;
        }
        
        /* Dark theme background effect */
        [data-theme="dark"] body::before {
            filter: invert(1) hue-rotate(180deg) blur(3px);
        }
        
        /* Ensure header stays above background and fixed at top */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1000;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Make feature cards clickable */
        .feature-card {
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12), 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        [data-theme="dark"] .feature-card {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4),
                        0 0 20px rgba(255, 138, 61, 0.3),
                        0 0 40px rgba(255, 138, 61, 0.15);
        }

        .feature-card-link {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            text-decoration: none;
        }

        .feature-card:hover {
            transform: translateY(-8px);
        }
        
        [data-theme="light"] .feature-card:hover {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2), 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        [data-theme="dark"] .feature-card:hover {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5),
                        0 0 30px rgba(255, 138, 61, 0.5),
                        0 0 60px rgba(255, 138, 61, 0.3),
                        0 0 90px rgba(255, 138, 61, 0.15);
        }

        .feature-card:active {
            transform: translateY(-4px);
        }

        /* Ensure content stays above the link but doesn't interfere with clicking */
        .feature-card > *:not(.feature-card-link) {
            position: relative;
            z-index: 0;
            pointer-events: none;
        }
        
        /* Make sure the link is clickable */
        .feature-card-link {
            pointer-events: auto;
        }

        /* Dashboard specific styles */
        #features-section {
            padding-top: 50px;
            min-height: 100vh;
            position: relative;
            z-index: 1;
            background: transparent !important;
        }
        
        .container {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }
        
        .features {
            padding-top: 0 !important;
        }
        
        .features {
            background: transparent !important;
        }
        
        .container {
            background: transparent !important;
        }
        
        /* Box around dashboard title */
        .dashboard-header-box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 1.25rem 2rem;
            margin: 0 auto 4rem;
            max-width: 600px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15), 0 4px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: box-shadow 0.3s ease, border 0.3s ease;
        }
        
        [data-theme="dark"] .dashboard-header-box {
            background: rgba(30, 30, 30, 0.9);
            border: 1px solid rgba(255, 138, 61, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 
                        0 0 30px rgba(255, 138, 61, 0.4),
                        0 0 60px rgba(255, 138, 61, 0.2),
                        0 0 90px rgba(255, 138, 61, 0.1);
        }
        
        .dashboard-header-box .section-title {
            margin-bottom: 0.5rem;
            margin-top: 0;
        }
        
        .dashboard-header-box .section-subtitle {
            margin-bottom: 0;
        }
        
        .features-grid {
            margin-top: 3rem !important;
            padding-bottom: 4rem;
        }

        #logoutBtn {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav">
            <div class="nav-brand">
                <a href="../index.html" class="logo-link">
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

    <div id="features-section">
        <section id="features" class="features">
            <div class="container">
                <div class="dashboard-header-box">
                    <h2 class="section-title">Your Resonance Dashboard</h2>
                    <p class="section-subtitle ws-regular">Get started:</p>
                </div>
                
                <div class="features-grid">
                    <!-- Smart Matching Card -->
                    <div class="feature-card">
                        <a href="blog/match.php" class="feature-card-link" aria-label="Go to Smart Matching"></a>
                        <div class="feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Smart Matching</h3>
                        <p class="ws-regular">AI-powered algorithm matches you with students who share your music taste, goals, and availability.</p>
                    </div>
                    
                    <!-- Post & Find Card -->
                    <div class="feature-card">
                        <a href="blog/posts.php" class="feature-card-link" aria-label="Go to Posts"></a>
                        <div class="feature-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h3>Post & Find</h3>
                        <p class="ws-regular">Create posts for practice sessions, project collaborations, or performances. Find exactly what you're looking for.</p>
                    </div>
                    
                    <!-- Real-time Chat Card -->
                    <div class="feature-card">
                        <a href="blog/direct-message.php" class="feature-card-link" aria-label="Go to Messages"></a>
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>Real-time Chat</h3>
                        <p class="ws-regular">Seamless communication with your matches. From quick practice sessions to long-term project partnerships.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
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
                        <li><a href="../index.html">Home</a></li>
                        <li><a href="profile/account.php">My Account</a></li>
                        <li><a href="profile/settings.php">Settings</a></li>
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
    <script src="../assets/js/auth.js"></script>
    <script src="../assets/js/theme.js"></script>
    <script type="module">
        import { checkSession, requireLogin, logout } from '../assets/js/auth.js';

        console.log('Dashboard loading, checking session...');
        
        // Ensure user is logged in
        requireLogin();

        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logoutBtn');

            // Handle logout
            logoutBtn.addEventListener('click', logout);

            // Optional: Add keyboard navigation for accessibility
            document.querySelectorAll('.feature-card').forEach(card => {
                card.setAttribute('tabindex', '0');
                card.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const link = this.querySelector('.feature-card-link');
                        if (link) {
                            window.location.href = link.href;
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>