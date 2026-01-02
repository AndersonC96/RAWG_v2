<?php
/**
 * Publisher Details View
 * 
 * @var object $publisher Publisher details
 * @var int $gamesCount Total games count
 */
$basePath = '/RAWG_v2';
?>

<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $basePath ?>/">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= $basePath ?>/publishers">Publishers</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($publisher->name) ?></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="publisher-header mb-4 p-4 rounded-4" 
         style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.9)), url('<?= htmlspecialchars($publisher->image_background ?? '') ?>') center/cover;">
        <h1 class="display-6 text-white mb-2"><?= htmlspecialchars($publisher->name) ?></h1>
        <p class="text-white-50 mb-0">
            <i class="bi bi-controller me-2"></i>
            <?= $gamesCount ?> jogos publicados
        </p>
    </div>

    <!-- Description -->
    <?php if (!empty($publisher->description)): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Sobre</h5>
            <div class="pub-description"><?= $publisher->description ?></div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Top Games -->
    <?php if (!empty($publisher->games)): ?>
    <h4 class="mb-3">
        <i class="bi bi-star me-2 text-warning"></i>
        Top Jogos
    </h4>
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3 mb-4">
        <?php foreach (array_slice($publisher->games, 0, 6) as $game): ?>
        <div class="col">
            <a href="<?= $basePath ?>/game/<?= $game->id ?>" class="text-decoration-none">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title text-body small"><?= htmlspecialchars($game->name) ?></h6>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
