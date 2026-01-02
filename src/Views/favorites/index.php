<?php
/**
 * Favorites Page View
 */
$basePath = '/RAWG_v2';
?>

<div class="container-fluid">
    <!-- Header -->
    <div class="favorites-header text-center py-5">
        <h1 class="display-5 fw-bold mb-3">
            <i class="bi bi-heart-fill me-3 text-danger"></i>
            Meus Favoritos
        </h1>
        <p class="lead text-muted mb-4">Seus jogos salvos aparecem aqui</p>
        
        <button class="btn btn-outline-danger" id="clearFavorites" style="display: none;">
            <i class="bi bi-trash me-2"></i>
            Limpar todos
        </button>
    </div>
    
    <!-- Favorites Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4" id="favoritesGrid">
        <!-- Populated by JavaScript -->
    </div>
    
    <!-- Empty State -->
    <div class="empty-state text-center py-5" id="emptyState" style="display: none;">
        <i class="bi bi-heart display-1 text-muted mb-3"></i>
        <h3>Nenhum favorito ainda</h3>
        <p class="text-muted mb-4">Explore jogos e adicione aos seus favoritos</p>
        <a href="<?= $basePath ?>/" class="btn btn-primary btn-lg">
            <i class="bi bi-controller me-2"></i>
            Explorar Jogos
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', renderFavorites);

document.getElementById('clearFavorites').addEventListener('click', () => {
    if (confirm('Remover todos os favoritos?')) {
        localStorage.removeItem('rawg-favorites');
        renderFavorites();
    }
});

function renderFavorites() {
    const favorites = window.FavoritesManager ? FavoritesManager.getAll() : [];
    const grid = document.getElementById('favoritesGrid');
    const emptyState = document.getElementById('emptyState');
    const clearBtn = document.getElementById('clearFavorites');
    
    if (favorites.length === 0) {
        grid.style.display = 'none';
        emptyState.style.display = 'block';
        clearBtn.style.display = 'none';
        return;
    }
    
    grid.style.display = 'flex';
    emptyState.style.display = 'none';
    clearBtn.style.display = 'inline-flex';
    
    grid.innerHTML = favorites.map(game => `
        <div class="col" data-game-id="${game.id}">
            <div class="card h-100">
                <img src="${game.image || '/RAWG_v2/public/assets/images/placeholder.jpg'}" 
                     class="card-img-top" 
                     alt="${game.name}"
                     style="height: 180px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">${game.name}</h5>
                    <div class="d-flex gap-2">
                        <a href="/RAWG_v2/game/${game.id}" class="btn btn-primary btn-sm flex-grow-1">
                            <i class="bi bi-eye me-1"></i> Ver
                        </a>
                        <button class="btn btn-outline-danger btn-sm" onclick="removeFavorite(${game.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function removeFavorite(gameId) {
    if (window.FavoritesManager) {
        FavoritesManager.remove(gameId);
    }
    
    const card = document.querySelector(`[data-game-id="${gameId}"]`);
    if (card) {
        card.style.transform = 'scale(0.8)';
        card.style.opacity = '0';
        setTimeout(renderFavorites, 300);
    } else {
        renderFavorites();
    }
}
</script>
