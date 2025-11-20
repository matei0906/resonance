// Check if user is logged in
export function checkSession() {
    const token = localStorage.getItem('session_token');
    const expiry = localStorage.getItem('session_expiry');
    
    console.log('checkSession:', { token: !!token, expiry });
    
    if (!token || !expiry) {
        console.log('No token or expiry found');
        return false;
    }
    
    // Check if session has expired
    const expiryDate = new Date(parseInt(expiry));
    const now = new Date();
    console.log('Expiry check:', { expiryDate, now, isExpired: expiryDate < now });
    
    if (expiryDate < now) {
        console.log('Session expired, clearing');
        localStorage.removeItem('session_token');
        localStorage.removeItem('session_expiry');
        return false;
    }
    
    return true;
}

// Function to require login for protected pages
export function requireLogin() {
    if (!checkSession()) {
        window.location.href = '/auth/login.html';
    }
}

// Function to log out user
export function logout() {
    const token = localStorage.getItem('session_token');
    
    if (token) {
        // Call logout API
        fetch('../api/logout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .finally(() => {
            // Clear session data regardless of API response
            localStorage.removeItem('session_token');
            localStorage.removeItem('session_expiry');
            window.location.href = '/auth/login.html';
        });
    }
}

function handleLogin() {
     // After successful login validation
     sessionStorage.setItem('isLoggedIn', 'true');
     sessionStorage.setItem('authToken', 'your-token-here');
     window.location.href = 'dashboard/index.php';
   }