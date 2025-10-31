// js/forms.js

export async function handleLoginForm(event) {
    const formData = new FormData(event.target);
    const email = formData.get('email');
    const password = formData.get('password');
    
    // Basic validation
    if (!email || !password) {
        alert('Please fill in all fields');
        return;
    }
    
    // Check if it's an RPI email
    if (!email.includes('@rpi.edu')) {
        alert('Please use your RPI email address');
        return;
    }
    
    try {
        const response = await fetch('../api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email, password })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Login successful! Welcome to Resonance.');
            
            // Close modal
            const modal = document.getElementById('modal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
            
            // Optionally redirect or update UI
            // window.location.href = 'dashboard.html';
        } else {
            alert(data.error || 'Login failed. Please try again.');
        }
    } catch (error) {
        alert('Connection error. Please try again later.');
        console.error('Login error:', error);
    }
}

export async function handleSignupModalForm(event) {
    const formData = new FormData(event.target);
    const name = formData.get('name');
    const email = formData.get('email');
    const password = formData.get('password');
    const interests = formData.get('interests');
    
    // Basic validation
    if (!name || !email || !password) {
        alert('Please fill in all required fields');
        return;
    }
    
    // Check if it's an RPI email
    if (!email.includes('@rpi.edu')) {
        alert('Please use your RPI email address');
        return;
    }
    
    try {
        const response = await fetch('../api/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name, email, password, interests })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Account created successfully! Welcome to Resonance.');
            
            // Close modal
            const modal = document.getElementById('modal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
            
            // Optionally redirect
            // window.location.href = 'dashboard.html';
        } else {
            alert(data.error || 'Registration failed. Please try again.');
        }
    } catch (error) {
        alert('Connection error. Please try again later.');
        console.error('Registration error:', error);
    }
}

