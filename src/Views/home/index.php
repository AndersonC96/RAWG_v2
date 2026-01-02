<?php
/**
 * Home Page View
 * 
 * @var array $games Games list
 * @var object|null $featured Featured game
 * @var int $currentPage Current page number
 * @var int|null $nextPage Next page number
 * @var int|null $previousPage Previous page number
 */
$basePath = '/RAWG_v2';
?>

<?php if ($featured): ?>
<!-- Hero Section -->
<section class="hero-section mb-4">
    <div class="hero-background" style="background-image: url('<?= htmlspecialchars($featured->background_image ?? '') ?>');">
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content container-fluid">
        <div class="row align-items-center">
            <?php if (!empty($featured->clip->clip)): ?>
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-lg">
                    <video src="<?= htmlspecialchars($featured->clip->clip) ?>" 
                           controls muted loop playsinline
                           class="object-fit-cover"></video>
                </div>
            </div>
            <div class="col-lg-5">
            <?php else: ?>
            <div class="col-12">
            <?php endif; ?>
                <div class="hero-info">
                    <h1 class="hero-title mb-3"><?= htmlspecialchars($featured->name) ?></h1>
                    
                    <div class="hero-genres mb-3">
                        <?php foreach ($featured->genres ?? [] as $genre): ?>
                        <span class="badge bg-primary bg-opacity-75"><?= htmlspecialchars($genre->name) ?></span>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if (!empty($featured->ratings)): ?>
                    <div class="hero-ratings mb-4">
                        <?php foreach (array_slice($featured->ratings, 0, 4) as $rating): ?>
                        <div class="rating-item">
                            <div class="d-flex justify-content-between mb-1">
                                <small><?= ucfirst($rating->title) ?></small>
                                <small><?= number_format($rating->percent, 0) ?>%</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" style="width: <?= $rating->percent ?>%;"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <a href="<?= $basePath ?>/game/<?= $featured->id ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-play-fill me-2"></i>
                        Ver Detalhes
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Games Grid -->
<section class="games-section">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">
                <i class="bi bi-controller me-2"></i>
                Jogos em Destaque
            </h2>
            <div class="view-options">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary active" data-view="grid">
                        <i class="bi bi-grid-fill"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" data-view="list">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <?php if (empty($games)): ?>
        <!-- Empty State -->
        <div class="empty-state text-center py-5">
            <i class="bi bi-emoji-frown display-1 text-muted mb-3"></i>
            <h3>Nenhum jogo encontrado</h3>
            <p class="text-muted">Não foi possível carregar os jogos. Tente novamente mais tarde.</p>
            <a href="<?= $basePath ?>/" class="btn btn-primary">
                <i class="bi bi-arrow-clockwise me-2"></i>
                Recarregar
            </a>
        </div>
        <?php else: ?>
        <!-- Games Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4" id="gamesGrid">
            <?php foreach ($games as $game): ?>
                <?php require ROOT_PATH . '/src/Views/partials/game-card.php'; ?>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <nav class="mt-5" aria-label="Navegação de páginas">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $previousPage === null ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $basePath ?>/?page=<?= $previousPage ?? 1 ?>">
                        <i class="bi bi-chevron-left"></i>
                        Anterior
                    </a>
                </li>
                <li class="page-item active">
                    <span class="page-link"><?= $currentPage ?></span>
                </li>
                <li class="page-item <?= $nextPage === null ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $basePath ?>/?page=<?= $nextPage ?>">
                        Próxima
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</section>
