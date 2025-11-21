// js/animations.js
export function initializeScrollEffects() {
    // Header now stays fixed at top - no scroll effects
    const header = document.querySelector('.header');
    
    if (header) {
        // Ensure header is always visible
        header.style.transform = 'translateY(0)';
        header.style.transition = 'none';
    }
}

export function initializeAnimations() {
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
    
    // Intersection Observer for slide-in animations
    const slideObserverOptions = {
        threshold: 0.3,
        rootMargin: '-50px'
    };
    
    const slideObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Add animate class when scrolling into view
                entry.target.classList.add('animate');
            } else {
                // Remove animate class when scrolling away to reset animation
                entry.target.classList.remove('animate');
                // Force browser to recalculate styles for instant reset
                void entry.target.offsetWidth;
            }
        });
    }, slideObserverOptions);
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll('.feature-card, .stat, .contact-form');
    if (!animateElements || animateElements.length === 0) return;
    animateElements.forEach(el => {
        el.classList.add('animate-on-scroll');
        try {
            observer.observe(el);
        } catch (err) {
            console.warn('Animation observe error', err);
        }
    });
    
    // Observe slide-in elements
    const slideElements = document.querySelectorAll('.slide-in-left, .slide-in-right');
    slideElements.forEach(el => {
        try {
            slideObserver.observe(el);
        } catch (err) {
            console.warn('Slide animation observe error', err);
        }
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

// Inject animation styles if not already present
if (!document.getElementById('rpisocial-animation-styles')) {
    const styleSheet = document.createElement('style');
    styleSheet.id = 'rpisocial-animation-styles';
    styleSheet.textContent = animationStyles;
    document.head.appendChild(styleSheet);
}
