<?php
/**
 * Sidebar Partial
 */

$currentUri = $_SERVER['REQUEST_URI'] ?? '/';
$basePath = '/RAWG_v2';

$menuItems = [
    ['path' => '/', 'icon' => 'bi-house-fill', 'label' => 'Home'],
    ['path' => '/search', 'icon' => 'bi-search', 'label' => 'Pesquisar'],
    ['path' => '/genres', 'icon' => 'bi-collection-fill', 'label' => 'Gêneros'],
    ['path' => '/favorites', 'icon' => 'bi-heart-fill', 'label' => 'Favoritos'],
];

function isActive(string $path, string $currentUri, string $basePath): bool {
    $fullPath = $basePath . $path;
    if ($path === '/') {
        return $currentUri === $fullPath || $currentUri === $fullPath . '/';
    }
    return str_starts_with($currentUri, $fullPath);
}
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="<?= $basePath ?>/" class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-controller"></i>
            </div>
            <span class="brand-text">RAWG<span class="text-primary">API</span></span>
        </a>
        <button class="btn-close-sidebar d-lg-none" id="closeSidebar">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <?php foreach ($menuItems as $item): ?>
            <li class="nav-item">
                <a href="<?= $basePath . $item['path'] ?>" 
                   class="nav-link <?= isActive($item['path'], $currentUri, $basePath) ? 'active' : '' ?>">
                    <i class="<?= $item['icon'] ?>"></i>
                    <span><?= $item['label'] ?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <div class="theme-switcher">
            <button class="btn btn-sm btn-outline-light w-100" id="themeToggle">
                <i class="bi bi-moon-stars-fill me-2"></i>
                <span>Tema</span>
            </button>
        </div>
        <div class="sidebar-credits">
            <small class="text-muted">
                <i class="bi bi-code-slash"></i>
                Portfolio Project
            </small>
        </div>
    </div>
</aside>
