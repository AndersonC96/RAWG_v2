<?php
/**
 * Comparison View
 * 
 * @var array $games Selected games to compare
 */
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="/RAWG_v2/" class="text-decoration-none text-muted mb-2 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
            <h1 class="display-6 fw-bold">Comparação de Jogos</h1>
        </div>
        
        <?php if (!empty($games)): ?>
        <button class="btn btn-outline-danger btn-sm" onclick="window.gameComparison.clear(); window.location.href='/RAWG_v2/'">
            <i class="bi bi-trash me-1"></i> Limpar Tudo
        </button>
        <?php endif; ?>
    </div>

    <?php if (empty($games)): ?>
    <div class="empty-state text-center py-5">
        <i class="bi bi-arrow-left-right display-1 text-muted mb-3"></i>
        <h3>Nenhum jogo selecionado</h3>
        <p class="text-muted">Selecione jogos na home page para compará-los.</p>
        <a href="/RAWG_v2/" class="btn btn-primary mt-3">Explorar Jogos</a>
    </div>
    <?php else: ?>

    <div class="comparison-table-wrapper">
        <table class="table table-dark table-borderless mb-0 comparison-table">
            <thead>
                <tr>
                    <th scope="col" class="text-muted border-bottom-0">Atributo</th>
                    <?php foreach ($games as $game): ?>
                    <td class="text-center position-relative border-bottom-0" style="min-width: 250px;">
                        <img src="<?= htmlspecialchars($game->background_image ?? '') ?>" 
                             class="game-thumb mb-3" 
                             alt="<?= htmlspecialchars($game->name) ?>">
                        <h4 class="h5 fw-bold mb-1">
                            <a href="/RAWG_v2/game/<?= $game->id ?>" class="text-decoration-none text-white stretched-link">
                                <?= htmlspecialchars($game->name) ?>
                            </a>
                        </h4>
                    </td>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <!-- Release Date -->
                <tr>
                    <th scope="row">Lançamento</th>
                    <?php foreach ($games as $game): ?>
                    <td class="text-center">
                        <?= date('d/m/Y', strtotime($game->released)) ?>
                    </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Metacritic -->
                <tr>
                    <th scope="row">Metacritic</th>
                    <?php 
                    $ratings = array_map(fn($g) => $g->metacritic ?? 0, $games);
                    $maxRating = max($ratings);
                    ?>
                    <?php foreach ($games as $game): ?>
                    <td class="text-center">
                        <?php if (!empty($game->metacritic)): ?>
                        <span class="badge bg-<?= $game->metacritic >= 75 ? 'success' : ($game->metacritic >= 50 ? 'warning' : 'danger') ?> fs-6 <?= $game->metacritic === $maxRating ? 'border border-2 border-white' : '' ?>">
                            <?= $game->metacritic ?>
                        </span>
                        <?php else: ?>
                        <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Genres -->
                <tr>
                    <th scope="row">Gêneros</th>
                    <?php foreach ($games as $game): ?>
                    <td class="text-center">
                        <div class="d-flex flex-wrap justify-content-center gap-1">
                            <?php foreach (array_slice($game->genres ?? [], 0, 3) as $genre): ?>
                            <span class="badge bg-secondary bg-opacity-50"><?= htmlspecialchars($genre->name) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Playtime -->
                <tr>
                    <th scope="row">Tempo de Jogo</th>
                    <?php foreach ($games as $game): ?>
                    <td class="text-center">
                        <?php if (!empty($game->playtime)): ?>
                        <i class="bi bi-clock me-1 text-primary"></i> <?= $game->playtime ?> horas
                        <?php else: ?>
                        -
                        <?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Platforms -->
                <tr>
                    <th scope="row">Plataformas</th>
                    <?php foreach ($games as $game): ?>
                    <td class="text-center">
                        <div class="d-flex flex-wrap justify-content-center gap-2 fs-5 text-muted">
                        <?php foreach ($game->parent_platforms ?? [] as $platform): ?>
                            <i class="bi bi-<?= match($platform->platform->slug) {
                                'pc' => 'windows',
                                'playstation' => 'playstation',
                                'xbox' => 'xbox',
                                'nintendo' => 'nintendo-switch',
                                'ios', 'mac', 'macos', 'macintosh', 'apple' => 'apple',
                                'android' => 'android2',
                                'linux' => 'ubuntu',
                                'web' => 'globe',
                                default => 'controller'
                            } ?>" title="<?= htmlspecialchars($platform->platform->name) ?>"></i>
                        <?php endforeach; ?>
                        </div>
                    </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<style>
.comparison-winner-row {
    background: rgba(74, 222, 128, 0.1);
}
</style>
