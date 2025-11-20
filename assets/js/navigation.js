// js/navigation.js
export function initializeNavigation() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');
    const header = document.querySelector('.header');

    // Guard: if important elements are missing, bail out gracefully
    if (!navMenu || !navLinks) return;

    // Toggle menu w/ click
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            try {
                hamburger.classList.toggle('active');
                navMenu.classList.toggle('active');
            } catch (err) {
                // swallow errors to avoid breaking other scripts
                console.warn('Navigation toggle error', err);
            }
        });
    }

    // Close mobile menu
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            try {
                if (hamburger) {
                    hamburger.classList.remove('active');
                }
                navMenu.classList.remove('active');
            } catch (err) {
                console.warn('Navigation close error', err);
            }
        });
    });

    // Smooth scrolling
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            try {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetSection = document.querySelector(targetId);
                
                if (targetSection) {
                    const headerEl = document.querySelector('.header');
                    const headerHeight = headerEl ? headerEl.offsetHeight : 0;
                    const targetPosition = targetSection.offsetTop - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            } catch (err) {
                console.warn('Navigation scroll error', err);
            }
        });
    });
}
