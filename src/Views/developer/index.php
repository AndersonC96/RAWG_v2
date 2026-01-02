<?php
/**
 * Developers List View
 * 
 * @var array $developers Developers list
 * @var int $currentPage Current page
 */
$basePath = '/RAWG_v2';
?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-people-fill text-primary"></i>
                Desenvolvedores
            </h2>
            <?php
            $startItem = ($currentPage - 1) * $pageSize + 1;
            $endItem = min($currentPage * $pageSize, $totalCount);
            ?>
            <small class="text-muted">
                Exibindo <?= $startItem ?>-<?= $endItem ?> de <?= number_format($totalCount, 0, ',', '.') ?> desenvolvedores
            </small>
        </div>
    </div>
    
    <?php if (empty($developers)): ?>
    <div class="empty-state text-center py-5">
        <i class="bi bi-people display-1 text-muted mb-3"></i>
        <h3>Nenhum desenvolvedor encontrado</h3>
    </div>
    <?php else: ?>
    
    <!-- Developers Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <?php foreach ($developers as $dev): ?>
        <div class="col">
            <a href="<?= $basePath ?>/developer/<?= $dev->id ?>" class="text-decoration-none">
                <div class="card h-100 developer-card">
                    <div class="card-img-wrapper">
                        <?php if (!empty($dev->image_background)): ?>
                        <img src="<?= htmlspecialchars($dev->image_background) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($dev->name) ?>"
                             loading="lazy"
                             style="height: 150px; object-fit: cover;">
                        <?php else: ?>
                        <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 150px;">
                            <i class="bi bi-image text-muted fs-1"></i>
                        </div>
                        <?php endif; ?>
                        <div class="card-overlay">
                            <span class="badge bg-primary fs-6">
                                <?= number_format($dev->games_count ?? 0, 0, ',', '.') ?> jogos
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-body mb-2"><?= htmlspecialchars($dev->name) ?></h5>
                        <div class="card-games small">
                            <?php 
                            $topGames = array_slice($dev->games ?? [], 0, 3);
                            if (!empty($topGames)):
                                foreach ($topGames as $game): 
                            ?>
                            <div class="text-muted text-truncate">
                                <i class="bi bi-controller me-1" style="font-size: 0.75rem;"></i>
                                <?= htmlspecialchars($game->name) ?>
                            </div>
                            <?php 
                                endforeach;
                            else:
                            ?>
                            <span class="text-muted fst-italic">Sem jogos em destaque</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($totalCount > $pageSize): ?>
    <nav class="mt-5 mb-4">
        <ul class="pagination justify-content-center align-items-center gap-2">
            <!-- Previous -->
            <li class="page-item <?= empty($previousPage) ? 'disabled' : '' ?>">
                <a class="page-link rounded-pill px-4" href="<?= $basePath ?>/developers?page=<?= $previousPage ?? 1 ?>">
                    <i class="bi bi-arrow-left me-2"></i> Anterior
                </a>
            </li>

            <!-- Current Page Info -->
            <li class="page-item disabled">
                <span class="page-link border-0 bg-transparent text-muted">
                    Página <?= $currentPage ?> de <?= ceil($totalCount / $pageSize) ?>
                </span>
            </li>

            <!-- Next -->
            <li class="page-item <?= empty($nextPage) ? 'disabled' : '' ?>">
                <a class="page-link rounded-pill px-4" href="<?= $basePath ?>/developers?page=<?= $nextPage ?? $currentPage ?>">
                    Próxima <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
    <?php endif; ?>
</div>

<style>
.developer-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.developer-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(99, 102, 241, 0.2);
}
.developer-card .card-overlay {
    position: absolute;
    bottom: 0.5rem;
    right: 0.5rem;
}
.developer-card .card-img-wrapper {
    position: relative;
}
</style>
