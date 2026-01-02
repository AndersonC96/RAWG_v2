<?php
/**
 * Game Card Partial
 * 
 * @var object $game Game object
 */
$basePath = '/RAWG_v2';
?>
<div class="col">
    <div class="card game-card h-100">
        <div class="card-img-wrapper">
            <img src="<?= htmlspecialchars($game->background_image ?? '/RAWG_v2/public/assets/images/placeholder.jpg') ?>" 
                 class="card-img-top" 
                 alt="<?= htmlspecialchars($game->name ?? 'Game') ?>"
                 loading="lazy">
            
            <div class="card-badges">
                <?php if (!empty($game->metacritic)): ?>
                <span class="badge bg-<?= $game->metacritic >= 75 ? 'success' : ($game->metacritic >= 50 ? 'warning' : 'danger') ?>">
                    <?= $game->metacritic ?>
                </span>
                <?php endif; ?>
            </div>
            
            <div class="card-overlay">
                <a href="<?= $basePath ?>/game/<?= $game->id ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-eye-fill me-1"></i> Ver Detalhes
                </a>
                <button class="btn btn-outline-light btn-sm btn-favorite" 
                        data-game-id="<?= $game->id ?>"
                        data-game-name="<?= htmlspecialchars($game->name) ?>"
                        data-game-image="<?= htmlspecialchars($game->background_image ?? '') ?>">
                    <i class="bi bi-heart"></i>
                </button>
            </div>
        </div>
        
        <div class="card-body">
            <div class="card-genres mb-2">
                <?php 
                $genreCount = 0;
                foreach ($game->genres ?? [] as $genre):
                    if (++$genreCount > 3) break;
                ?>
                <span class="badge bg-primary bg-opacity-25 text-primary"><?= htmlspecialchars($genre->name) ?></span>
                <?php endforeach; ?>
            </div>
            
            <h5 class="card-title"><?= htmlspecialchars($game->name) ?></h5>
            
            <div class="card-platforms">
                <?php foreach ($game->parent_platforms ?? [] as $platform): ?>
                <i class="bi bi-<?= match($platform->platform->slug) {
                    'pc' => 'windows',
                    'playstation' => 'playstation',
                    'xbox' => 'xbox',
                    'nintendo' => 'nintendo-switch',
                    'ios' => 'apple',
                    'android' => 'android2',
                    default => 'controller'
                } ?>" title="<?= htmlspecialchars($platform->platform->name) ?>"></i>
                <?php endforeach; ?>
            </div>
        </div>
        
        <?php if (!empty($game->ratings)): ?>
        <div class="card-footer bg-transparent">
            <div class="rating-bars">
                <?php foreach (array_slice($game->ratings, 0, 3) as $rating): ?>
                <div class="rating-bar">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="text-muted"><?= ucfirst($rating->title) ?></small>
                        <small class="text-muted"><?= number_format($rating->percent, 0) ?>%</small>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-<?= match($rating->title) {
                            'exceptional' => 'success',
                            'recommended' => 'primary',
                            'meh' => 'warning',
                            default => 'secondary'
                        } ?>" style="width: <?= $rating->percent ?>%;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
