<?php
/**
 * Genre Page View
 * 
 * @var array $genres All genres
 * @var array $games Games in selected genre
 * @var int $selectedId Selected genre ID
 * @var int $page Current page
 */
$basePath = '/RAWG_v2';
?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="mb-0">
            <i class="bi bi-collection-fill me-2 text-primary"></i>
            Explorar por Gênero
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
    <!-- Games Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <?php foreach ($games as $game): ?>
            <?php require ROOT_PATH . '/src/Views/partials/game-card.php'; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
