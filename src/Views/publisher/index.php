<?php
/**
 * Publishers List View
 * 
 * @var array $publishers Publishers list
 * @var int $currentPage Current page
 * @var int $totalCount Total publishers count
 * @var bool $hasNextPage Has next page
 * @var bool $hasPrevPage Has previous page
 * @var int $pageSize Items per page
 */
$basePath = '/RAWG_v2';
$totalPages = ($pageSize ?? 20) > 0 ? ceil(($totalCount ?? 0) / ($pageSize ?? 20)) : 1;
?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-building me-2 text-primary"></i>
            Publishers
            <?php if (!empty($totalCount)): ?>
            <small class="text-muted fs-6">(<?= number_format($totalCount, 0, ',', '.') ?> registro(s))</small>
            <?php endif; ?>
        </h2>
    </div>
    
    <?php if (empty($publishers)): ?>
    <div class="empty-state text-center py-5">
        <i class="bi bi-building display-1 text-muted mb-3"></i>
        <h3>Nenhum publisher encontrado</h3>
    </div>
    <?php else: ?>
    
    <!-- Page Info Top -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">
            Exibindo <?= (($currentPage - 1) * $pageSize) + 1 ?>-<?= min($currentPage * $pageSize, $totalCount) ?> de <?= number_format($totalCount, 0, ',', '.') ?> publishers
        </span>
        <span class="text-muted">
            Página <?= $currentPage ?> de <?= $totalPages ?>
        </span>
    </div>
    
    <!-- Publishers Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <?php foreach ($publishers as $pub): ?>
        <div class="col">
            <a href="<?= $basePath ?>/publisher/<?= $pub->id ?>" class="text-decoration-none">
                <div class="card h-100 publisher-card">
                    <div class="card-img-wrapper">
                        <img src="<?= htmlspecialchars($pub->image_background ?? '/RAWG_v2/public/assets/images/placeholder.jpg') ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($pub->name) ?>"
                             loading="lazy"
                             style="height: 150px; object-fit: cover;">
                        <div class="card-overlay">
                            <span class="badge bg-success fs-6">
                                <?= number_format($pub->games_count ?? 0, 0, ',', '.') ?> jogos
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-body"><?= htmlspecialchars($pub->name) ?></h5>
                        <div class="card-games">
                            <?php foreach (array_slice($pub->games ?? [], 0, 3) as $game): ?>
                            <small class="text-muted d-block text-truncate">• <?= htmlspecialchars($game->name) ?></small>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <nav class="mt-4" aria-label="Navegação de páginas">
        <ul class="pagination justify-content-center gap-2">
            <!-- Previous Button -->
            <li class="page-item <?= !$hasPrevPage ? 'disabled' : '' ?>">
                <a class="page-link rounded-pill px-4" 
                   href="<?= $basePath ?>/publishers?page=<?= $currentPage - 1 ?>"
                   <?= !$hasPrevPage ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                    <i class="bi bi-chevron-left me-1"></i> Anterior
                </a>
            </li>
            
            <!-- Page Numbers -->
            <?php
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);
            
            if ($startPage > 1): ?>
            <li class="page-item">
                <a class="page-link rounded-pill" href="<?= $basePath ?>/publishers?page=1">1</a>
            </li>
            <?php if ($startPage > 2): ?>
            <li class="page-item disabled"><span class="page-link border-0">...</span></li>
            <?php endif; ?>
            <?php endif; ?>
            
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                <a class="page-link rounded-pill" href="<?= $basePath ?>/publishers?page=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>
            
            <?php if ($endPage < $totalPages): ?>
            <?php if ($endPage < $totalPages - 1): ?>
            <li class="page-item disabled"><span class="page-link border-0">...</span></li>
            <?php endif; ?>
            <li class="page-item">
                <a class="page-link rounded-pill" href="<?= $basePath ?>/publishers?page=<?= $totalPages ?>"><?= $totalPages ?></a>
            </li>
            <?php endif; ?>
            
            <!-- Next Button -->
            <li class="page-item <?= !$hasNextPage ? 'disabled' : '' ?>">
                <a class="page-link rounded-pill px-4" 
                   href="<?= $basePath ?>/publishers?page=<?= $currentPage + 1 ?>"
                   <?= !$hasNextPage ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                    Próxima <i class="bi bi-chevron-right ms-1"></i>
                </a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<style>
.publisher-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.publisher-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(34, 197, 94, 0.2);
}
.publisher-card .card-overlay {
    position: absolute;
    bottom: 0.5rem;
    right: 0.5rem;
}
.publisher-card .card-img-wrapper {
    position: relative;
}
</style>
