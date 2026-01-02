<?php
/**
 * Game Details View
 * 
 * @var object $game Game details
 * @var object|null $screenshots Screenshots response
 * @var object|null $additions Additions response
 * @var object|null $gameSeries Game series response
 * @var object|null $achievements Achievements response
 */
$basePath = '/RAWG_v2';
?>

<!-- Hero Section -->
<section class="game-hero mb-4">
    <div class="hero-background" style="background-image: url('<?= htmlspecialchars($game->background_image ?? '') ?>');">
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content container-fluid">
        <div class="row align-items-end">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $basePath ?>/">Home</a></li>
                        <li class="breadcrumb-item active"><?= htmlspecialchars($game->name) ?></li>
                    </ol>
                </nav>
                
                <div class="d-flex align-items-center gap-3 mb-3">
                    <?php if (!empty($game->metacritic)): ?>
                    <span class="metacritic-badge bg-<?= $game->metacritic >= 75 ? 'success' : ($game->metacritic >= 50 ? 'warning' : 'danger') ?>">
                        <?= $game->metacritic ?>
                    </span>
                    <?php endif; ?>
                    <span class="badge bg-primary bg-opacity-75">
                        <i class="bi bi-star-fill me-1"></i>
                        #<?= $game->rating_top ?> Top <?= date('Y') ?>
                    </span>
                </div>
                
                <h1 class="game-title display-5 fw-bold mb-3"><?= htmlspecialchars($game->name) ?></h1>
                
                <div class="game-actions d-flex gap-2 flex-wrap">
                    <button class="btn btn-primary btn-lg btn-favorite-main"
                            data-game-id="<?= $game->id ?>"
                            data-game-name="<?= htmlspecialchars($game->name) ?>"
                            data-game-image="<?= htmlspecialchars($game->background_image ?? '') ?>">
                        <i class="bi bi-heart me-2"></i>
                        <span>Adicionar aos Favoritos</span>
                    </button>
                    
                    <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#shareModal">
                        <i class="bi bi-share me-2"></i>
                        Compartilhar
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container-fluid">
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Description -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-file-text me-2 text-primary"></i>
                        Descrição
                    </h5>
                    <div class="game-description">
                        <?= $game->description ?>
                    </div>
                </div>
            </div>
            
            <!-- Screenshots -->
            <?php if (!empty($screenshots->results)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-images me-2 text-primary"></i>
                        Screenshots
                    </h5>
                    <div class="row g-3">
                        <?php foreach (array_slice($screenshots->results, 0, 6) as $screenshot): ?>
                        <div class="col-md-4">
                            <a href="<?= htmlspecialchars($screenshot->image) ?>" 
                               data-bs-toggle="modal" 
                               data-bs-target="#imageModal"
                               data-image="<?= htmlspecialchars($screenshot->image) ?>"
                               class="screenshot-link">
                                <img src="<?= htmlspecialchars($screenshot->image) ?>" 
                                     class="img-fluid rounded" 
                                     alt="Screenshot"
                                     loading="lazy">
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Achievements -->
            <?php if (!empty($achievements->results)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-trophy me-2 text-warning"></i>
                        Conquistas (<?= $achievements->count ?>)
                    </h5>
                    <div class="row g-3">
                        <?php foreach (array_slice($achievements->results, 0, 8) as $achievement): ?>
                        <div class="col-md-6">
                            <div class="achievement-card d-flex gap-3 p-3 rounded bg-body-tertiary">
                                <img src="<?= htmlspecialchars($achievement->image) ?>" 
                                     alt="<?= htmlspecialchars($achievement->name) ?>"
                                     class="achievement-icon rounded"
                                     width="48" height="48">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= htmlspecialchars($achievement->name) ?></h6>
                                    <small class="text-muted d-block"><?= htmlspecialchars($achievement->description) ?></small>
                                    <small class="text-success">
                                        <i class="bi bi-percent"></i> <?= $achievement->percent ?>% desbloquearam
                                    </small>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Game Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Informações
                    </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Lançamento</span>
                            <span><?= !empty($game->released) ? date('d/m/Y', strtotime($game->released)) : 'N/A' ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Metacritic</span>
                            <span><?= $game->metacritic ?? 'N/A' ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Duração</span>
                            <span><?= $game->playtime > 0 ? $game->playtime . 'h' : 'N/A' ?></span>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-2">Gêneros</span>
                            <div class="d-flex flex-wrap gap-1">
                                <?php foreach ($game->genres ?? [] as $genre): ?>
                                <span class="badge bg-secondary"><?= htmlspecialchars($genre->name) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-2">Plataformas</span>
                            <div class="d-flex flex-wrap gap-1">
                                <?php foreach ($game->platforms ?? [] as $p): ?>
                                <span class="badge bg-dark"><?= htmlspecialchars($p->platform->name) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-2">Desenvolvedora</span>
                            <?php 
                            $devs = array_map(fn($d) => $d->name, $game->developers ?? []);
                            echo htmlspecialchars(implode(', ', $devs) ?: 'N/A');
                            ?>
                        </li>
                        <li class="list-group-item px-0">
                            <span class="text-muted d-block mb-2">Publisher</span>
                            <?php 
                            $pubs = array_map(fn($p) => $p->name, $game->publishers ?? []);
                            echo htmlspecialchars(implode(', ', $pubs) ?: 'N/A');
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Ratings -->
            <?php if (!empty($game->ratings)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-bar-chart me-2 text-primary"></i>
                        Avaliações
                    </h5>
                    <?php foreach ($game->ratings as $rating): ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><?= ucfirst($rating->title) ?></span>
                            <span class="text-muted"><?= number_format($rating->percent, 1) ?>%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
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
            
            <!-- Stores -->
            <?php if (!empty($game->stores)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-shop me-2 text-primary"></i>
                        Onde Comprar
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($game->stores as $store): ?>
                        <a href="https://<?= htmlspecialchars($store->store->domain) ?>" 
                           target="_blank" 
                           rel="noopener"
                           class="btn btn-outline-secondary btn-sm">
                            <?= htmlspecialchars($store->store->name) ?>
                            <i class="bi bi-box-arrow-up-right ms-1"></i>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Tags -->
            <?php if (!empty($game->tags)): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <i class="bi bi-tags me-2 text-primary"></i>
                        Tags
                    </h5>
                    <div class="d-flex flex-wrap gap-1">
                        <?php foreach (array_slice($game->tags, 0, 15) as $tag): ?>
                        <span class="badge bg-body-tertiary text-body"><?= htmlspecialchars($tag->name) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Related Games -->
    <?php if (!empty($gameSeries->results)): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title d-flex align-items-center mb-3">
                <i class="bi bi-collection me-2 text-primary"></i>
                Jogos da Franquia
            </h5>
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                <?php foreach (array_slice($gameSeries->results, 0, 6) as $related): ?>
                <div class="col">
                    <a href="<?= $basePath ?>/game/<?= $related->id ?>" class="text-decoration-none">
                        <div class="related-game-card">
                            <img src="<?= htmlspecialchars($related->background_image ?? '') ?>" 
                                 class="img-fluid rounded mb-2" 
                                 alt="<?= htmlspecialchars($related->name) ?>">
                            <h6 class="text-truncate mb-0"><?= htmlspecialchars($related->name) ?></h6>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                <img src="" id="modalImage" class="img-fluid rounded" alt="Screenshot">
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Compartilhar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center gap-3">
                    <a href="https://twitter.com/intent/tweet?text=<?= urlencode($game->name) ?>&url=<?= urlencode('http://localhost' . $basePath . '/game/' . $game->id) ?>" 
                       target="_blank" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://localhost' . $basePath . '/game/' . $game->id) ?>" 
                       target="_blank" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://wa.me/?text=<?= urlencode($game->name . ' - http://localhost' . $basePath . '/game/' . $game->id) ?>" 
                       target="_blank" class="btn btn-outline-success btn-lg">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <button class="btn btn-outline-secondary btn-lg" onclick="copyLink()">
                        <i class="bi bi-link-45deg"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Screenshot modal
    document.querySelectorAll('.screenshot-link').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('modalImage').src = link.dataset.image;
        });
    });
    
    // Check favorite status
    const gameId = <?= $game->id ?>;
    if (window.FavoritesManager && FavoritesManager.isFavorite(gameId)) {
        const btn = document.querySelector('.btn-favorite-main');
        if (btn) {
            btn.querySelector('i').classList.replace('bi-heart', 'bi-heart-fill');
            btn.querySelector('span').textContent = 'Remover dos Favoritos';
        }
    }
});

function copyLink() {
    navigator.clipboard.writeText(window.location.href);
    alert('Link copiado!');
}
</script>
