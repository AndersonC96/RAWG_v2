<?php
/**
 * Publishers List View
 * 
 * @var array $publishers Publishers list
 * @var int $currentPage Current page
 */
$basePath = '/RAWG_v2';
?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-building me-2 text-primary"></i>
            Publishers
        </h2>
    </div>
    
    <?php if (empty($publishers)): ?>
    <div class="empty-state text-center py-5">
        <i class="bi bi-building display-1 text-muted mb-3"></i>
        <h3>Nenhum publisher encontrado</h3>
    </div>
    <?php else: ?>
    
    <!-- Publishers Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <?php foreach ($publishers as $pub): ?>
        <div class="col">
            <a href="<?= $basePath ?>/publisher/<?= $pub->id ?>" class="text-decoration-none">
                <div class="card h-100 publisher-card">
                    <div class="card-img-wrapper">
                        <img src="<?= htmlspecialchars($pub->image_background ?? '') ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($pub->name) ?>"
                             style="height: 150px; object-fit: cover;">
                        <div class="card-overlay">
                            <span class="badge bg-success fs-6">
                                <?= $pub->games_count ?? 0 ?> jogos
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
