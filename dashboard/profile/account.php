<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Resonance</title>
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

        :root:not([data-theme="dark"]) .account-info,
        :root:not([data-theme="dark"]) .modal-content {
            background: #ffffff !important;
        }

        .main-content {
            padding: 2rem 0;
            min-height: calc(100vh - 80px);
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .account-info {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px var(--shadow-sm);
            margin-top: 2rem;
        }
        
        .profile-section {
            display: flex;
            align-items: flex-start;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .profile-details {
            padding-top: 0.75rem;
        }
        
        .profile-photo {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
        
        .profile-photo img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--accent-color);
        }
        
        .profile-details h2 {
            margin: 0 0 0.5rem 0;
            color: var(--text-primary);
        }
        
        .profile-details p {
            margin: 0;
            color: var(--text-secondary);
        }
        
        .account-details {
            display: grid;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .detail-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .detail-group label {
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .detail-group input {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--input-bg);
            color: var(--text-primary);
            font-size: 1rem;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .detail-group input[readonly] {
            background: var(--bg-secondary);
            cursor: not-allowed;
        }
        
        .account-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }
        
        .btn-link {
            background: none;
            border: none;
            color: #c93a1f;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            font-family: 'Work Sans', sans-serif;
            font-weight: 600;
            padding: 0;
            text-align: left;
            transition: color 0.3s ease;
        }
        
        .btn-link:hover {
            color: #9b2c1a;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            top: 100px;
            left: 50%;
            transform: translateX(-50%) translateY(-20px);
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(40, 167, 69, 0.3);
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .toast.show {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        .toast i {
            font-size: 1.25rem;
        }

        .toast.error {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            box-shadow: 0 10px 40px rgba(220, 53, 69, 0.3);
        }
        
        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal.hidden {
            display: none;
        }
        
        #photoInput {
            display: none;
        }
        
        .modal-content {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 0;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px var(--shadow-sm);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .modal-header h3 {
            margin: 0;
            color: var(--text-primary);
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-secondary);
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--input-bg);
            color: var(--text-primary);
            font-size: 1rem;
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            box-sizing: border-box;
        }
        
        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }
        
        /* Password strength indicator */
        .strength {
            margin-top: 0.5rem;
        }
        
        .strength-bar {
            height: 6px;
            background: #e0e0e0;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }
        
        .strength-bar span {
            display: block;
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 3px;
        }
        
        .strength-label {
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
    </style>
    <body>
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
                    <li class="nav-item"><a href="account.php" class="nav-link">My Account</a></li>
                    <li class="nav-item"><a href="settings.php" class="nav-link">Settings</a></li>
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

        <!-- Toast Notification -->
        <div class="toast" id="toast">
            <i class="fas fa-check-circle"></i>
            <span id="toastMessage">Success!</span>
        </div>

        <main class="main-content">
            <div class="container">
                <h1>My Account</h1>
                <div class="account-info">
                    <div class="profile-section">
                        <div class="profile-photo">
                            <img id="profilePhoto" src="../../assets/images/default.png" alt="Profile Photo">
                            <button class="btn btn-secondary" id="changePhotoBtn">Change Photo</button>
                            <input type="file" id="photoInput" accept="image/*">
                        </div>
                        <div class="profile-details">
                            <h2 id="fullName">Loading...</h2>
                            <p id="username">@loading</p>
                        </div>
                    </div>
                    
                    <div class="account-details">
                        <div class="detail-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" readonly>
                        </div>
                        <div class="detail-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" id="firstName">
                        </div>
                        <div class="detail-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" id="lastName">
                        </div>
                        <div class="detail-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" placeholder="••••••••">
                            <button class="btn btn-link" id="changePasswordBtn">Change Password</button>
                        </div>
                        <div class="detail-group">
                            <label>Last Login:</label>
                            <span id="lastLogin">Loading...</span>
                        </div>
                    </div>
                    
                    <div class="account-actions">
                        <button class="btn btn-primary" id="saveBtn">Save Changes</button>
                        <button class="btn btn-outline" id="cancelBtn">Cancel</button>
                    </div>
                </div>
            </div>
        </main>

        <!-- Password Change Modal -->
        <div id="passwordModal" class="modal hidden">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Change Password</h3>
                    <button class="modal-close" id="passwordModalClose">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="passwordForm">
                        <div class="form-group">
                            <label for="currentPassword">Current Password:</label>
                            <input type="password" id="currentPassword" required>
                        </div>
                        <div class="form-group">
                            <label for="newPassword">New Password:</label>
                            <input type="password" id="newPassword" required minlength="8">
                            <div class="strength">
                                <div class="strength-bar"><span id="strengthFill"></span></div>
                                <div class="strength-label" id="strengthLabel">Strength: </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm New Password:</label>
                            <input type="password" id="confirmPassword" required minlength="8">
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="btn btn-outline" id="passwordCancelBtn">Cancel</button>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script src="../../assets/js/theme.js"></script>
    <script>
        // Logout functionality
        document.getElementById('logoutBtn').addEventListener('click', function() {
            // Clear any session data
            localStorage.removeItem('session_token');
            localStorage.removeItem('session_expiry');
            
            // Redirect to home page
            window.location.href = '../../index.html';
        });

        // Load account data
        async function loadAccountData() {
            const token = localStorage.getItem('session_token');
            if (!token) {
                window.location.href = '../../auth/login.html';
                return;
            }

            try {
                const response = await fetch('../../api/get_account.php', {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    if (response.status === 401) {
                        localStorage.removeItem('session_token');
                        window.location.href = '../../auth/login.html';
                        return;
                    }
                    throw new Error('Failed to load account data');
                }

                const data = await response.json();
                
                // Check if we have the user object (new format) or direct properties (old format)
                const user = data.user || data;
                
                // Populate fields
                document.getElementById('fullName').textContent = user.first_name + ' ' + user.last_name;
                document.getElementById('username').textContent = '@' + user.username;
                document.getElementById('email').value = user.email;
                document.getElementById('firstName').value = user.first_name;
                document.getElementById('lastName').value = user.last_name;
                document.getElementById('lastLogin').textContent = getTimeAgo(new Date(user.last_login));
                
                // Set profile photo with fallback to default
                const profilePhotoElement = document.getElementById('profilePhoto');
                if (user.profile_photo) {
                    console.log('Loading profile photo:', user.profile_photo + '?t=' + Date.now());
                    profilePhotoElement.src = user.profile_photo + '?t=' + Date.now();
                } else {
                    console.log('No profile photo found, using default');
                    profilePhotoElement.src = '../../assets/images/default.png';
                }
                
            } catch (error) {
                console.error('Error loading account data:', error);
                alert('Failed to load account data. Please try again.');
            }
        }

        // Save changes
        document.getElementById('saveBtn').addEventListener('click', async function() {
            const token = localStorage.getItem('session_token');
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            
            try {
                const response = await fetch('../../api/update_account.php', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        first_name: firstName,
                        last_name: lastName
                    })
                });

                if (!response.ok) {
                    throw new Error('Failed to update account');
                }

                alert('Account updated successfully!');
                loadAccountData(); // Reload data
                
            } catch (error) {
                console.error('Error updating account:', error);
                alert('Failed to update account. Please try again.');
            }
        });

        // Cancel changes
        document.getElementById('cancelBtn').addEventListener('click', function() {
            loadAccountData(); // Reload original data
        });

        // Change password
        document.getElementById('changePasswordBtn').addEventListener('click', function() {
            document.getElementById('passwordModal').classList.remove('hidden');
            document.getElementById('passwordForm').reset();
            // Reset strength indicator
            document.getElementById('strengthFill').style.width = '0%';
            document.getElementById('strengthLabel').textContent = 'Strength: ';
        });

        // Close password modal
        document.getElementById('passwordModalClose').addEventListener('click', function() {
            document.getElementById('passwordModal').classList.add('hidden');
            document.getElementById('passwordForm').reset();
            // Reset strength indicator
            document.getElementById('strengthFill').style.width = '0%';
            document.getElementById('strengthLabel').textContent = 'Strength: ';
        });

        document.getElementById('passwordCancelBtn').addEventListener('click', function() {
            document.getElementById('passwordModal').classList.add('hidden');
            document.getElementById('passwordForm').reset();
            // Reset strength indicator
            document.getElementById('strengthFill').style.width = '0%';
            document.getElementById('strengthLabel').textContent = 'Strength: ';
        });

        // Password strength evaluation
        function evaluatePasswordStrength(password) {
            let score = 0;
            if (!password) return score;

            // Length bonus
            if (password.length >= 8) score++;
            if (password.length >= 12) score++;
            if (password.length >= 16) score++;

            // Character variety
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^a-zA-Z0-9]/.test(password)) score++;

            return score;
        }

        // Update password strength indicator
        function updatePasswordStrength() {
            const password = document.getElementById('newPassword').value;
            const score = evaluatePasswordStrength(password);
            const strengthFill = document.getElementById('strengthFill');
            const strengthLabel = document.getElementById('strengthLabel');
            
            let width = 0, color = '', label = '';

            if (score === 0) {
                width = 0; color = ''; label = '';
            } else if (score <= 1) {
                width = 20; color = '#dc3545'; label = 'Very Weak';
            } else if (score === 2) {
                width = 40; color = '#ff8c42'; label = 'Weak';
            } else if (score === 3) {
                width = 60; color = '#ffc107'; label = 'Fair';
            } else if (score === 4) {
                width = 80; color = '#8bc34a'; label = 'Good';
            } else if (score >= 5) {
                width = 100; color = '#28a745'; label = 'Strong';
            }

            strengthFill.style.width = width + '%';
            strengthFill.style.background = color;
            strengthLabel.textContent = 'Strength: ' + label;
        }

        // Add event listener for password strength
        document.getElementById('newPassword').addEventListener('input', updatePasswordStrength);

        // Handle password form submission
        document.getElementById('passwordForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const token = localStorage.getItem('session_token');
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (newPassword !== confirmPassword) {
                alert('New passwords do not match');
                return;
            }
            
            try {
                const response = await fetch('../../api/change_password.php', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        current_password: currentPassword,
                        new_password: newPassword,
                        confirm_password: confirmPassword
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || 'Failed to change password');
                }

                alert('Password changed successfully!');
                document.getElementById('passwordModal').classList.add('hidden');
                
            } catch (error) {
                console.error('Error changing password:', error);
                alert('Failed to change password: ' + error.message);
            }
        });

        // Change photo
        document.getElementById('changePhotoBtn').addEventListener('click', function() {
            document.getElementById('photoInput').click();
        });

        // Handle photo file selection
        document.getElementById('photoInput').addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, GIF, or WebP)');
                return;
            }

            // Validate file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                return;
            }

            const token = localStorage.getItem('session_token');
            
            // Show loading
            const btn = document.getElementById('changePhotoBtn');
            const originalText = btn.textContent;
            btn.textContent = 'Uploading...';
            btn.disabled = true;

            try {
                const formData = new FormData();
                formData.append('profile_photo', file);

                const response = await fetch('../../api/upload_profile_photo.php', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || 'Failed to upload photo');
                }

                // Update profile photo with cache busting
                console.log('Upload successful, new photo URL:', data.photo_url);
                const photoElement = document.getElementById('profilePhoto');
                photoElement.src = data.photo_url + '?t=' + Date.now();
                showToast('Profile photo updated successfully!');
                
            } catch (error) {
                console.error('Error uploading photo:', error);
                showToast('Failed to upload photo: ' + error.message, true);
            } finally {
                // Reset button
                btn.textContent = originalText;
                btn.disabled = false;
                // Clear file input
                e.target.value = '';
            }
        });

        // Add error handler for profile photo to fallback to default
        document.getElementById('profilePhoto').addEventListener('error', function() {
            console.log('Failed to load profile photo, using default');
            this.src = '../../assets/images/default.png';
        });

        // Load data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadAccountData();
            loadNotificationCount();
        });

        // Helper: Get time ago string
        function getTimeAgo(date) {
            const now = new Date();
            const diff = now - date;
            const seconds = Math.floor(diff / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);
            const weeks = Math.floor(days / 7);
            const months = Math.floor(days / 30);
            const years = Math.floor(days / 365);
            
            if (years > 0) return years === 1 ? '1 year ago' : `${years} years ago`;
            if (months > 0) return months === 1 ? '1 month ago' : `${months} months ago`;
            if (weeks > 0) return weeks === 1 ? '1 week ago' : `${weeks} weeks ago`;
            if (days > 0) return days === 1 ? '1 day ago' : `${days} days ago`;
            if (hours > 0) return hours === 1 ? '1 hour ago' : `${hours} hours ago`;
            if (minutes > 0) return minutes === 1 ? '1 minute ago' : `${minutes} minutes ago`;
            return 'Just now';
        }

        function showToast(message, isError = false) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            const toastIcon = toast.querySelector('i');
            
            toastMessage.textContent = message;
            
            if (isError) {
                toast.classList.add('error');
                toastIcon.className = 'fas fa-exclamation-circle';
            } else {
                toast.classList.remove('error');
                toastIcon.className = 'fas fa-check-circle';
            }
            
            toast.classList.add('show');
            
            setTimeout(() => {
                toast.classList.remove('show');
            }, 2500);
        }

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
</html>