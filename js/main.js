// js/main.js
import { initializeNavigation } from './navigation.js';
import { initializeModals } from './modals.js';
import { initializeFormHandling } from './forms.js';
import { initializeScrollEffects, initializeAnimations } from './animations.js';
import { scrollToElement, debounce } from './utils.js';

document.addEventListener('DOMContentLoaded', function() {
    // Fetch and inject HTML content
    Promise.all([
        fetch('pages/hero.html').then(response => response.text()),
        fetch('pages/features.html').then(response => response.text()),
        fetch('pages/about.html').then(response => response.text()),
        fetch('pages/contact.html').then(response => response.text())
    ]).then(([hero, features, about, contact]) => {
        document.getElementById('hero-section').innerHTML = hero;
        document.getElementById('features-section').innerHTML = features;
        document.getElementById('about-section').innerHTML = about;
        document.getElementById('contact-section').innerHTML = contact;

        // Initialize everything after content is loaded
        initializeNavigation();
        initializeModals();
        initializeFormHandling();
        initializeScrollEffects();
        initializeAnimations();

        // Add click handlers for "Learn More" button
        document.addEventListener('click', function(e) {
            if (e.target.id === 'learnMoreBtn') {
                scrollToElement('#features');
            }
        });
    });

    // Apply debouncing to scroll events
    const debouncedScrollHandler = debounce(function() {
        // Any expensive scroll operations can go here
    }, 10);

    window.addEventListener('scroll', debouncedScrollHandler);
});
