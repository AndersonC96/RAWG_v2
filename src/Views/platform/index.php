<?php
/**
 * Platforms View
 * 
 * @var array $platforms All platforms
 * @var array $games Games (if platform selected)
 * @var int $selectedId Selected platform ID
 * @var int $page Current page
 * @var int $totalCount Total games count
 * @var bool $hasNextPage Has next page
 * @var bool $hasPrevPage Has previous page
 * @var int $pageSize Items per page
 */
$basePath = '/RAWG_v2';
$totalPages = ($pageSize ?? 20) > 0 ? ceil(($totalCount ?? 0) / ($pageSize ?? 20)) : 1;
$selectedPlatform = null;
foreach ($platforms as $p) {
    if ($p->id === $selectedId) {
        $selectedPlatform = $p;
        break;
    }
}
?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="mb-0">
            <i class="bi bi-display me-2 text-primary"></i>
            Plataformas
            <?php if ($selectedId > 0 && $totalCount > 0): ?>
            <small class="text-muted fs-6">(<?= number_format($totalCount, 0, ',', '.') ?> jogos)</small>
            <?php endif; ?>
        </h2>
    </div>
    
    <!-- Platform Pills -->
    <div class="platform-pills mb-4">
        <div class="d-flex flex-wrap gap-2">
            <?php foreach (array_slice($platforms, 0, 15) as $platform): ?>
            <a href="<?= $basePath ?>/platforms?id=<?= $platform->id ?>" 
               class="btn <?= $selectedId === $platform->id ? 'btn-primary' : 'btn-outline-secondary' ?>">
                <?= htmlspecialchars($platform->name) ?>
                <span class="badge bg-dark ms-1"><?= number_format($platform->games_count ?? 0, 0, ',', '.') ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php if ($selectedId > 0): ?>
        <?php if (empty($games)): ?>
        <div class="alert alert-info">Nenhum jogo encontrado para esta plataforma.</div>
        <?php else: ?>
        
        <!-- Page Info Top -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">
                Exibindo <?= (($page - 1) * $pageSize) + 1 ?>-<?= min($page * $pageSize, $totalCount) ?> de <?= number_format($totalCount, 0, ',', '.') ?> jogos
            </span>
            <span class="text-muted">
                Página <?= $page ?> de <?= $totalPages ?>
            </span>
        </div>
        
        <!-- Games Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            <?php foreach ($games as $game): ?>
                <?php require ROOT_PATH . '/src/Views/partials/game-card.php'; ?>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <nav class="mt-4" aria-label="Navegação de páginas">
            <ul class="pagination justify-content-center gap-2">
                <!-- Previous Button -->
                <li class="page-item <?= !$hasPrevPage ? 'disabled' : '' ?>">
                    <a class="page-link rounded-pill px-4" 
                       href="<?= $basePath ?>/platforms?id=<?= $selectedId ?>&page=<?= $page - 1 ?>"
                       <?= !$hasPrevPage ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                        <i class="bi bi-chevron-left me-1"></i> Anterior
                    </a>
                </li>
                
                <!-- Page Numbers -->
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($totalPages, $page + 2);
                
                if ($startPage > 1): ?>
                <li class="page-item">
                    <a class="page-link rounded-pill" href="<?= $basePath ?>/platforms?id=<?= $selectedId ?>&page=1">1</a>
                </li>
                <?php if ($startPage > 2): ?>
                <li class="page-item disabled"><span class="page-link border-0">...</span></li>
                <?php endif; ?>
                <?php endif; ?>
                
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link rounded-pill" href="<?= $basePath ?>/platforms?id=<?= $selectedId ?>&page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>
                
                <?php if ($endPage < $totalPages): ?>
                <?php if ($endPage < $totalPages - 1): ?>
                <li class="page-item disabled"><span class="page-link border-0">...</span></li>
                <?php endif; ?>
                <li class="page-item">
                    <a class="page-link rounded-pill" href="<?= $basePath ?>/platforms?id=<?= $selectedId ?>&page=<?= $totalPages ?>"><?= $totalPages ?></a>
                </li>
                <?php endif; ?>
                
                <!-- Next Button -->
                <li class="page-item <?= !$hasNextPage ? 'disabled' : '' ?>">
                    <a class="page-link rounded-pill px-4" 
                       href="<?= $basePath ?>/platforms?id=<?= $selectedId ?>&page=<?= $page + 1 ?>"
                       <?= !$hasNextPage ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                        Próxima <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    <?php else: ?>
    <!-- All Platforms -->
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-3">
        <?php foreach ($platforms as $platform): ?>
        <div class="col">
            <a href="<?= $basePath ?>/platforms?id=<?= $platform->id ?>" class="text-decoration-none">
                <div class="card h-100 platform-card text-center">
                    <div class="card-body">
                        <i class="bi bi-<?= match($platform->slug) {
                            'pc' => 'windows',
                            'playstation5', 'playstation4', 'playstation3', 'playstation2', 'playstation1', 'ps-vita', 'psp' => 'playstation',
                            'xbox-one', 'xbox-series-x', 'xbox360', 'xbox-old' => 'xbox',
                            'nintendo-switch' => 'nintendo-switch',
                            'ios', 'macos', 'macintosh', 'apple-ii' => 'apple',
                            'android' => 'android2',
                            'linux' => 'ubuntu',
                            default => 'controller'
                        } ?> display-6 text-primary mb-2"></i>
                        <h6 class="card-title mb-1"><?= htmlspecialchars($platform->name) ?></h6>
                        <small class="text-muted"><?= number_format($platform->games_count ?? 0, 0, ',', '.') ?> jogos</small>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<style>
.platform-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.platform-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.2);
}
</style>

