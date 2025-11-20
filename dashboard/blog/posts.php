<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts - Resonance</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .posts-wrapper {
            max-width: 960px;
            margin: 100px auto;
            padding: 0 20px;
        }

        .create-post {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px var(--shadow-sm);
        }

        .create-post textarea {
            width: 100%;
            min-height: 100px;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-size: 1rem;
            resize: vertical;
            margin-bottom: 1rem;
        }

        .create-post-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .post-attachments {
            display: flex;
            gap: 1rem;
        }

        .attachment-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.5rem;
            transition: color 0.3s;
        }

        .attachment-btn:hover {
            color: #9b2c1a;
        }

        .posts-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .post {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px var(--shadow-sm);
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .post-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--bg-secondary);
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9b2c1a;
        }

        .post-user {
            flex: 1;
        }

        .post-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .post-time {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .post-content {
            margin-bottom: 1rem;
            color: var(--text-primary);
            line-height: 1.5;
        }

        .post-actions {
            display: flex;
            gap: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .post-action {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        .post-action:hover {
            color: #9b2c1a;
        }

        .post-media {
            margin: 1rem 0;
            border-radius: 8px;
            overflow: hidden;
        }

        .post-media img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .post-media audio {
            width: 100%;
            margin: 0.5rem 0;
        }

        #noPostsMessage {
            text-align: center;
            padding: 2rem;
            color: var(--text-secondary);
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
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

    <main class="posts-wrapper">
        <div class="create-post">
            <textarea id="postContent" placeholder="Share your musical thoughts, find bandmates, or schedule jam sessions..."></textarea>
            <div class="create-post-actions">
                <div class="post-attachments">
                    <button type="button" class="attachment-btn" title="Upload Photo">
                        <i class="fas fa-image"></i>
                    </button>
                    <button type="button" class="attachment-btn" title="Upload Audio">
                        <i class="fas fa-music"></i>
                    </button>
                    <button type="button" class="attachment-btn" title="Schedule Event">
                        <i class="fas fa-calendar"></i>
                    </button>
                </div>
                <button type="button" class="btn btn-primary" id="submitPost">Post</button>
            </div>
        </div>

        <div class="posts-list" id="postsList">
            <div id="noPostsMessage">No posts yet. Be the first to share something!</div>
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

        console.log('Posts page loading, checking session...');
        
        // Ensure user is logged in
        requireLogin();

        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logoutBtn');
            const submitPostBtn = document.getElementById('submitPost');
            const postContent = document.getElementById('postContent');
            const postsList = document.getElementById('postsList');

            // Handle logout
            logoutBtn.addEventListener('click', logout);

            // Handle post submission
            submitPostBtn.addEventListener('click', async function() {
                const content = postContent.value.trim();
                if (!content) return;

                submitPostBtn.disabled = true;
                
                try {
                    const token = localStorage.getItem('session_token');
                    const response = await fetch('../../api/create_post.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify({ content })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to create post');
                    }

                    // Clear the textarea
                    postContent.value = '';
                    
                    // Refresh posts
                    loadPosts();
                } catch (error) {
                    console.error('Error creating post:', error);
                    alert('Failed to create post. Please try again.');
                } finally {
                    submitPostBtn.disabled = false;
                }
            });

            async function loadPosts() {
                try {
                    const token = localStorage.getItem('session_token');
                    const response = await fetch('../../api/get_posts.php', {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Failed to load posts');
                    }

                    const posts = await response.json();
                    
                    if (posts.length === 0) {
                        postsList.innerHTML = '<div id="noPostsMessage">No posts yet. Be the first to share something!</div>';
                        return;
                    }

                    postsList.innerHTML = posts.map(post => `
                        <article class="post">
                            <div class="post-header">
                                <div class="post-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="post-user">
                                    <div class="post-name">${post.first_name} ${post.last_name}</div>
                                    <div class="post-time">${new Date(post.created_at).toLocaleString()}</div>
                                </div>
                            </div>
                            <div class="post-content">${post.content}</div>
                            <div class="post-actions">
                                <div class="post-action">
                                    <i class="far fa-heart"></i>
                                    <span>Like</span>
                                </div>
                                <div class="post-action">
                                    <i class="far fa-comment"></i>
                                    <span>Comment</span>
                                </div>
                                <div class="post-action">
                                    <i class="far fa-share-square"></i>
                                    <span>Share</span>
                                </div>
                            </div>
                        </article>
                    `).join('');

                } catch (error) {
                    console.error('Error loading posts:', error);
                    postsList.innerHTML = '<div class="error-message">Failed to load posts. Please try again later.</div>';
                }
            }

            // Initial load
            loadPosts();

            // Reload posts periodically
            setInterval(loadPosts, 30000); // Every 30 seconds
        });
    </script>
    <script src="../../assets/js/theme.js"></script>
</body>
</html>