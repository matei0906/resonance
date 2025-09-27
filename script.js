document.addEventListener('DOMContentLoaded', function() {
    initializeNavigation();
    initializeModals();
    initializeFormHandling();
    initializeScrollEffects();
    initializeAnimations();
});

// Navigation w/ menu
function initializeNavigation() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');

    // Toggle menu w/ click
    hamburger.addEventListener('click', function() {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    });

    // Close mobile menu
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        });
    });

    // Smooth scrolling
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const headerHeight = document.querySelector('.header').offsetHeight;
                const targetPosition = targetSection.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Login/Signup 
function initializeModals() {
    const modal = document.getElementById('modal');
    const loginBtn = document.getElementById('loginBtn');
    const signupBtn = document.getElementById('signupBtn');
    const getStartedBtn = document.getElementById('getStartedBtn');
    const closeBtn = document.querySelector('.close');

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

    // Event listeners
    loginBtn.addEventListener('click', () => openModal(loginContent));
    signupBtn.addEventListener('click', () => openModal(signupContent));
    getStartedBtn.addEventListener('click', () => openModal(signupContent));

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
            openModal(signupContent);
        } else if (e.target.id === 'switchToLogin') {
            openModal(loginContent);
        }
    });
}

// Form handling
function initializeFormHandling() {
    // Main signup form
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
        signupForm.addEventListener('submit', handleFormSubmission);
    }

    // Modal form handling
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
function handleLoginForm(e) {
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
function handleSignupModalForm(e) {
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

// Show success message
function showSuccessMessage(message) {
    showNotification(message, 'success');
}

// Show error message
function showErrorMessage(message) {
    showNotification(message, 'error');
}

// Notification system
function showNotification(message, type) {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Style the notification
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 3000;
        animation: slideInRight 0.3s ease;
        max-width: 300px;
        word-wrap: break-word;
    `;
    
    if (type === 'success') {
        notification.style.background = 'linear-gradient(135deg, #4CAF50 0%, #45a049 100%)';
    } else {
        notification.style.background = 'linear-gradient(135deg, #f44336 0%, #d32f2f 100%)';
    }
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Scroll effects for header and animations
function initializeScrollEffects() {
    const header = document.querySelector('.header');
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Add/remove scrolled class for header styling
        if (scrollTop > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        // Hide/show header on scroll
        if (scrollTop > lastScrollTop && scrollTop > 200) {
            header.style.transform = 'translateY(-100%)';
        } else {
            header.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
    });
}

// Initialize scroll-triggered animations
function initializeAnimations() {
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll('.feature-card, .stat, .contact-form');
    animateElements.forEach(el => {
        el.classList.add('animate-on-scroll');
        observer.observe(el);
    });
}

// Add CSS for animations (injected via JavaScript)
const animationStyles = `
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    
    .animate-in {
        opacity: 1;
        transform: translateY(0);
    }
    
    .header.scrolled {
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;

// Inject animation styles
const styleSheet = document.createElement('style');
styleSheet.textContent = animationStyles;
document.head.appendChild(styleSheet);

// Utility function for smooth scrolling to elements
function scrollToElement(elementId) {
    const element = document.querySelector(elementId);
    if (element) {
        const headerHeight = document.querySelector('.header').offsetHeight;
        const targetPosition = element.offsetTop - headerHeight;
        
        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    }
}

// Add click handlers for "Learn More" button
document.addEventListener('click', function(e) {
    if (e.target.id === 'learnMoreBtn') {
        scrollToElement('#features');
    }
});

// Performance optimization: Debounce scroll events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Apply debouncing to scroll events
const debouncedScrollHandler = debounce(function() {
    // Any expensive scroll operations can go here
}, 10);

window.addEventListener('scroll', debouncedScrollHandler);
