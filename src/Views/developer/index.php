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
        <h2 class="mb-0">
            <i class="bi bi-people-fill me-2 text-primary"></i>
            Desenvolvedores
        </h2>
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
                        <img src="<?= htmlspecialchars($dev->image_background ?? '') ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($dev->name) ?>"
                             style="height: 150px; object-fit: cover;">
                        <div class="card-overlay">
                            <span class="badge bg-primary fs-6">
                                <?= $dev->games_count ?? 0 ?> jogos
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-body"><?= htmlspecialchars($dev->name) ?></h5>
                        <div class="card-games">
                            <?php foreach (array_slice($dev->games ?? [], 0, 3) as $game): ?>
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
    <?php if (!empty($nextPage) || !empty($previousPage)): ?>
    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $previousPage === null ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $basePath ?>/developers?page=<?= $previousPage ?? 1 ?>">
                    <i class="bi bi-chevron-left"></i> Anterior
                </a>
            </li>
            <li class="page-item active"><span class="page-link"><?= $currentPage ?></span></li>
            <li class="page-item <?= $nextPage === null ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $basePath ?>/developers?page=<?= $nextPage ?>">
                    Próxima <i class="bi bi-chevron-right"></i>
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
