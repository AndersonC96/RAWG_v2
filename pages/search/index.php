<?php
/**
 * RAWG_v2 - Search Page
 * 
 * Search for games by name
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);
include_once('../../controllers/searchController.php');
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../assets/redoc-logo.png">
    <title>Pesquisar Jogos - RAWG API</title>
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
                <!-- Search Form -->
                <div class="search-hero">
                    <h1>
                        <span class="material-icons">search</span>
                        Pesquisar Jogos
                    </h1>
                    <p>Encontre informações sobre milhares de jogos</p>
                    
                    <form action="" method="POST" class="search-form">
                        <div class="search-input-wrapper glass">
                            <span class="material-icons">videogame_asset</span>
                            <input type="text" 
                                   name="search" 
                                   value="<?= htmlspecialchars($searchQuery) ?>" 
                                   placeholder="Digite o nome do jogo..."
                                   autocomplete="off"
                                   required>
                            <button type="submit">
                                <span class="material-icons">search</span>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Recent Searches -->
                    <div class="recent-searches" id="recent-searches"></div>
                </div>
                
                <?php if (!empty($searchQuery)): ?>
                <!-- Search Results -->
                <div class="results-header">
                    <h2>Resultados para: "<span class="text-gradient"><?= htmlspecialchars($searchQuery) ?></span>"</h2>
                    <span class="results-count"><?= count($data) ?> jogos encontrados</span>
                </div>
                
                <?php if (count($data) > 0): ?>
                <div class="grid">
                    <?php foreach ($data as $game): ?>
                    <div class="card animate-on-scroll">
                        <img src="<?= htmlspecialchars($game->background_image ?? '') ?>" 
                             alt="<?= htmlspecialchars($game->slug ?? 'Game') ?>"
                             loading="lazy">
                        <div class="card-body">
                            <div class="card-genres">
                                <?php 
                                $genreCount = 0;
                                foreach ($game->genres ?? [] as $genre):
                                    if (++$genreCount > 3) break;
                                ?>
                                <span><?= htmlspecialchars($genre->name) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <strong><?= htmlspecialchars($game->name) ?></strong>
                            <div class="card-descriptions">
                                <div class="ratings">
                                    <?php foreach ($game->ratings ?? [] as $rating): ?>
                                    <div>
                                        <?= ucfirst(htmlspecialchars($rating->title)) ?>
                                        <span class="porcent">
                                            <span style="width: <?= htmlspecialchars($rating->percent) ?>%;"></span>
                                        </span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <a href="../game/index.php?id=<?= $game->id ?>" class="open-game" title="Ver detalhes">
                                <span class="material-icons">open_in_new</span>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <!-- No Results -->
                <div class="no-results glass">
                    <span class="material-icons">sentiment_dissatisfied</span>
                    <h3>Nenhum jogo encontrado</h3>
                    <p>Tente buscar com termos diferentes</p>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </article>
        </main>
    </div>
    
    <script src="../../assets/js/main.js"></script>
    <script>
        // Show recent searches
        document.addEventListener('DOMContentLoaded', () => {
            const history = SearchHistory.getAll();
            const container = document.getElementById('recent-searches');
            
            if (history.length > 0) {
                container.innerHTML = `
                    <span class="recent-label">Buscas recentes:</span>
                    ${history.slice(0, 5).map(q => `
                        <button type="button" onclick="searchFor('${q.replace(/'/g, "\\'")}')">
                            ${q}
                        </button>
                    `).join('')}
                `;
            }
        });
        
        function searchFor(query) {
            const input = document.querySelector('input[name="search"]');
            input.value = query;
            input.form.submit();
        }
        
        // Save search on submit
        document.querySelector('.search-form').addEventListener('submit', () => {
            const query = document.querySelector('input[name="search"]').value;
            SearchHistory.add(query);
        });
    </script>
</body>
</html>