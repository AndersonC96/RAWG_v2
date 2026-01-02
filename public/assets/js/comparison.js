/**
 * Game Comparison Logic
 * Handles selection, persistence, and UI updates for game comparison.
 */

class GameComparison {
    constructor() {
        this.STORAGE_KEY = 'rawg_comparison_list';
        this.MAX_ITEMS = 3;
        this.items = this.loadItems();
        
        this.init();
    }

    init() {
        // Event delegation for compare buttons (dynamic content support)
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.btn-compare');
            if (btn) {
                e.preventDefault();
                e.stopPropagation(); // Prevent card click
                this.toggleItem(btn);
            }
        });

        this.renderFloatingBar();
        this.updateButtonStates();
    }

    loadItems() {
        const stored = localStorage.getItem(this.STORAGE_KEY);
        return stored ? JSON.parse(stored) : [];
    }

    saveItems() {
        localStorage.setItem(this.STORAGE_KEY, JSON.stringify(this.items));
        this.renderFloatingBar();
        this.updateButtonStates();
    }

    toggleItem(btn) {
        const id = btn.dataset.gameId;
        const name = btn.dataset.gameName;
        const image = btn.dataset.gameImage;
        
        const index = this.items.findIndex(item => item.id === id);

        if (index > -1) {
            // Remove
            this.items.splice(index, 1);
        } else {
            // Add (check limit)
            if (this.items.length >= this.MAX_ITEMS) {
                this.showToast('Você só pode comparar até 3 jogos por vez.', 'warning');
                return;
            }
            this.items.push({ id, name, image });
        }

        this.saveItems();
    }

    removeItem(id) {
        const index = this.items.findIndex(item => item.id === id);
        if (index > -1) {
            this.items.splice(index, 1);
            this.saveItems();
        }
    }

    updateButtonStates() {
        document.querySelectorAll('.btn-compare').forEach(btn => {
            const id = btn.dataset.gameId;
            const isActive = this.items.some(item => item.id === id);
            
            if (isActive) {
                btn.classList.add('active', 'btn-primary', 'border-primary');
                btn.classList.remove('btn-outline-light');
            } else {
                btn.classList.remove('active', 'btn-primary', 'border-primary');
                btn.classList.add('btn-outline-light');
            }
        });
    }

    renderFloatingBar() {
        let bar = document.getElementById('comparisonBar');
        
        if (this.items.length === 0) {
            if (bar) bar.classList.remove('show');
            return;
        }

        if (!bar) {
            bar = document.createElement('div');
            bar.id = 'comparisonBar';
            bar.className = 'comparison-bar';
            document.body.appendChild(bar);
        }

        const itemsHtml = this.items.map(item => `
            <div class="comparison-item" title="${item.name}">
                <img src="${item.image}" alt="${item.name}">
                <button type="button" class="btn-remove" onclick="window.gameComparison.removeItem('${item.id}')">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        `).join('');

        const compareUrl = `/RAWG_v2/compare?ids=${this.items.map(i => i.id).join(',')}`;
        
        bar.innerHTML = `
            <div class="container d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white fw-bold d-none d-md-block">Comparar:</span>
                    <div class="comparison-items d-flex gap-2">
                        ${itemsHtml}
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-light btn-sm" onclick="window.gameComparison.clear()">Limpar</button>
                    <a href="${compareUrl}" class="btn btn-primary btn-sm px-4 fw-bold">
                        Comparar Agora <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        `;

        setTimeout(() => bar.classList.add('show'), 10);
    }

    clear() {
        this.items = [];
        this.saveItems();
    }

    showToast(message, type = 'info') {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;

        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center text-bg-${type} border-0`;
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');
        
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        toastContainer.appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
        
        toastEl.addEventListener('hidden.bs.toast', () => {
            toastEl.remove();
        });
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    window.gameComparison = new GameComparison();
});
