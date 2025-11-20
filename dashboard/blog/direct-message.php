<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Resonance</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .messages-wrapper {
            max-width: 1200px;
            margin: 100px auto;
            padding: 0 20px;
            min-height: 60vh;
        }

        .messages-container {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 5px 20px var(--shadow-sm);
            text-align: center;
        }

        .messages-container h2 {
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .messages-container p {
            color: var(--text-secondary);
        }
    </style>
</head>
<body>
    <!-- Navigation Header -->
    <header class="header">
        <nav class="nav">
            <div class="nav-brand">
                <a href="../index.html" class="logo-link">
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
        <div class="messages-container">
            <h2>Real-time Chat</h2>
            <p class="ws-regular">Direct messaging feature coming soon!</p>
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

            // Handle logout
            logoutBtn.addEventListener('click', logout);
        });
    </script>
    <script src="../../assets/js/theme.js"></script>
</body>
</html>

