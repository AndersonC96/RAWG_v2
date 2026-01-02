/**
 * RAWG_v2 - Main JavaScript Module
 * 
 * Handles theme, sidebar, favorites, and search functionality.
 */

// ============================================
// THEME MANAGER
// ============================================
const ThemeManager = {
    STORAGE_KEY: 'rawg-theme',

    init() {
        const saved = localStorage.getItem(this.STORAGE_KEY);
        if (saved) {
            document.documentElement.setAttribute('data-bs-theme', saved);
        }
        this.updateIcon();
    },

    toggle() {
        const current = document.documentElement.getAttribute('data-bs-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-bs-theme', next);
        localStorage.setItem(this.STORAGE_KEY, next);
        this.updateIcon();
    },

    updateIcon() {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        document.querySelectorAll('#themeToggle i, #themeToggleMenu i').forEach(icon => {
            icon.className = isDark ? 'bi bi-sun-fill me-2' : 'bi bi-moon-stars-fill me-2';
        });
    }
};

// ============================================
// SIDEBAR MANAGER
// ============================================
const SidebarManager = {
    sidebar: null,
    overlay: null,

    init() {
        this.sidebar = document.getElementById('sidebar');
        this.overlay = document.getElementById('sidebarOverlay');

        if (!this.sidebar || !this.overlay) return;

        document.getElementById('sidebarToggle')?.addEventListener('click', () => this.toggle());
        document.getElementById('closeSidebar')?.addEventListener('click', () => this.close());
        this.overlay.addEventListener('click', () => this.close());
    },

    toggle() {
        this.sidebar.classList.toggle('open');
        this.overlay.classList.toggle('active');
        document.body.style.overflow = this.sidebar.classList.contains('open') ? 'hidden' : '';
    },

    close() {
        this.sidebar.classList.remove('open');
        this.overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
};

// ============================================
// FAVORITES MANAGER
// ============================================
const FavoritesManager = {
    STORAGE_KEY: 'rawg-favorites',

    getAll() {
        const data = localStorage.getItem(this.STORAGE_KEY);
        return data ? JSON.parse(data) : [];
    },

    isFavorite(gameId) {
        return this.getAll().some(g => g.id === parseInt(gameId));
    },

    add(game) {
        const favorites = this.getAll();
        if (!this.isFavorite(game.id)) {
            favorites.push(game);
            this.save(favorites);
            this.showToast(`${game.name} adicionado aos favoritos!`, 'success');
            return true;
        }
        return false;
    },

    remove(gameId) {
        let favorites = this.getAll();
        const game = favorites.find(g => g.id === parseInt(gameId));
        favorites = favorites.filter(g => g.id !== parseInt(gameId));
        this.save(favorites);
        if (game) {
            this.showToast(`${game.name} removido dos favoritos`, 'danger');
        }
        return true;
    },

    toggle(game) {
        if (this.isFavorite(game.id)) {
            this.remove(game.id);
            return false;
        } else {
            this.add(game);
            return true;
        }
    },

    save(favorites) {
        localStorage.setItem(this.STORAGE_KEY, JSON.stringify(favorites));
    },

    showToast(message, type = 'primary') {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center text-bg-${type} border-0`;
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-heart-fill me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        container.appendChild(toastEl);

        const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
        toast.show();

        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    }
};

// ============================================
// SEARCH HISTORY
// ============================================
const SearchHistory = {
    STORAGE_KEY: 'rawg-search-history',
    MAX_ITEMS: 10,

    getAll() {
        const data = localStorage.getItem(this.STORAGE_KEY);
        return data ? JSON.parse(data) : [];
    },

    add(query) {
        if (!query?.trim()) return;

        let history = this.getAll();
        history = history.filter(h => h.toLowerCase() !== query.toLowerCase());
        history.unshift(query.trim());
        history = history.slice(0, this.MAX_ITEMS);
        localStorage.setItem(this.STORAGE_KEY, JSON.stringify(history));
    },

    clear() {
        localStorage.removeItem(this.STORAGE_KEY);
    }
};

// ============================================
// FAVORITES BUTTONS
// ============================================
function initFavoriteButtons() {
    document.querySelectorAll('.btn-favorite, .btn-favorite-main').forEach(btn => {
        const gameId = parseInt(btn.dataset.gameId);

        // Set initial state
        if (FavoritesManager.isFavorite(gameId)) {
            btn.classList.add('is-favorite');
            const icon = btn.querySelector('i');
            if (icon) icon.className = 'bi bi-heart-fill';
            const span = btn.querySelector('span');
            if (span && btn.classList.contains('btn-favorite-main')) {
                span.textContent = 'Remover dos Favoritos';
            }
        }

        // Add click handler
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();

            const game = {
                id: gameId,
                name: btn.dataset.gameName,
                image: btn.dataset.gameImage
            };

            const isFav = FavoritesManager.toggle(game);
            btn.classList.toggle('is-favorite', isFav);

            const icon = btn.querySelector('i');
            if (icon) {
                icon.className = isFav ? 'bi bi-heart-fill' : 'bi bi-heart';
            }

            const span = btn.querySelector('span');
            if (span && btn.classList.contains('btn-favorite-main')) {
                span.textContent = isFav ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos';
            }
        });
    });
}

// ============================================
// INITIALIZATION
// ============================================
document.addEventListener('DOMContentLoaded', () => {
    ThemeManager.init();
    SidebarManager.init();
    initFavoriteButtons();

    // Theme toggle buttons
    document.getElementById('themeToggle')?.addEventListener('click', () => ThemeManager.toggle());
    document.getElementById('themeToggleMenu')?.addEventListener('click', (e) => {
        e.preventDefault();
        ThemeManager.toggle();
    });
});

// Expose managers globally
window.ThemeManager = ThemeManager;
window.FavoritesManager = FavoritesManager;
window.SearchHistory = SearchHistory;
