<?php
/**
 * Header Partial
 */
$basePath = '/RAWG_v2';
?>
<header class="main-header">
    <div class="header-left">
        <button class="btn btn-link sidebar-toggle d-lg-none" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>
    </div>
    
    <div class="header-center">
        <form action="<?= $basePath ?>/search" method="GET" class="search-form">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" 
                       name="q" 
                       class="form-control border-start-0" 
                       placeholder="Pesquisar jogos..."
                       value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                       autocomplete="off">
            </div>
        </form>
    </div>
    
    <div class="header-right">
        <button class="btn btn-link position-relative" id="notificationsBtn" title="Notificações">
            <i class="bi bi-bell fs-5"></i>
        </button>
        
        <div class="dropdown">
            <button class="btn btn-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar">
                    <i class="bi bi-person-circle fs-4"></i>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= $basePath ?>/favorites">
                    <i class="bi bi-heart me-2"></i> Favoritos
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" id="themeToggleMenu">
                    <i class="bi bi-moon-stars me-2"></i> Alternar Tema
                </a></li>
            </ul>
        </div>
    </div>
</header>
