<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Match - Resonance</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigation Header -->
    <header class="header">
        <nav class="nav">
            <div class="nav-brand">
                <a href="../../index.html" class="logo-link">
                    <img src="../../assets/images/resonance.png" alt="Resonance Logo" class="logo-image">
                    <h1 class="logo">Resonance</h1>
                </a>
            </div>
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
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="./auth/quiz.html">Create an Account</a></li>
                        <li><a href="./auth/login.html">Log In</a></li>
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
        document.addEventListener('DOMContentLoaded', () => {
            requireLogin();
            document.getElementById('logoutBtn').addEventListener('click', logout);
        });
    </script>
    <script src="../../assets/js/theme.js"></script>
</body>
</html>