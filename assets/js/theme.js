// theme.js - Standalone theme switcher
(function() {
    'use strict';

    function updateThemeIcon(theme) {
        const themeIcons = document.querySelectorAll('.theme-icon');
        themeIcons.forEach(icon => {
            if (theme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        });
    }

    function updateLogo(theme) {
        const logoImages = document.querySelectorAll('.logo-image');
        logoImages.forEach(logo => {
            const currentSrc = logo.getAttribute('src');
            if (theme === 'dark') {
                // Switch to resonance2.png
                logo.setAttribute('src', currentSrc.replace('resonance.png', 'resonance2.png'));
            } else {
                // Switch to resonance.png
                logo.setAttribute('src', currentSrc.replace('resonance2.png', 'resonance.png'));
            }
        });
    }

    function initializeTheme() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        
        // Wait for DOM to be ready before updating icon and logo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                updateThemeIcon(savedTheme);
                updateLogo(savedTheme);
            });
        } else {
            updateThemeIcon(savedTheme);
            updateLogo(savedTheme);
        }
    }

    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon(newTheme);
        updateLogo(newTheme);
    }

    // Initialize theme immediately
    initializeTheme();

    // Add event listener when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                if (e.target.closest('.theme-toggle')) {
                    e.preventDefault();
                    toggleTheme();
                }
            });
        });
    } else {
        document.addEventListener('click', function(e) {
            if (e.target.closest('.theme-toggle')) {
                e.preventDefault();
                toggleTheme();
            }
        });
    }
})();

