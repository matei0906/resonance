async function loadFragments() {
    const fragments = {
        '#hero-section': '/pages/hero.html',
        '#features-section': '/pages/features.html',
        '#about-section': '/pages/about.html',
        '#contact-section': '/pages/contact.html',
    };

    // Only fetch fragments if the target selector exists and is empty.
    const fetches = Object.entries(fragments).map(async ([selector, path]) => {
        const el = document.querySelector(selector);
        if (!el) return;
        if (el.children.length > 0 || el.innerHTML.trim().length > 0) {
            // already inlined or populated — skip network fetch to support file:// viewing
            console.debug(`Skipping fetch for ${path} because ${selector} already has content`);
            return;
        }
        try {
            const res = await fetch(path);
            if (!res.ok) throw new Error(`Failed to fetch ${path}: ${res.status}`);
            const html = await res.text();
            el.innerHTML = html;
        } catch (err) {
            console.warn('Could not load fragment', path, err);
        }
    });

    await Promise.all(fetches);
}
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

        // Initialize everything after content is loaded (guarded)
        try { initializeNavigation(); } catch (err) { console.warn('init navigation failed', err); }
        try { initializeModals(); } catch (err) { console.warn('init modals failed', err); }
        try { initializeFormHandling(); } catch (err) { console.warn('init forms failed', err); }
        try { initializeScrollEffects(); } catch (err) { console.warn('init scroll effects failed', err); }
        try { initializeAnimations(); } catch (err) { console.warn('init animations failed', err); }

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
