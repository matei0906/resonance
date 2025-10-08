// js/forms.js

export function handleLoginForm(event) {
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
    
    // Simulate login process
    console.log('Login attempt:', { email, password });
    
    // For now, just show success message
    alert('Login successful! Welcome to Resonance.');
    
    // Close modal
    const modal = document.getElementById('modal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    // In a real application, you would:
    // 1. Send credentials to your backend
    // 2. Handle authentication response
    // 3. Store user session/token
    // 4. Redirect to dashboard or update UI
}

export function handleSignupModalForm(event) {
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
    
    // Simulate signup process
    console.log('Signup attempt:', { name, email, password, interests });
    
    // For now, just show success message
    alert('Account created successfully! Welcome to Resonance.');
    
    // Close modal
    const modal = document.getElementById('modal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    // In a real application, you would:
    // 1. Send user data to your backend
    // 2. Handle account creation response
    // 3. Send verification email
    // 4. Redirect to onboarding or dashboard
}
