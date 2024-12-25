// Handle code block copy functionality
export function initializeCodeBlocks() {
    const copyCode = async (button) => {
        const codeBlock = button.closest('.code-block');
        const code = codeBlock.querySelector('code').textContent;
        
        try {
            await navigator.clipboard.writeText(code);
            button.textContent = 'Copied!';
            button.classList.add('copied');
            
            setTimeout(() => {
                button.textContent = 'Copy';
                button.classList.remove('copied');
            }, 2000);
        } catch (err) {
            console.error('Failed to copy:', err);
            button.textContent = 'Error!';
            
            setTimeout(() => {
                button.textContent = 'Copy';
            }, 2000);
        }
    };

    // Add click handlers to all copy buttons
    document.querySelectorAll('.code-block .copy-button').forEach(button => {
        button.addEventListener('click', () => copyCode(button));
    });
}