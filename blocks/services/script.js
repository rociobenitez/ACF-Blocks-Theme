/**
 * Services Showcase Carousel Functionality
 * Vanilla JavaScript implementation for smooth horizontal scrolling
 */

(function() {
    'use strict';

    /**
     * Services Showcase Carousel Class
     */
    class ServicesShowcaseCarousel {
        constructor(element) {
            this.showcase = element;
            this.grid = element.querySelector('.services__grid');
            this.prevBtn = element.querySelector('.services__control--prev');
            this.nextBtn = element.querySelector('.services__control--next');
            this.indicators = element.querySelectorAll('.services__indicator');
            this.cards = element.querySelectorAll('.services__card');
            
            // Configuration
            this.itemsPerRow = parseInt(element.dataset.itemsPerRow) || 3;
            this.autoplay = element.dataset.autoplay === 'true';
            this.autoplayDelay = parseInt(element.dataset.autoplayDelay) || 5000;
            
            // State
            this.currentSlide = 0;
            this.totalSlides = Math.ceil(this.cards.length / this.itemsPerRow);
            this.isAnimating = false;
            this.autoplayTimer = null;
            this.cardWidth = 0;
            
            // Only initialize if it's a carousel
            if (!element.classList.contains('services--carousel')) {
                return;
            }
            
            this.init();
        }

        init() {
            this.calculateDimensions();
            this.bindEvents();
            this.updateControls();
            
            if (this.autoplay) {
                this.startAutoplay();
            }
            
            // Update dimensions on window resize
            window.addEventListener('resize', this.debounce(() => {
                this.calculateDimensions();
                this.goToSlide(this.currentSlide, false);
            }, 150));
        }

        calculateDimensions() {
            if (this.cards.length === 0) return;
            
            // Get the first card's width including margin
            const firstCard = this.cards[0];
            const cardRect = firstCard.getBoundingClientRect();
            const cardStyle = window.getComputedStyle(firstCard);
            const marginRight = parseFloat(cardStyle.marginRight) || 0;
            
            this.cardWidth = cardRect.width + marginRight;
        }

        bindEvents() {
            // Navigation buttons
            if (this.prevBtn) {
                this.prevBtn.addEventListener('click', () => this.prevSlide());
            }
            
            if (this.nextBtn) {
                this.nextBtn.addEventListener('click', () => this.nextSlide());
            }
            
            // Indicators
            this.indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => this.goToSlide(index));
            });
            
            // Pause autoplay on hover
            if (this.autoplay) {
                this.showcase.addEventListener('mouseenter', () => this.pauseAutoplay());
                this.showcase.addEventListener('mouseleave', () => this.resumeAutoplay());
            }
            
            // Touch/swipe support
            this.addTouchSupport();
            
            // Keyboard navigation
            this.showcase.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    this.prevSlide();
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    this.nextSlide();
                }
            });
        }

        addTouchSupport() {
            let startX = 0;
            let currentX = 0;
            let isDragging = false;
            
            this.grid.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                isDragging = true;
                this.pauseAutoplay();
            });
            
            this.grid.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                currentX = e.touches[0].clientX;
            });
            
            this.grid.addEventListener('touchend', (e) => {
                if (!isDragging) return;
                isDragging = false;
                
                const diffX = startX - currentX;
                const threshold = 50;
                
                if (Math.abs(diffX) > threshold) {
                    if (diffX > 0) {
                        this.nextSlide();
                    } else {
                        this.prevSlide();
                    }
                }
                
                this.resumeAutoplay();
            });
        }

        prevSlide() {
            if (this.isAnimating) return;
            
            const newSlide = this.currentSlide > 0 ? this.currentSlide - 1 : this.totalSlides - 1;
            this.goToSlide(newSlide);
        }

        nextSlide() {
            if (this.isAnimating) return;
            
            const newSlide = this.currentSlide < this.totalSlides - 1 ? this.currentSlide + 1 : 0;
            this.goToSlide(newSlide);
        }

        goToSlide(slideIndex, animate = true) {
            if (this.isAnimating || slideIndex === this.currentSlide) return;
            
            this.isAnimating = true;
            this.currentSlide = slideIndex;
            
            // Calculate transform distance
            const transformX = -(slideIndex * this.cardWidth * this.itemsPerRow);
            
            // Apply transform
            if (animate) {
                this.grid.style.transition = 'transform 0.3s ease';
            } else {
                this.grid.style.transition = 'none';
            }
            
            this.grid.style.transform = `translateX(${transformX}px)`;
            
            // Update controls and indicators
            this.updateControls();
            this.updateIndicators();
            
            // Reset animation flag
            setTimeout(() => {
                this.isAnimating = false;
                this.grid.style.transition = '';
            }, animate ? 300 : 0);
            
            // Announce to screen readers
            this.announceSlideChange();
        }

        updateControls() {
            if (!this.prevBtn || !this.nextBtn) return;
            
            // Enable/disable buttons based on current position
            this.prevBtn.disabled = false;
            this.nextBtn.disabled = false;
            
            // Add visual states
            this.prevBtn.setAttribute('aria-label', 
                `Ir a la página anterior (${this.currentSlide + 1} de ${this.totalSlides})`);
            this.nextBtn.setAttribute('aria-label', 
                `Ir a la siguiente página (${this.currentSlide + 1} de ${this.totalSlides})`);
        }

        updateIndicators() {
            this.indicators.forEach((indicator, index) => {
                const isActive = index === this.currentSlide;
                indicator.classList.toggle('services__indicator--active', isActive);
                indicator.setAttribute('aria-selected', isActive.toString());
            });
        }

        announceSlideChange() {
            // Create or update live region for screen readers
            let liveRegion = this.showcase.querySelector('.sr-live-region');
            if (!liveRegion) {
                liveRegion = document.createElement('div');
                liveRegion.className = 'sr-live-region';
                liveRegion.setAttribute('aria-live', 'polite');
                liveRegion.setAttribute('aria-atomic', 'true');
                liveRegion.style.cssText = 'position: absolute; left: -10000px; width: 1px; height: 1px; overflow: hidden;';
                this.showcase.appendChild(liveRegion);
            }
            
            liveRegion.textContent = `Mostrando página ${this.currentSlide + 1} de ${this.totalSlides}`;
        }

        startAutoplay() {
            if (!this.autoplay) return;
            
            this.autoplayTimer = setInterval(() => {
                this.nextSlide();
            }, this.autoplayDelay);
        }

        pauseAutoplay() {
            if (this.autoplayTimer) {
                clearInterval(this.autoplayTimer);
                this.autoplayTimer = null;
            }
        }

        resumeAutoplay() {
            if (this.autoplay) {
                this.startAutoplay();
            }
        }

        // Utility function for debouncing
        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Public method to destroy the carousel
        destroy() {
            this.pauseAutoplay();
            // Remove event listeners and reset styles
            this.grid.style.transform = '';
            this.grid.style.transition = '';
        }
    }

    /**
     * Initialize all carousels on the page
     */
    function initServicesShowcaseCarousels() {
        const showcases = document.querySelectorAll('.services--carousel');
        
        showcases.forEach(showcase => {
            // Check if already initialized
            if (showcase.servicesCarousel) return;
            
            // Initialize carousel
            showcase.servicesCarousel = new ServicesShowcaseCarousel(showcase);
        });
    }

    /**
     * Initialize when DOM is ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initServicesShowcaseCarousels);
    } else {
        initServicesShowcaseCarousels();
    }

    /**
     * Re-initialize carousels when new blocks are added (for block editor)
     */
    if (typeof wp !== 'undefined' && wp.blocks) {
        wp.data.subscribe(() => {
            // Small delay to ensure DOM is updated
            setTimeout(initServicesShowcaseCarousels, 100);
        });
    }

    // Make the class globally available for manual initialization
    window.ServicesShowcaseCarousel = ServicesShowcaseCarousel;

})();