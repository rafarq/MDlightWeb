import { initializeCodeBlocks } from './codeBlock.js';

document.addEventListener('DOMContentLoaded', function() {
    // Initialize code blocks
    initializeCodeBlocks();

    // Handle section collapsing
    const sectionTitles = document.querySelectorAll('.section-title');
    
    sectionTitles.forEach(title => {
        title.addEventListener('click', function() {
            this.classList.toggle('collapsed');
            const content = this.nextElementSibling;
            if (content && content.classList.contains('section-content')) {
                content.classList.toggle('collapsed');
            }
        });
    });

    // Handle navigation links
    const navLinks = document.querySelectorAll('.nav-list a');
    
    navLinks.forEach(link => {
        link.addEventListener('click', async function(e) {
            e.preventDefault();
            const fileId = this.getAttribute('href').substring(1);
            await loadContent(fileId);
        });
    });

    // Load initial content based on URL hash
    async function loadInitialContent() {
        const hash = decodeURIComponent(window.location.hash.substring(1));
        if (hash) {
            await loadContent(hash);
            // Expand the corresponding sections in the navigation
            expandNavigationToFile(hash);
        }
    }

    // Function to load content
    async function loadContent(fileId) {
        try {
            const response = await fetch(`load-content.php?file=${encodeURIComponent(fileId)}`);
            if (!response.ok) throw new Error('Network response was not ok');
            
            const content = await response.text();
            document.getElementById('main-content').innerHTML = content;
            
            // Re-initialize code blocks after content update
            initializeCodeBlocks();
            
            // Update URL without triggering a reload
            history.pushState(null, '', `#${fileId}`);

            // Update document title if available
            const h1 = document.querySelector('#main-content h1');
            if (h1) {
                document.title = `${h1.textContent} - ${document.title.split(' - ')[1] || document.title}`;
            }
        } catch (error) {
            console.error('Error loading content:', error);
        }
    }

    // Function to expand navigation sections to show the current file
    function expandNavigationToFile(fileId) {
        const link = document.querySelector(`.nav-list a[href="#${fileId}"]`);
        if (link) {
            let parent = link.parentElement;
            while (parent) {
                const sectionContent = parent.querySelector('.section-content');
                const sectionTitle = parent.querySelector('.section-title');
                
                if (sectionContent && sectionContent.classList.contains('collapsed')) {
                    sectionContent.classList.remove('collapsed');
                }
                if (sectionTitle && sectionTitle.classList.contains('collapsed')) {
                    sectionTitle.classList.remove('collapsed');
                }
                
                parent = parent.parentElement.closest('.section');
            }
        }
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', async () => {
        const hash = decodeURIComponent(window.location.hash.substring(1));
        if (hash) {
            await loadContent(hash);
        }
    });

    // Load initial content when the page loads
    loadInitialContent();
});