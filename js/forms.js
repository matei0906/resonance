// js/forms.js
import { showSuccessMessage, showErrorMessage } from './notifications.js';

// Form handling
export function initializeFormHandling() {
    // Main signup form
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
        signupForm.addEventListener('submit', handleFormSubmission);
    }
}

// Handle main signup form
function handleFormSubmission(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    // Basic validation
    if (!validateForm(data)) {
        return;
    }
    
    // Simulate form submission
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.textContent = 'Creating Account...';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        showSuccessMessage('Account created successfully! Welcome to RPISocial!');
        e.target.reset();
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }, 2000);
}

// Handle login form
export function handleLoginForm(e) {
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    if (!data.email || !data.password) {
        showErrorMessage('Please fill in all fields');
        return;
    }
    
    // Simulate login
    showSuccessMessage('Login successful! Redirecting...');
    setTimeout(() => {
        document.getElementById('modal').style.display = 'none';
    }, 1500);
}

// Handle signup form in modal
export function handleSignupModalForm(e) {
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    if (!validateForm(data)) {
        return;
    }
    
    showSuccessMessage('Account created successfully! Welcome to RPISocial!');
    setTimeout(() => {
        document.getElementById('modal').style.display = 'none';
    }, 1500);
}

// Form validation function
function validateForm(data) {
    if (!data.name || !data.email || !data.password) {
        showErrorMessage('Please fill in all required fields');
        return false;
    }
    
    if (!data.email.includes('@rpi.edu')) {
        showErrorMessage('Please use your RPI email address');
        return false;
    }
    
    if (data.password.length < 6) {
        showErrorMessage('Password must be at least 6 characters long');
        return false;
    }
    
    return true;
}
