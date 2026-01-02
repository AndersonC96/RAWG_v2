<?php
/**
 * Developer Details View
 * 
 * @var object $developer Developer details
 * @var array $games Developer's games
 * @var int $gamesCount Total games count
 */
$basePath = '/RAWG_v2';
?>

<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= $basePath ?>/">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= $basePath ?>/developers">Desenvolvedores</a></li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($developer->name) ?></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="developer-header mb-4 p-4 rounded-4" 
         style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.9)), url('<?= htmlspecialchars($developer->image_background ?? '') ?>') center/cover;">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="display-6 text-white mb-2"><?= htmlspecialchars($developer->name) ?></h1>
                <p class="text-white-50 mb-0">
                    <i class="bi bi-controller me-2"></i>
                    <?= $gamesCount ?> jogos desenvolvidos
                </p>
            </div>
        </div>
    </div>

    <!-- Description -->
    <?php if (!empty($developer->description)): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Sobre</h5>
            <div class="dev-description"><?= $developer->description ?></div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Games -->
    <h4 class="mb-3">
        <i class="bi bi-collection me-2 text-primary"></i>
        Jogos de <?= htmlspecialchars($developer->name) ?>
    </h4>
    
    <?php if (empty($games)): ?>
    <div class="alert alert-info">Nenhum jogo encontrado.</div>
    <?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <?php foreach ($games as $game): ?>
            <?php require ROOT_PATH . '/src/Views/partials/game-card.php'; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
