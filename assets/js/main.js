/**
 * RAWG_v2 - Main JavaScript Module
 * 
 * Handles theme toggling, sidebar navigation, and interactive features
 */

// ============================================
// THEME MANAGEMENT
// ============================================
const ThemeManager = {
    STORAGE_KEY: 'rawg-theme',
    DARK: 'dark',
    LIGHT: 'light',

    init() {
        const savedTheme = localStorage.getItem(this.STORAGE_KEY) || this.DARK;
        this.apply(savedTheme);
        this.updateIcon(savedTheme);
    },

    toggle() {
        const current = document.documentElement.getAttribute('data-theme') || this.DARK;
        const newTheme = current === this.DARK ? this.LIGHT : this.DARK;
        this.apply(newTheme);
        this.save(newTheme);
        this.updateIcon(newTheme);
    },

    apply(theme) {
        document.documentElement.setAttribute('data-theme', theme);
    },

    save(theme) {
        localStorage.setItem(this.STORAGE_KEY, theme);
    },

    updateIcon(theme) {
        const icon = document.getElementById('theme-icon');
        if (icon) {
            icon.textContent = theme === this.DARK ? 'light_mode' : 'dark_mode';
        }
    }
};

// ============================================
// SIDEBAR MANAGEMENT
// ============================================
const SidebarManager = {
    sidebar: null,
    overlay: null,

    init() {
        this.sidebar = document.getElementById('sidebar');
        this.createOverlay();
    },

    createOverlay() {
        this.overlay = document.createElement('div');
        this.overlay.className = 'sidebar-overlay';
        this.overlay.style.cssText = `
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        `;
        this.overlay.addEventListener('click', () => this.close());
        document.body.appendChild(this.overlay);
    },

    toggle() {
        if (this.sidebar.classList.contains('open')) {
            this.close();
        } else {
            this.open();
        }
    },

    open() {
        this.sidebar.classList.add('open');
        this.overlay.style.opacity = '1';
        this.overlay.style.visibility = 'visible';
        document.body.style.overflow = 'hidden';
    },

    close() {
        this.sidebar.classList.remove('open');
        this.overlay.style.opacity = '0';
        this.overlay.style.visibility = 'hidden';
        document.body.style.overflow = '';
    }
};

// ============================================
// FAVORITES MANAGEMENT
// ============================================
const FavoritesManager = {
    STORAGE_KEY: 'rawg-favorites',

    getAll() {
        const stored = localStorage.getItem(this.STORAGE_KEY);
        return stored ? JSON.parse(stored) : [];
    },

    add(game) {
        const favorites = this.getAll();
        if (!favorites.find(f => f.id === game.id)) {
            favorites.push(game);
            this.save(favorites);
            this.showToast(`${game.name} adicionado aos favoritos!`);
            return true;
        }
        return false;
    },

    remove(gameId) {
        let favorites = this.getAll();
        const game = favorites.find(f => f.id === gameId);
        favorites = favorites.filter(f => f.id !== gameId);
        this.save(favorites);
        if (game) {
            this.showToast(`${game.name} removido dos favoritos!`);
        }
        return true;
    },

    toggle(game) {
        const favorites = this.getAll();
        if (favorites.find(f => f.id === game.id)) {
            this.remove(game.id);
            return false;
        } else {
            this.add(game);
            return true;
        }
    },

    isFavorite(gameId) {
        return this.getAll().some(f => f.id === gameId);
    },

    save(favorites) {
        localStorage.setItem(this.STORAGE_KEY, JSON.stringify(favorites));
    },

    showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = `
            <span class="material-icons">favorite</span>
            <span>${message}</span>
        `;
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 16px 24px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
            z-index: 9999;
            animation: slideInRight 0.3s ease, fadeOut 0.3s ease 2.7s forwards;
        `;

        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
};

// ============================================
// SEARCH HISTORY
// ============================================
const SearchHistory = {
    STORAGE_KEY: 'rawg-search-history',
    MAX_ITEMS: 10,

    getAll() {
        const stored = localStorage.getItem(this.STORAGE_KEY);
        return stored ? JSON.parse(stored) : [];
    },

    add(query) {
        if (!query.trim()) return;

        let history = this.getAll();
        // Remove if exists to avoid duplicates
        history = history.filter(h => h.toLowerCase() !== query.toLowerCase());
        // Add to beginning
        history.unshift(query);
        // Keep only last MAX_ITEMS
        history = history.slice(0, this.MAX_ITEMS);
        this.save(history);
    },

    clear() {
        localStorage.removeItem(this.STORAGE_KEY);
    },

    save(history) {
        localStorage.setItem(this.STORAGE_KEY, JSON.stringify(history));
    }
};

// ============================================
// LAZY LOAD IMAGES
// ============================================
const LazyLoader = {
    observer: null,

    init() {
        if ('IntersectionObserver' in window) {
            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            img.classList.remove('lazy');
                            this.observer.unobserve(img);
                        }
                    }
                });
            }, {
                rootMargin: '100px'
            });
        }
    },

    observe(selector = 'img.lazy') {
        const images = document.querySelectorAll(selector);
        images.forEach(img => {
            if (this.observer) {
                this.observer.observe(img);
            } else {
                // Fallback for old browsers
                img.src = img.dataset.src;
            }
        });
    }
};

// ============================================
// ANIMATION ON SCROLL
// ============================================
const ScrollAnimations = {
    observer: null,

    init() {
        if ('IntersectionObserver' in window) {
            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                        this.observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });
        }
    },

    observe(selector = '.animate-on-scroll') {
        const elements = document.querySelectorAll(selector);
        elements.forEach(el => {
            if (this.observer) {
                this.observer.observe(el);
            } else {
                el.classList.add('animate-in');
            }
        });
    }
};

// ============================================
// GLOBAL FUNCTIONS (for inline handlers)
// ============================================
function handleMenu() {
    SidebarManager.toggle();
}

function toggleTheme() {
    ThemeManager.toggle();
}

function toggleFavorite(gameId, gameName, gameImage) {
    return FavoritesManager.toggle({
        id: gameId,
        name: gameName,
        image: gameImage
    });
}

// ============================================
// INITIALIZATION
// ============================================
document.addEventListener('DOMContentLoaded', () => {
    ThemeManager.init();
    SidebarManager.init();
    LazyLoader.init();
    ScrollAnimations.init();

    // Observe lazy images and animated elements
    LazyLoader.observe();
    ScrollAnimations.observe();
});

// Add animation keyframes dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes fadeOut {
        to {
            opacity: 0;
            transform: translateY(20px);
        }
    }
    
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    
    .animate-on-scroll.animate-in {
        opacity: 1;
        transform: translateY(0);
    }
`;
document.head.appendChild(style);
