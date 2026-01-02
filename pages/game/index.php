<?php
/**
 * RAWG_v2 - Game Details Page
 * 
 * Displays detailed information about a specific game
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);
include_once('../../controllers/gameController.php');
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../assets/redoc-logo.png">
    <title><?= isset($data) ? htmlspecialchars($data->name) : 'Jogo não encontrado' ?> - RAWG API</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="./style.css">
    <?php include('../../components/importsLink.php'); ?>
</head>
<body>
    <div class="container-wrapper">
        <?php include_once('../../components/sidebar.php'); ?>
        
        <main class="main-content">
            <?php include_once('../../components/header.php'); ?>
            
            <?php if (isset($errorMessage) || !isset($data)): ?>
            <!-- Error State -->
            <div class="container">
                <div class="error-state glass">
                    <span class="material-icons">error_outline</span>
                    <h2>Jogo não encontrado</h2>
                    <p><?= htmlspecialchars($errorMessage ?? 'O jogo solicitado não existe ou não está disponível.') ?></p>
                    <a href="../../index.php" class="btn-primary">
                        <span class="material-icons">home</span>
                        Voltar ao início
                    </a>
                </div>
            </div>
            <?php else: ?>
            
            <!-- Hero Section -->
            <section class="game-hero">
                <div class="hero-background" style="background-image: url('<?= htmlspecialchars($data->background_image ?? '') ?>');"></div>
                <div class="hero-content">
                    <div class="hero-info">
                        <h1><?= htmlspecialchars($data->name) ?></h1>
                        <div class="hero-meta">
                            <?php if (!empty($data->metacritic)): ?>
                            <span class="metacritic-badge <?= $data->metacritic >= 75 ? 'high' : ($data->metacritic >= 50 ? 'mid' : 'low') ?>">
                                <?= $data->metacritic ?>
                            </span>
                            <?php endif; ?>
                            <span class="rating-badge">
                                <span class="material-icons">star</span>
                                #<?= $data->rating_top ?> Top <?= date('Y') ?>
                            </span>
                        </div>
                        <button class="btn-favorite" 
                                onclick="toggleFavorite(<?= $data->id ?>, '<?= addslashes($data->name) ?>', '<?= addslashes($data->background_image ?? '') ?>')"
                                id="favorite-btn">
                            <span class="material-icons" id="favorite-icon">favorite_border</span>
                            <span>Adicionar aos favoritos</span>
                        </button>
                    </div>
                </div>
            </section>
            
            <!-- Main Content -->
            <article class="game-container glass">
                
                <!-- Description -->
                <section class="game-section">
                    <div class="description-content">
                        <?= $data->description ?>
                    </div>
                </section>
                
                <!-- Game Info -->
                <section class="game-section">
                    <h3 class="section-title">
                        <span class="material-icons">info</span>
                        Informações
                    </h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Lançamento</span>
                            <span class="info-value"><?= !empty($data->released) ? date('d/m/Y', strtotime($data->released)) : 'N/A' ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Metacritic</span>
                            <span class="info-value"><?= $data->metacritic ?? 'N/A' ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Gêneros</span>
                            <span class="info-value">
                                <?php 
                                $genres = array_map(fn($g) => $g->name, $data->genres ?? []);
                                echo htmlspecialchars(implode(', ', $genres) ?: 'N/A');
                                ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Plataformas</span>
                            <span class="info-value">
                                <?php 
                                $platforms = array_map(fn($p) => $p->platform->name, $data->parent_platforms ?? []);
                                echo htmlspecialchars(implode(', ', $platforms) ?: 'N/A');
                                ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Desenvolvedora</span>
                            <span class="info-value">
                                <?php 
                                $devs = array_map(fn($d) => $d->name, $data->developers ?? []);
                                echo htmlspecialchars(implode(', ', $devs) ?: 'N/A');
                                ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Publisher</span>
                            <span class="info-value">
                                <?php 
                                $pubs = array_map(fn($p) => $p->name, $data->publishers ?? []);
                                echo htmlspecialchars(implode(', ', $pubs) ?: 'N/A');
                                ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Duração média</span>
                            <span class="info-value">
                                <?= $data->playtime > 0 ? $data->playtime . ' hora' . ($data->playtime > 1 ? 's' : '') : 'N/A' ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Conquistas</span>
                            <span class="info-value"><?= $achievements->count ?? 0 ?></span>
                        </div>
                    </div>
                </section>
                
                <!-- Ratings -->
                <section class="game-section">
                    <h3 class="section-title">
                        <span class="material-icons">star</span>
                        Avaliações
                    </h3>
                    <div class="ratings-grid">
                        <?php foreach ($data->ratings ?? [] as $rating): ?>
                        <div class="rating-card glass">
                            <span class="rating-title"><?= ucfirst(htmlspecialchars($rating->title)) ?></span>
                            <div class="rating-bar">
                                <div class="rating-fill" style="width: <?= $rating->percent ?>%;"></div>
                            </div>
                            <span class="rating-percent"><?= number_format($rating->percent, 1) ?>%</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                
                <!-- Screenshots -->
                <?php if (!empty($screenshots->results)): ?>
                <section class="game-section">
                    <h3 class="section-title">
                        <span class="material-icons">photo_library</span>
                        Screenshots
                    </h3>
                    <div class="screenshots-grid">
                        <?php foreach ($screenshots->results as $screenshot): ?>
                        <div class="screenshot-item" onclick="openLightbox('<?= htmlspecialchars($screenshot->image) ?>')">
                            <img src="<?= htmlspecialchars($screenshot->image) ?>" 
                                 alt="Screenshot" 
                                 loading="lazy">
                            <div class="screenshot-overlay">
                                <span class="material-icons">zoom_in</span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>
                
                <!-- DLCs -->
                <?php if (!empty($additions->results)): ?>
                <section class="game-section">
                    <h3 class="section-title">
                        <span class="material-icons">extension</span>
                        DLC's e Edições Especiais
                    </h3>
                    <div class="content-cards">
                        <?php foreach ($additions->results as $dlc): ?>
                        <a href="./index.php?id=<?= $dlc->id ?>" class="content-card glass">
                            <img src="<?= htmlspecialchars($dlc->background_image ?? '') ?>" alt="<?= htmlspecialchars($dlc->name) ?>">
                            <div class="content-card-info">
                                <strong><?= htmlspecialchars($dlc->name) ?></strong>
                                <span><?= !empty($dlc->released) ? date('d/m/Y', strtotime($dlc->released)) : '' ?></span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>
                
                <!-- Game Series -->
                <?php if (!empty($gameSeries->results)): ?>
                <section class="game-section">
                    <h3 class="section-title">
                        <span class="material-icons">collections</span>
                        Jogos da Franquia
                    </h3>
                    <div class="content-cards">
                        <?php foreach ($gameSeries->results as $game): ?>
                        <a href="./index.php?id=<?= $game->id ?>" class="content-card glass">
                            <img src="<?= htmlspecialchars($game->background_image ?? '') ?>" alt="<?= htmlspecialchars($game->name) ?>">
                            <div class="content-card-info">
                                <strong><?= htmlspecialchars($game->name) ?></strong>
                                <span><?= !empty($game->released) ? date('d/m/Y', strtotime($game->released)) : '' ?></span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>
                
                <!-- Stores -->
                <?php if (!empty($data->stores)): ?>
                <section class="game-section">
                    <h3 class="section-title">
                        <span class="material-icons">store</span>
                        Onde Comprar
                    </h3>
                    <div class="stores-grid">
                        <?php foreach ($data->stores as $store): ?>
                        <a href="https://<?= htmlspecialchars($store->store->domain) ?>" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="store-card glass">
                            <span class="store-name"><?= htmlspecialchars($store->store->name) ?></span>
                            <span class="material-icons">open_in_new</span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>
                
                <!-- Tags -->
                <?php if (!empty($data->tags)): ?>
                <section class="game-section">
                    <h3 class="section-title">
                        <span class="material-icons">label</span>
                        Tags
                    </h3>
                    <div class="tags-container">
                        <?php foreach (array_slice($data->tags, 0, 20) as $tag): ?>
                        <span class="tag-badge"><?= htmlspecialchars($tag->name) ?></span>
                        <?php endforeach; ?>
                    </div>
                </section>
                <?php endif; ?>
                
            </article>
            <?php endif; ?>
        </main>
    </div>
    
    <!-- Lightbox -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <button class="lightbox-close" onclick="closeLightbox()">
            <span class="material-icons">close</span>
        </button>
        <img id="lightbox-img" src="" alt="Screenshot">
    </div>
    
    <script src="../../assets/js/main.js"></script>
    <script>
        // Lightbox functions
        function openLightbox(src) {
            const lightbox = document.getElementById('lightbox');
            const img = document.getElementById('lightbox-img');
            img.src = src;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Check if game is favorite
        document.addEventListener('DOMContentLoaded', () => {
            const gameId = <?= $data->id ?? 0 ?>;
            if (gameId && FavoritesManager.isFavorite(gameId)) {
                document.getElementById('favorite-icon').textContent = 'favorite';
                document.querySelector('#favorite-btn span:last-child').textContent = 'Remover dos favoritos';
            }
        });
    </script>
</body>
</html>