<?php
/**
 * Genre Page View
 * 
 * @var array $genres All genres
 * @var array $games Games in selected genre
 * @var int $selectedId Selected genre ID
 * @var int $page Current page
 * @var int $totalCount Total games count
 * @var bool $hasNextPage Has next page
 * @var bool $hasPrevPage Has previous page
 * @var int $pageSize Items per page
 */
$basePath = '/RAWG_v2';
$totalPages = $pageSize > 0 ? ceil($totalCount / $pageSize) : 1;
?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="mb-0">
            <i class="bi bi-collection-fill me-2 text-primary"></i>
            Explorar por Gênero
            <?php if ($totalCount > 0): ?>
            <small class="text-muted fs-6">(<?= number_format($totalCount, 0, ',', '.') ?> jogos)</small>
            <?php endif; ?>
        </h2>
        
        <div class="genre-filter">
            <select class="form-select" id="genreSelect" onchange="window.location.href='<?= $basePath ?>/genres?id=' + this.value">
                <?php foreach ($genres as $genre): ?>
                <option value="<?= $genre->id ?>" <?= $selectedId === $genre->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($genre->name) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    
    <!-- Genre Pills -->
    <div class="genre-pills mb-4">
        <div class="d-flex flex-wrap gap-2">
            <?php foreach (array_slice($genres, 0, 12) as $genre): ?>
            <a href="<?= $basePath ?>/genres?id=<?= $genre->id ?>" 
               class="btn <?= $selectedId === $genre->id ? 'btn-primary' : 'btn-outline-secondary' ?> btn-sm">
                <?= htmlspecialchars($genre->name) ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php if (empty($games)): ?>
    <!-- Empty State -->
    <div class="empty-state text-center py-5">
        <i class="bi bi-controller display-1 text-muted mb-3"></i>
        <h3>Nenhum jogo encontrado</h3>
        <p class="text-muted">Selecione outro gênero</p>
    </div>
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
                   href="<?= $basePath ?>/genres?id=<?= $selectedId ?>&page=<?= $page - 1 ?>"
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
                <a class="page-link rounded-pill" href="<?= $basePath ?>/genres?id=<?= $selectedId ?>&page=1">1</a>
            </li>
            <?php if ($startPage > 2): ?>
            <li class="page-item disabled"><span class="page-link border-0">...</span></li>
            <?php endif; ?>
            <?php endif; ?>
            
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link rounded-pill" href="<?= $basePath ?>/genres?id=<?= $selectedId ?>&page=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>
            
            <?php if ($endPage < $totalPages): ?>
            <?php if ($endPage < $totalPages - 1): ?>
            <li class="page-item disabled"><span class="page-link border-0">...</span></li>
            <?php endif; ?>
            <li class="page-item">
                <a class="page-link rounded-pill" href="<?= $basePath ?>/genres?id=<?= $selectedId ?>&page=<?= $totalPages ?>"><?= $totalPages ?></a>
            </li>
            <?php endif; ?>
            
            <!-- Next Button -->
            <li class="page-item <?= !$hasNextPage ? 'disabled' : '' ?>">
                <a class="page-link rounded-pill px-4" 
                   href="<?= $basePath ?>/genres?id=<?= $selectedId ?>&page=<?= $page + 1 ?>"
                   <?= !$hasNextPage ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                    Próxima <i class="bi bi-chevron-right ms-1"></i>
                </a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>
</div>

