// js/modals.js
import { handleLoginForm, handleSignupModalForm } from './forms.js';

export function initializeModals() {
    const modal = document.getElementById('modal');
    const loginBtn = document.getElementById('loginBtn');
    const signupBtn = document.getElementById('signupBtn');
    const getStartedBtn = document.getElementById('getStartedBtn');
    const closeBtn = document.querySelector('.close');

    if (!modal) return; // nothing to do if modal container is missing

    // Login 
    const loginContent = `
        <h2>Welcome Back</h2>
        <form id="loginForm">
            <div class="form-group">
                <label for="loginEmail">Email</label>
                <input type="email" id="loginEmail" name="email" placeholder="name@rpi.edu" required>
            </div>
            <div class="form-group">
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-large">Login</button>
        </form>
        <p style="text-align: center; margin-top: 1rem;">
            Don't have an account? <a href="#" id="switchToSignup" style="color: #667eea;">Sign up here</a>
        </p>
    `;

    // Signup
    const signupContent = `
        <h2>Join RPISocial</h2>
        <form id="signupModalForm">
            <div class="form-group">
                <label for="signupName">Full Name</label>
                <input type="text" id="signupName" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="signupEmail">RPI Email</label>
                <input type="email" id="signupEmail" name="email" placeholder="name@rpi.edu" required>
            </div>
            <div class="form-group">
                <label for="signupPassword">Password</label>
                <input type="password" id="signupPassword" name="password" placeholder="Choose a secure password" required>
            </div>
            <div class="form-group">
                <label for="signupInterests">Interests (Optional)</label>
                <input type="text" id="signupInterests" name="interests" placeholder="e.g., Computer Science, Art, Research">
            </div>
            <button type="submit" class="btn btn-primary btn-large">Create Account</button>
        </form>
        <p style="text-align: center; margin-top: 1rem;">
            Already have an account? <a href="#" id="switchToLogin" style="color: #667eea;">Login here</a>
        </p>
    `;

    // Open modal functions
    function openModal(content) {
        document.getElementById('modalBody').innerHTML = content;
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    // Close modal function
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    // Event listeners (guarded)
    if (loginBtn) loginBtn.addEventListener('click', () => openModal(loginContent));
    if (signupBtn) signupBtn.addEventListener('click', () => openModal(signupContent));
    if (getStartedBtn) getStartedBtn.addEventListener('click', () => openModal(signupContent));

    // Close modal events
    closeBtn.addEventListener('click', closeModal);
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Switch between login and signup in modal
    document.addEventListener('click', function(e) {
        if (e.target.id === 'switchToSignup') {
            e.preventDefault();
            openModal(signupContent);
        } else if (e.target.id === 'switchToLogin') {
            e.preventDefault();
            openModal(loginContent);
        }
    });

    document.addEventListener('submit', function(e) {
        if (e.target.id === 'loginForm') {
            e.preventDefault();
            handleLoginForm(e);
        } else if (e.target.id === 'signupModalForm') {
            e.preventDefault();
            handleSignupModalForm(e);
        }
    });
}
