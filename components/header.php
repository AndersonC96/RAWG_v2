<?php
/**
 * Header Component
 * 
 * Top navigation bar with search and mobile menu toggle
 */

$basePath = getBasePath();
?>
<header class="header-search">
    <button type="button" onclick="handleMenu()" aria-label="Toggle Menu" class="menu-toggle">
        <span class="material-icons">menu</span>
    </button>
    <a href="<?= $basePath ?>/pages/search/index.php" class="field-search">
        <span class="material-icons">search</span>
        <span>Procurar jogos...</span>
    </a>
    <button type="button" onclick="toggleTheme()" aria-label="Toggle Theme" class="theme-toggle">
        <span class="material-icons" id="theme-icon">dark_mode</span>
    </button>
</header>