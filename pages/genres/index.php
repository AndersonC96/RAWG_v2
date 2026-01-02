<?php
/**
 * RAWG_v2 - Genres Page
 * 
 * Browse games by genre
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);
include_once('../../controllers/genresController.php');
?>
<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../assets/redoc-logo.png">
    <title>Gêneros - RAWG API</title>
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
                <!-- Genre Header -->
                <div class="genre-header">
                    <h1>
                        <span class="material-icons">view_module</span>
                        Explorar por Gênero
                    </h1>
                    
                    <form action="" method="GET" class="genre-filter glass">
                        <label for="select-genre">
                            <span class="material-icons">filter_list</span>
                            Filtrar:
                        </label>
                        <select name="id" id="select-genre" onchange="this.form.submit()">
                            <?php foreach ($genres as $genre): ?>
                            <option value="<?= $genre->id ?>" <?= intval($id) === $genre->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($genre->name) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                
                <!-- Genre Tags -->
                <div class="genre-tags">
                    <?php foreach (array_slice($genres, 0, 10) as $genre): ?>
                    <a href="./index.php?id=<?= $genre->id ?>" 
                       class="genre-tag <?= intval($id) === $genre->id ? 'active' : '' ?>">
                        <?= htmlspecialchars($genre->name) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                
                <!-- Games Grid -->
                <?php if (!empty($data)): ?>
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
                                foreach ($game->genres ?? [] as $g):
                                    if (++$genreCount > 3) break;
                                ?>
                                <span><?= htmlspecialchars($g->name) ?></span>
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
                <div class="no-results glass">
                    <span class="material-icons">sports_esports</span>
                    <h3>Nenhum jogo encontrado</h3>
                    <p>Tente selecionar outro gênero</p>
                </div>
                <?php endif; ?>
            </article>
        </main>
    </div>
    
    <script src="../../assets/js/main.js"></script>
</body>
</html>