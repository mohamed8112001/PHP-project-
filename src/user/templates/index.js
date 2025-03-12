document.addEventListener('DOMContentLoaded', function () {
    // Tooltip for nav links
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        const tooltipText = link.getAttribute('data-tooltip');
        if (tooltipText) {
            link.addEventListener('mouseenter', () => {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.textContent = tooltipText;
                document.body.appendChild(tooltip);

                const rect = link.getBoundingClientRect();
                tooltip.style.top = `${rect.bottom + 5}px`;
                tooltip.style.left = `${rect.left + rect.width / 2}px`;
                tooltip.style.transform = 'translateX(-50%)';
            });

            link.addEventListener('mouseleave', () => {
                document.querySelector('.tooltip')?.remove();
            });
        }
    });
});

