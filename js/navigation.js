import { initializeCodeBlocks } from './codeBlock.js';

document.addEventListener('DOMContentLoaded', function() {
    // Initialize code blocks
    initializeCodeBlocks();

    // Handle section collapsing
    const sectionTitles = document.querySelectorAll('.section-title');
    
    sectionTitles.forEach(title => {
        title.addEventListener('click', function() {
            // Toggle the collapsed class on the title
            this.classList.toggle('collapsed');
            
            // Find and toggle the next section-content element
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
            
            try {
                const response = await fetch(`load-content.php?file=${fileId}`);
                if (!response.ok) throw new Error('Network response was not ok');
                
                const content = await response.text();
                document.getElementById('main-content').innerHTML = content;
                
                // Re-initialize code blocks after content update
                initializeCodeBlocks();
                
                history.pushState(null, '', `#${fileId}`);
            } catch (error) {
                console.error('Error loading content:', error);
            }
        });
    });
});