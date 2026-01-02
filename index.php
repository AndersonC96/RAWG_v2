<?php
/**
 * RAWG_v2 - Home Page
 * 
 * Main landing page with featured game and games grid
 */
error_reporting(E_ALL);
ini_set('display_errors', 0); // Hide errors in production
include_once('./controllers/homeController.php');
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./assets/redoc-logo.png">
    <title>RAWG API - Explore o Mundo dos Games</title>
    <link rel="stylesheet" href="./style.css">
    <?php include('./components/importsLink.php'); ?>
</head>
<body>
    <div class="container-wrapper">
        <?php include_once('./components/sidebar.php'); ?>
        
        <main class="main-content">
            <?php include_once('./components/header.php'); ?>
            
            <?php if (!empty($data) && isset($data[$sorty])): ?>
            <!-- Featured Game Hero -->
            <section class="flyer">
                <div class="background" style="background: url(<?= htmlspecialchars($data[$sorty]->background_image ?? '') ?>), #000;"></div>
                <div class="content">
                    <?php if (!empty($data[$sorty]->clip->clip)): ?>
                    <video src="<?= htmlspecialchars($data[$sorty]->clip->clip) ?>" controls muted loop playsinline></video>
                    <?php endif; ?>
                    <div class="flyer-description">
                        <h2><?= htmlspecialchars($data[$sorty]->name) ?></h2>
                        <div class="card-genres">
                            <?php foreach($data[$sorty]->genres ?? [] as $genre): ?>
                            <span><?= htmlspecialchars($genre->name) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="ratings">
                            <?php foreach($data[$sorty]->ratings ?? [] as $rating): ?>
                            <div>
                                <?= ucfirst(htmlspecialchars($rating->title)) ?>
                                <span class="porcent">
                                    <span style="width: <?= htmlspecialchars($rating->percent) ?>%;"></span>
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="./pages/game/index.php?id=<?= $data[$sorty]->id ?>" class="open-game" title="Ver detalhes">
                            <span class="material-icons">open_in_new</span>
                        </a>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            
            <!-- Games Grid -->
            <article class="container">
                <?php if (!empty($errorMessage)): ?>
                <div class="error-message glass">
                    <span class="material-icons">error_outline</span>
                    <p><?= htmlspecialchars($errorMessage) ?></p>
                </div>
                <?php elseif (empty($data)): ?>
                <!-- Skeleton Loaders -->
                <div class="grid">
                    <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="card skeleton skeleton-card"></div>
                    <?php endfor; ?>
                </div>
                <?php else: ?>
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
                            <a href="./pages/game/index.php?id=<?= $game->id ?>" class="open-game" title="Ver detalhes">
                                <span class="material-icons">open_in_new</span>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination -->
                <div class="pagination">
                    <a href="./index.php?page=<?= $previous ? ($previous[1] ?? 1) : 1 ?>" 
                       class="<?= $previous === null ? 'disable' : '' ?>"
                       title="Página anterior">
                        <span class="material-icons">keyboard_arrow_left</span>
                        Anterior
                    </a>
                    <a href="./index.php?page=<?= $next ? ($next[1] ?? '') : '' ?>" 
                       class="<?= $next === null ? 'disable' : '' ?>"
                       title="Próxima página">
                        Próxima
                        <span class="material-icons">keyboard_arrow_right</span>
                    </a>
                </div>
                <?php endif; ?>
            </article>
        </main>
    </div>
    
    <!-- JavaScript -->
    <script src="./assets/js/main.js"></script>
</body>
</html>