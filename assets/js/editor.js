// Import editor styles
import '../css/editor.css';

// Import block-specific editor styles
import '../../blocks/hero/editor.css';
import '../../blocks/alternated-content/editor.css';
import '../../blocks/services-showcase/editor.css';

console.log('Editor script loaded');

// Add any editor-specific JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Editor enhancements
    const blocks = document.querySelectorAll('[data-type^="acf/"]');
    blocks.forEach(block => {
        block.classList.add('acf-block-preview');
    });
});