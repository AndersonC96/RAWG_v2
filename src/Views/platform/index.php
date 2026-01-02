<?php
/**
 * Platforms View
 * 
 * @var array $platforms All platforms
 * @var array $games Games (if platform selected)
 * @var int $selectedId Selected platform ID
 */
$basePath = '/RAWG_v2';
?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="mb-0">
            <i class="bi bi-display me-2 text-primary"></i>
            Plataformas
        </h2>
    </div>
    
    <!-- Platform Pills -->
    <div class="platform-pills mb-4">
        <div class="d-flex flex-wrap gap-2">
            <?php foreach (array_slice($platforms, 0, 15) as $platform): ?>
            <a href="<?= $basePath ?>/platforms?id=<?= $platform->id ?>" 
               class="btn <?= $selectedId === $platform->id ? 'btn-primary' : 'btn-outline-secondary' ?>">
                <?= htmlspecialchars($platform->name) ?>
                <span class="badge bg-dark ms-1"><?= $platform->games_count ?? 0 ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php if ($selectedId > 0): ?>
        <?php if (empty($games)): ?>
        <div class="alert alert-info">Nenhum jogo encontrado para esta plataforma.</div>
        <?php else: ?>
        <!-- Games Grid -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            <?php foreach ($games as $game): ?>
                <?php require ROOT_PATH . '/src/Views/partials/game-card.php'; ?>
            <?php endforeach; ?>
        </div>
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
                        <small class="text-muted"><?= number_format($platform->games_count ?? 0) ?> jogos</small>
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
