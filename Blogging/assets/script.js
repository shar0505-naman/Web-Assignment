document.addEventListener('DOMContentLoaded', () => {
    // Initialize card animations
    const cards = document.querySelectorAll('.blog-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.4s ease-out, transform 0.4s ease-out';
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 * index);
    });

    // Active state for sort buttons
    document.querySelectorAll('.sort-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            document.querySelectorAll('.sort-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
});

// Toggle blog content with elegant animation
function toggleBlog(card) {
    const isExpanded = card.classList.contains('expanded');
    const allCards = document.querySelectorAll('.blog-card');
    
    // Close all other cards
    allCards.forEach(c => {
        if (c !== card) c.classList.remove('expanded');
    });
    
    // Toggle current card
    card.classList.toggle('expanded');
    
    // Smooth scroll to expanded card
    if (!isExpanded) {
        setTimeout(() => {
            card.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }, 100);
    }
}

// Close all cards when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.blog-card')) {
        document.querySelectorAll('.blog-card').forEach(card => {
            card.classList.remove('expanded');
        });
    }
});

// Loading animation for forms
function showLoading() {
    const loader = document.createElement('div');
    loader.className = 'loading-spinner';
    loader.innerHTML = `
        <div class="spinner"></div>
        <style>
            .loading-spinner {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255,255,255,0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }
            .spinner {
                width: 50px;
                height: 50px;
                border: 3px solid rgba(0,113,227,0.2);
                border-top-color: var(--accent-color);
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
        </style>
    `;
    document.body.appendChild(loader);
}