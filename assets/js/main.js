// js/main.js
import { initializeNavigation } from './navigation.js';
import { initializeModals } from './modals.js';
import { initializeFormHandling } from './forms.js';
import { initializeScrollEffects, initializeAnimations } from './animations.js';
import { scrollToElement, debounce } from './utils.js';

document.addEventListener('DOMContentLoaded', function() {
    // Fetch and inject HTML content (fail-soft per section)
    const safeFetch = (path) => fetch(path)
        .then(r => {
            if (!r.ok) throw new Error(`Failed to load ${path}: ${r.status}`);
            return r.text();
        })
        .catch(err => {
            console.error(err);
            return '';
        });

    const heroPreloaded = !!document.querySelector('#hero-section section');
    const featuresPreloaded = !!document.querySelector('#features-section section');
    const aboutPreloaded = !!document.querySelector('#about-section section');
    const contactPreloaded = !!document.querySelector('#contact-section section');

    const fetchTasks = [];
    const sections = [
        { id: 'hero-section', path: '/pages/hero.html', preloaded: heroPreloaded },
        { id: 'features-section', path: '/pages/features.html', preloaded: featuresPreloaded },
        { id: 'about-section', path: '/pages/about.html', preloaded: aboutPreloaded },
        { id: 'contact-section', path: '/pages/contact.html', preloaded: contactPreloaded }
    ];

    sections.forEach(section => {
        if (!section.preloaded) {
            fetchTasks.push(
                safeFetch(section.path).then(html => {
                    const container = document.getElementById(section.id);
                    if (container && html) container.innerHTML = html;
                })
            );
        }
    });

    Promise.all(fetchTasks)
        .catch(err => console.error('Error loading one or more sections:', err))
        .finally(() => {
            // Initialize everything after static/dynamic content is present
            initializeNavigation();
            initializeModals();
            initializeFormHandling();
            initializeScrollEffects();
            initializeAnimations();

            // Add click handlers for "Learn More" button
            document.addEventListener('click', function(e) {
                if (e.target && e.target.id === 'learnMoreBtn') {
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
