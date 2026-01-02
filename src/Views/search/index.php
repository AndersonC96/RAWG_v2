<?php
/**
 * Search Page View
 * 
 * @var string $query Search query
 * @var array $games Search results
 * @var bool $hasSearched Whether a search was performed
 */
$basePath = '/RAWG_v2';
?>

<div class="container-fluid">
    <!-- Search Header -->
    <div class="search-header text-center py-5">
        <h1 class="display-5 fw-bold mb-3">
            <i class="bi bi-search me-3 text-primary"></i>
            Pesquisar Jogos
        </h1>
        <p class="lead text-muted mb-4">Encontre informações sobre milhares de jogos</p>
        
        <form action="<?= $basePath ?>/search" method="POST" class="search-form mx-auto" style="max-width: 600px;">
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-body-tertiary border-end-0">
                    <i class="bi bi-controller text-primary"></i>
                </span>
                <input type="text" 
                       name="search" 
                       class="form-control border-start-0 border-end-0" 
                       placeholder="Digite o nome do jogo..."
                       value="<?= htmlspecialchars($query) ?>"
                       autocomplete="off"
                       required>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
        
        <!-- Search History -->
        <div class="search-history mt-4" id="searchHistory"></div>
    </div>
    
    <?php if ($hasSearched): ?>
    <!-- Results Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <h4 class="mb-0">
            Resultados para: "<span class="text-primary"><?= htmlspecialchars($query) ?></span>"
        </h4>
        <span class="badge bg-secondary fs-6"><?= count($games) ?> jogos</span>
    </div>
    
    <?php if (empty($games)): ?>
    <!-- No Results -->
    <div class="empty-state text-center py-5">
        <i class="bi bi-emoji-frown display-1 text-muted mb-3"></i>
        <h3>Nenhum jogo encontrado</h3>
        <p class="text-muted">Tente buscar com termos diferentes</p>
    </div>
    <?php else: ?>
    <!-- Results Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <?php foreach ($games as $game): ?>
            <?php require ROOT_PATH . '/src/Views/partials/game-card.php'; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Show search history
    if (window.SearchHistory) {
        const history = SearchHistory.getAll();
        const container = document.getElementById('searchHistory');
        
        if (history.length > 0) {
            container.innerHTML = `
                <small class="text-muted me-2">Buscas recentes:</small>
                ${history.slice(0, 5).map(q => `
                    <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1" onclick="searchFor('${q.replace(/'/g, "\\'")}')">
                        ${q}
                    </button>
                `).join('')}
            `;
        }
    }
});

function searchFor(query) {
    document.querySelector('input[name="search"]').value = query;
    document.querySelector('.search-form').submit();
}

// Save search on submit
document.querySelector('.search-form')?.addEventListener('submit', () => {
    const query = document.querySelector('input[name="search"]').value;
    if (window.SearchHistory) SearchHistory.add(query);
});
</script>
