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

        :root:not([data-theme="dark"]) .settings-card {
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
        
        .settings-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px var(--shadow-sm);
            margin-top: 2rem;
        }
        
        .settings-title {
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }
        
        .settings-subtitle {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }
        
        /* Interests slide - matching home page styles */
        .interests { display: grid; gap: 1.25rem; }
        .orbit-area { 
            position: relative; 
            height: 380px; 
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%); 
            border: 1px solid var(--border-color); 
            border-radius: 16px; 
            overflow: hidden;
            transition: background 0.3s ease;
        }
        .avatar { 
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 110px; 
            height: 110px; 
            border-radius: 50%; 
            background: var(--bg-secondary); 
            border: 3px solid #ffd2ae; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: #9b2c1a; 
            box-shadow: 0 10px 25px var(--shadow-sm);
            z-index: 5;
            transition: background-color 0.3s ease;
        }
        .avatar i { font-size: 42px; }
        .orbit-container { position: absolute; inset: 0; pointer-events: none; z-index: 10; }
        .orbit-chip { 
            position: absolute; 
            left: 50%; 
            top: 50%; 
            transform-origin: 0 0; 
            white-space: nowrap; 
            background: var(--card-bg); 
            border: 1px solid var(--border-color); 
            border-radius: 8px; 
            padding: 0.75rem 1rem; 
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 0.9rem; 
            font-weight: 600;
            color: var(--text-primary);
            box-shadow: 0 5px 20px var(--shadow-sm); 
            pointer-events: auto; 
            cursor: pointer; 
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
            z-index: 10;
        }
        .orbit-chip:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            z-index: 20;
        }
        @keyframes orbit {
            from { transform: rotate(0deg) translateX(var(--radius)) rotate(0deg); }
            to { transform: rotate(360deg) translateX(var(--radius)) rotate(-360deg); }
        }
        .orbiting { animation: orbit var(--speed, 10s) linear infinite; }
        
        .bank { display: flex; flex-direction: column; gap: 1rem; }
        .bank-section { 
            background: var(--bg-tertiary); 
            border: 2px solid var(--border-color-secondary); 
            border-radius: 16px; 
            padding: 1.5rem; 
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }
        .bank-section:hover {
            border-color: #9b2c1a;
        }
        .bank-title { 
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-weight: 700; 
            color: #9b2c1a; 
            font-size: 1.1rem; 
            margin-bottom: 1rem; 
        }
        .chips { display: flex; flex-wrap: wrap; gap: 0.75rem; }
        .bank-chip { 
            background: var(--bg-secondary); 
            border: 2px solid var(--border-color-secondary); 
            border-radius: 8px; 
            padding: 0.75rem 1rem; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 0.9rem; 
            font-weight: 600;
            color: var(--text-primary);
        }
        .bank-chip:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 25px rgba(0,0,0,0.15); 
            border-color: #9b2c1a;
        }
        .bank-chip.selected { 
            background: linear-gradient(135deg, #9b2c1a 0%, #ff8a3d 100%); 
            border-color: #9b2c1a; 
            color: white; 
        }
        .flying-chip { 
            position: fixed; 
            z-index: 3000; 
            background: var(--card-bg); 
            border: 2px solid var(--border-color-secondary); 
            border-radius: 8px; 
            padding: 0.75rem 1rem; 
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-primary);
            white-space: nowrap;
            box-shadow: 0 10px 30px var(--shadow-md); 
            pointer-events: none;
        }
        .bank-other { 
            display: flex; 
            align-items: center; 
            gap: 0.75rem; 
            margin-top: 1rem; 
        }
        .bank-other input { 
            flex: 1;
            height: auto;
            padding: 0.75rem; 
            border: 2px solid var(--border-color-secondary); 
            background: var(--bg-secondary);
            color: var(--text-primary);
            border-radius: 8px; 
            font-family: 'Work Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 1rem;
            font-weight: 600;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }
        .bank-other input:focus {
            outline: none;
            border-color: #9b2c1a;
        }
        .bank-other button { 
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }
        
        .settings-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }
        
        .loading {
            text-align: center;
            padding: 2rem;
            color: var(--text-secondary);
        }
        
        .hidden {
            display: none;
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
        </header>

        <main class="main-content">
            <div class="container">
                <h1>Settings</h1>
                <div class="settings-card">
                    <h2 class="settings-title">Edit Your Preferences</h2>
                    <p class="settings-subtitle">Update your music interests, instruments, and availability to get better matches.</p>
                    
                    <div id="loadingMessage" class="loading">
                        Loading your preferences...
                    </div>
                    
                    <div id="preferencesContent" class="hidden">
                        <div class="interests">
                            <div class="orbit-area">
                                <div class="avatar" id="orbitCenter" aria-label="Interests center"><i class="fas fa-user"></i></div>
                                <div class="orbit-container" id="orbitContainer"></div>
                            </div>
                            <div class="bank">
                                <div class="bank-section" data-cat="genres">
                                    <div class="bank-title">Genres</div>
                                    <div class="chips" id="bank-genres">
                                        <button type="button" class="bank-chip" data-cat="genres">Pop</button>
                                        <button type="button" class="bank-chip" data-cat="genres">Rock</button>
                                        <button type="button" class="bank-chip" data-cat="genres">Jazz</button>
                                        <button type="button" class="bank-chip" data-cat="genres">Classical</button>
                                        <button type="button" class="bank-chip" data-cat="genres">Hip-Hop</button>
                                        <button type="button" class="bank-chip" data-cat="genres">EDM</button>
                                        <button type="button" class="bank-chip" data-cat="genres">R&B</button>
                                        <button type="button" class="bank-chip" data-cat="genres">Indie</button>
                                        <button type="button" class="bank-chip" data-cat="genres">Metal</button>
                                    </div>
                                    <div class="bank-other">
                                        <input type="text" id="other-genres" placeholder="Other genre">
                                        <button type="button" class="btn btn-outline" data-add="genres">Add</button>
                                    </div>
                                </div>
                                <div class="bank-section" data-cat="instruments">
                                    <div class="bank-title">Instruments You Play</div>
                                    <div class="chips" id="bank-instruments">
                                        <button type="button" class="bank-chip" data-cat="instruments">Guitar</button>
                                        <button type="button" class="bank-chip" data-cat="instruments">Bass</button>
                                        <button type="button" class="bank-chip" data-cat="instruments">Piano</button>
                                        <button type="button" class="bank-chip" data-cat="instruments">Drums</button>
                                        <button type="button" class="bank-chip" data-cat="instruments">Vocals</button>
                                        <button type="button" class="bank-chip" data-cat="instruments">Violin</button>
                                        <button type="button" class="bank-chip" data-cat="instruments">Saxophone</button>
                                        <button type="button" class="bank-chip" data-cat="instruments">Trumpet</button>
                                        <button type="button" class="bank-chip" data-cat="instruments">Production</button>
                                    </div>
                                    <div class="bank-other">
                                        <input type="text" id="other-instruments" placeholder="Other instrument">
                                        <button type="button" class="btn btn-outline" data-add="instruments">Add</button>
                                    </div>
                                </div>
                                <div class="bank-section" data-cat="instrument_interests">
                                    <div class="bank-title">Instrument Interest</div>
                                    <div class="chips" id="bank-instrument_interests">
                                        <button type="button" class="bank-chip" data-cat="instrument_interests">Guitar</button>
                                        <button type="button" class="bank-chip" data-cat="instrument_interests">Bass</button>
                                        <button type="button" class="bank-chip" data-cat="instrument_interests">Piano</button>
                                        <button type="button" class="bank-chip" data-cat="instrument_interests">Drums</button>
                                        <button type="button" class="bank-chip" data-cat="instrument_interests">Vocals</button>
                                        <button type="button" class="bank-chip" data-cat="instrument_interests">Violin</button>
                                        <button type="button" class="bank-chip" data-cat="instrument_interests">Saxophone</button>
                                        <button type="button" class="bank-chip" data-cat="instrument_interests">Trumpet</button>
                                        <button type="button" class="bank-chip" data-cat="instrument_interests">Production</button>
                                    </div>
                                    <div class="bank-other">
                                        <input type="text" id="other-instrument_interests" placeholder="Other instrument">
                                        <button type="button" class="btn btn-outline" data-add="instrument_interests">Add</button>
                                    </div>
                                </div>
                                <div class="bank-section" data-cat="availability">
                                    <div class="bank-title">Availability</div>
                                    <div class="chips" id="bank-availability">
                                        <button type="button" class="bank-chip" data-cat="availability">Mornings</button>
                                        <button type="button" class="bank-chip" data-cat="availability">Afternoons</button>
                                        <button type="button" class="bank-chip" data-cat="availability">Evenings</button>
                                        <button type="button" class="bank-chip" data-cat="availability">Weekdays</button>
                                        <button type="button" class="bank-chip" data-cat="availability">Weekends</button>
                                    </div>
                                    <div class="bank-other">
                                        <input type="text" id="other-availability" placeholder="Other availability">
                                        <button type="button" class="btn btn-outline" data-add="availability">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="settings-actions">
                            <button class="btn btn-outline" id="cancelBtn">Cancel</button>
                            <button class="btn btn-primary" id="saveBtn">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Preferences saved successfully!</span>
    </div>

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

        // Load user preferences
        async function loadPreferences() {
            const token = localStorage.getItem('session_token');
            if (!token) {
                window.location.href = '../../auth/login.html';
                return;
            }

            try {
                const response = await fetch('../../api/get_preferences.php', {
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
                    throw new Error('Failed to load preferences');
                }

                const preferences = await response.json();
                
                // Initialize orbit chips with user's existing preferences
                initializePreferences(preferences);
                
                // Show content
                document.getElementById('loadingMessage').classList.add('hidden');
                document.getElementById('preferencesContent').classList.remove('hidden');
                
            } catch (error) {
                console.error('Error loading preferences:', error);
                document.getElementById('loadingMessage').textContent = 'Failed to load preferences. Please refresh the page.';
            }
        }

        // Toast notification function
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
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Save preferences
        document.getElementById('saveBtn').addEventListener('click', async function() {
            const token = localStorage.getItem('session_token');
            
            // Collect selected preferences
            const preferences = orbitChips.map(chip => ({
                category: chip.category,
                label: chip.label
            }));
            
            try {
                const response = await fetch('../../api/update_preferences.php', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ preferences })
                });

                if (!response.ok) {
                    throw new Error('Failed to save preferences');
                }

                showToast('Preferences saved successfully!');
                
            } catch (error) {
                console.error('Error saving preferences:', error);
                showToast('Failed to save preferences. Please try again.', true);
            }
        });

        // Cancel changes
        document.getElementById('cancelBtn').addEventListener('click', function() {
            if (confirm('Are you sure you want to cancel? Your changes will be lost.')) {
                loadPreferences(); // Reload original preferences
            }
        });

        // Load preferences on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadPreferences();
            loadNotificationCount();
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
    </script>
    
    <script>
        // Orbiting chips logic (adapted from quiz)
        const orbitContainer = document.getElementById('orbitContainer');
        const center = document.getElementById('orbitCenter');
        const bank = document.querySelector('.bank');

        const orbitChips = [];
        const orbitRings = [100, 130, 160];

        function redistributeChips() {
            orbitChips.forEach((item, index) => {
                const ring = orbitRings[Math.floor(index / 8)] || orbitRings[orbitRings.length - 1];
                const chipsInRing = Math.min(8, orbitChips.length - Math.floor(index / 8) * 8);
                const angleStep = 360 / chipsInRing;
                const angle = (index % 8) * angleStep;
                
                item.ring = ring;
                item.angle = angle;
                item.chip.style.setProperty('--radius', ring + 'px');
                item.chip.style.setProperty('--speed', (10 + (index % 8)) + 's');
                item.chip.style.transform = `rotate(${angle}deg) translateX(${ring}px) rotate(${-angle}deg)`;
            });
        }

        function placeOrbitChip(label, category) {
            const chip = document.createElement('div');
            chip.className = 'orbit-chip orbiting';
            chip.textContent = label;
            chip.dataset.cat = category || '';
            orbitContainer.appendChild(chip);
            orbitChips.push({ chip, ring: 0, angle: 0, label, category });
            redistributeChips();
        }

        function animateChipToOrbit(buttonEl) {
            if (buttonEl.classList.contains('selected')) return;
            buttonEl.classList.add('selected');

            const rect = buttonEl.getBoundingClientRect();
            const fly = document.createElement('div');
            fly.className = 'flying-chip';
            fly.textContent = buttonEl.textContent;
            fly.style.left = rect.left + 'px';
            fly.style.top = rect.top + 'px';
            document.body.appendChild(fly);

            const centerRect = center.getBoundingClientRect();
            const targetX = centerRect.left + centerRect.width / 2;
            const targetY = centerRect.top + centerRect.height / 2;

            const duration = 450;
            const start = performance.now();
            const startX = rect.left;
            const startY = rect.top;

            function step(now) {
                const t = Math.min(1, (now - start) / duration);
                const e = 1 - Math.pow(1 - t, 3);
                const x = startX + (targetX - startX) * e;
                const y = startY + (targetY - startY) * e;
                fly.style.left = x + 'px';
                fly.style.top = y + 'px';
                if (t < 1) requestAnimationFrame(step);
                else {
                    fly.remove();
                    placeOrbitChip(buttonEl.textContent, buttonEl.dataset.cat || '');
                }
            }
            requestAnimationFrame(step);
        }

        function animateChipFromOrbit(orbitChipEl, targetBankChip) {
            const orbitRect = orbitChipEl.getBoundingClientRect();
            
            const fly = document.createElement('div');
            fly.className = 'flying-chip';
            fly.textContent = orbitChipEl.textContent;
            fly.style.left = orbitRect.left + 'px';
            fly.style.top = orbitRect.top + 'px';
            document.body.appendChild(fly);

            const targetRect = targetBankChip.getBoundingClientRect();
            const targetX = targetRect.left;
            const targetY = targetRect.top;

            const duration = 450;
            const start = performance.now();
            const startX = orbitRect.left;
            const startY = orbitRect.top;

            const label = orbitChipEl.textContent;
            const idx = orbitChips.findIndex(c => c.label === label);
            if (idx !== -1) {
                orbitChips.splice(idx, 1);
                redistributeChips();
            }
            orbitChipEl.remove();

            function step(now) {
                const t = Math.min(1, (now - start) / duration);
                const e = 1 - Math.pow(1 - t, 3);
                const x = startX + (targetX - startX) * e;
                const y = startY + (targetY - startY) * e;
                fly.style.left = x + 'px';
                fly.style.top = y + 'px';
                if (t < 1) requestAnimationFrame(step);
                else {
                    fly.remove();
                    targetBankChip.classList.remove('selected');
                }
            }
            requestAnimationFrame(step);
        }

        function initializePreferences(preferences) {
            // Clear any existing orbit chips
            orbitContainer.innerHTML = '';
            orbitChips.length = 0;
            
            // Reset all bank chips
            document.querySelectorAll('.bank-chip').forEach(chip => {
                chip.classList.remove('selected');
            });
            
            // Add user's existing preferences to orbit
            Object.entries(preferences).forEach(([category, items]) => {
                items.forEach(item => {
                    // Check if it's a predefined chip
                    const bankChip = Array.from(document.querySelectorAll(`.bank-chip[data-cat="${category}"]`))
                        .find(chip => chip.textContent === item);
                    
                    if (bankChip) {
                        // It's a predefined chip, select it and add to orbit
                        bankChip.classList.add('selected');
                        placeOrbitChip(item, category);
                    } else {
                        // It's a custom chip, add it to the bank and select it
                        const container = document.getElementById('bank-' + category);
                        const newChip = document.createElement('button');
                        newChip.type = 'button';
                        newChip.className = 'bank-chip selected';
                        newChip.dataset.cat = category;
                        newChip.textContent = item;
                        container.appendChild(newChip);
                        placeOrbitChip(item, category);
                    }
                });
            });
        }

        // Bank chip click handlers
        if (bank) {
            bank.addEventListener('click', function(e) {
                const chip = e.target.closest('.bank-chip');
                if (!chip) return;
                if (!chip.classList.contains('selected')) {
                    animateChipToOrbit(chip);
                } else {
                    const idx = orbitChips.findIndex(c => c.label === chip.textContent);
                    if (idx !== -1) {
                        animateChipFromOrbit(orbitChips[idx].chip, chip);
                    }
                }
            });
        }

        // Orbit chip click handlers
        orbitContainer.addEventListener('click', function(e) {
            const oc = e.target.closest('.orbit-chip');
            if (!oc) return;
            const label = oc.textContent;
            const bankChip = Array.from(document.querySelectorAll('.bank-chip.selected')).find(b => b.textContent === label);
            if (bankChip) {
                animateChipFromOrbit(oc, bankChip);
            }
        });

        // Add custom chip functionality
        function addCustomChip(category) {
            const input = document.getElementById('other-' + category);
            const value = (input.value || '').trim();
            if (!value) return;

            const container = document.getElementById('bank-' + category);
            const newChip = document.createElement('button');
            newChip.type = 'button';
            newChip.className = 'bank-chip';
            newChip.dataset.cat = category;
            newChip.textContent = value;
            container.appendChild(newChip);
            input.value = '';
            animateChipToOrbit(newChip);
        }

        document.querySelectorAll('[data-add]').forEach(btn => {
            btn.addEventListener('click', function() {
                const cat = this.getAttribute('data-add');
                addCustomChip(cat);
            });
        });

        document.querySelectorAll('[id^="other-"]').forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const category = this.id.replace('other-', '');
                    addCustomChip(category);
                }
            });
        });
    </script>
</html>