<?php
/**
 * Sidebar Component
 * 
 * Navigation sidebar with dynamic active states
 */

$currentUrl = explode('/', $_SERVER['REQUEST_URI']);

/**
 * Check if a route is currently active
 */
function isActive(string $route): string {
    global $currentUrl;
    
    if (in_array($route, $currentUrl)) {
        return 'active';
    }
    
    // Home is active when not in any pages subfolder
    if ($route === 'home' && !in_array('pages', $currentUrl)) {
        return 'active';
    }
    
    return '';
}

$basePath = getBasePath();
?>
<aside class="left-menu" id="sidebar">
    <div class="logo-menu">
        <div>
            <img src="<?= $basePath ?>/assets/redoc-logo.png" alt="RAWG API Logo">
            <h3>RAWG API</h3>
        </div>
    </div>
    <nav class="menu">
        <ul class="menu-group">
            <li class="menu-item <?= isActive('home') ?>">
                <a href="<?= $basePath ?>/index.php">
                    <span class="material-icons">home</span>
                    Home
                </a>
            </li>
            <li class="menu-item <?= isActive('search') ?>">
                <a href="<?= $basePath ?>/pages/search/index.php">
                    <span class="material-icons">search</span>
                    Procurar
                </a>
            </li>
            <li class="menu-item <?= isActive('genres') ?>">
                <a href="<?= $basePath ?>/pages/genres/index.php">
                    <span class="material-icons">view_module</span>
                    Gêneros
                </a>
            </li>
            <li class="menu-item <?= isActive('favorites') ?>">
                <a href="<?= $basePath ?>/pages/favorites/index.php">
                    <span class="material-icons">favorite</span>
                    Favoritos
                </a>
            </li>
        </ul>
    </nav>
    <div class="menu-footer">
        <strong>
            <span class="material-icons">code</span>
            Portfolio Project
        </strong>
    </div>
</aside>