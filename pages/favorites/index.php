<?php
/**
 * RAWG_v2 - Favorites Page
 * 
 * Display user's favorite games stored in localStorage
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);
require_once '../../config/config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../assets/redoc-logo.png">
    <title>Meus Favoritos - RAWG API</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="./style.css">
    <?php include('../../components/importsLink.php'); ?>
</head>
<body>
    <div class="container-wrapper">
        <?php include_once('../../components/sidebar.php'); ?>
        
        <main class="main-content">
            <?php include_once('../../components/header.php'); ?>
            
            <article class="container">
                <!-- Favorites Header -->
                <div class="favorites-header">
                    <h1>
                        <span class="material-icons">favorite</span>
                        Meus Favoritos
                    </h1>
                    <p>Seus jogos salvos aparecem aqui</p>
                    
                    <button class="btn-clear-all glass" id="clear-favorites" style="display: none;">
                        <span class="material-icons">delete_sweep</span>
                        Limpar todos
                    </button>
                </div>
                
                <!-- Favorites Grid -->
                <div class="grid" id="favorites-grid">
                    <!-- Populated by JavaScript -->
                </div>
                
                <!-- Empty State -->
                <div class="empty-state glass" id="empty-state" style="display: none;">
                    <span class="material-icons">favorite_border</span>
                    <h3>Nenhum favorito ainda</h3>
                    <p>Explore jogos e adicione aos seus favoritos</p>
                    <a href="../../index.php" class="btn-primary">
                        <span class="material-icons">explore</span>
                        Explorar jogos
                    </a>
                </div>
            </article>
        </main>
    </div>
    
    <script src="../../assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            renderFavorites();
            
            // Clear all favorites
            document.getElementById('clear-favorites').addEventListener('click', () => {
                if (confirm('Remover todos os favoritos?')) {
                    localStorage.removeItem('rawg-favorites');
                    renderFavorites();
                }
            });
        });
        
        function renderFavorites() {
            const favorites = FavoritesManager.getAll();
            const grid = document.getElementById('favorites-grid');
            const emptyState = document.getElementById('empty-state');
            const clearBtn = document.getElementById('clear-favorites');
            
            if (favorites.length === 0) {
                grid.style.display = 'none';
                emptyState.style.display = 'block';
                clearBtn.style.display = 'none';
                return;
            }
            
            grid.style.display = 'grid';
            emptyState.style.display = 'none';
            clearBtn.style.display = 'flex';
            
            grid.innerHTML = favorites.map(game => `
                <div class="card animate-on-scroll" data-game-id="${game.id}">
                    <img src="${game.image || ''}" alt="${game.name}" loading="lazy">
                    <div class="card-body">
                        <strong>${game.name}</strong>
                        <div class="card-actions">
                            <a href="../game/index.php?id=${game.id}" class="btn-view">
                                <span class="material-icons">visibility</span>
                                Ver detalhes
                            </a>
                            <button class="btn-remove" onclick="removeFavorite(${game.id})">
                                <span class="material-icons">delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }
        
        function removeFavorite(gameId) {
            FavoritesManager.remove(gameId);
            
            // Animate card removal
            const card = document.querySelector(`[data-game-id="${gameId}"]`);
            if (card) {
                card.style.transform = 'scale(0.8)';
                card.style.opacity = '0';
                setTimeout(() => renderFavorites(), 300);
            } else {
                renderFavorites();
            }
        }
    </script>
</body>
</html>
