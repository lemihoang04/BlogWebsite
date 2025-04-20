/**
 * Index page JavaScript functionality
 * Enhances user experience with animations and interactions
 */

// Lazy load images for better performance
document.addEventListener('DOMContentLoaded', function() {
    // Lazy load images when they enter the viewport
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const image = entry.target;
                    image.src = image.dataset.src;
                    image.classList.add('loaded');
                    imageObserver.unobserve(image);
                }
            });
        });
        
        lazyImages.forEach(image => {
            imageObserver.observe(image);
        });
    } else {
        // Fallback for browsers that don't support IntersectionObserver
        lazyImages.forEach(image => {
            image.src = image.dataset.src;
        });
    }
    
    // Smooth scroll to top button
    const scrollToTopBtn = document.createElement('button');
    scrollToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    scrollToTopBtn.className = 'scroll-to-top';
    document.body.appendChild(scrollToTopBtn);
    
    scrollToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Show/hide scroll to top button based on scroll position
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
        }
    });
    
    // Add hover effects to blog cards
    const blogCards = document.querySelectorAll('.blog-grid');
    blogCards.forEach(card => {
        card.addEventListener('mouseover', () => {
            card.classList.add('hover');
        });
        card.addEventListener('mouseout', () => {
            card.classList.remove('hover');
        });
    });
    
    // Animate categories on hover
    const categoryBadges = document.querySelectorAll('.badge');
    categoryBadges.forEach(badge => {
        badge.addEventListener('mouseover', () => {
            badge.classList.add('animate__animated', 'animate__pulse');
        });
        badge.addEventListener('animationend', () => {
            badge.classList.remove('animate__animated', 'animate__pulse');
        });
    });
    
    // Auto-submit form when category changes
    const categorySelect = document.getElementById('categorySelect');
    if (categorySelect) {
        categorySelect.addEventListener('change', () => {
            document.getElementById('searchForm').submit();
        });
    }
    
    // Add debounce to search input
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let timeoutId;
        searchInput.addEventListener('input', () => {
            clearTimeout(timeoutId);
            if (searchInput.value.length >= 3 || searchInput.value.length === 0) {
                timeoutId = setTimeout(() => {
                    document.getElementById('searchForm').submit();
                }, 500);
            }
        });
    }
    
    // Check if the search or category parameters exist in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const search = urlParams.get('search');
    const category = urlParams.get('category');

    if (search || category) {
        // Scroll to the results section if search or category is present
        const resultsSection = document.getElementById('results');
        if (resultsSection) {
            resultsSection.scrollIntoView({ behavior: 'smooth' });
        }
    }
});

// Add CSS for scroll to top button
const style = document.createElement('style');
style.textContent = `
.scroll-to-top {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #4e73df;
    color: white;
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s;
    z-index: 1000;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.scroll-to-top.show {
    opacity: 1;
}

.scroll-to-top:hover {
    background: #3a57c9;
    transform: translateY(-3px);
}

.blog-grid.hover {
    transform: translateY(-10px);
}

/* Add animation to the Read More button */
.btn-outline-primary {
    position: relative;
    overflow: hidden;
    z-index: 1;
    transition: all 0.3s ease;
}

.btn-outline-primary:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 0;
    background: #4e73df;
    z-index: -1;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    color: white;
}

.btn-outline-primary:hover:after {
    height: 100%;
}

/* Improving page transitions */
.animate__fadeIn {
    animation-duration: 0.8s;
}

.loaded {
    animation: fadeImage 0.5s ease-in;
}

@keyframes fadeImage {
    from { opacity: 0; }
    to { opacity: 1; }
}
`;
document.head.appendChild(style);