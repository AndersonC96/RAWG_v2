<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? 'RAWG API - Explore milhares de jogos') ?>">
    <link rel="icon" type="image/png" href="/RAWG_v2/public/assets/images/logo.png">
    <title><?= htmlspecialchars($pageTitle ?? 'RAWG API') ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/RAWG_v2/public/assets/css/style.css">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/RAWG_v2/manifest.json">
    <meta name="theme-color" content="#6366f1">
</head>
<body>
    <!-- Sidebar -->
    <?php require ROOT_PATH . '/src/Views/partials/sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Header -->
        <?php require ROOT_PATH . '/src/Views/partials/header.php'; ?>
        
        <!-- Page Content -->
        <main class="main-content">
            <?= $content ?>
        </main>
        
        <!-- Footer -->
        <?php require ROOT_PATH . '/src/Views/partials/footer.php'; ?>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer"></div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="/RAWG_v2/public/assets/js/app.js"></script>
</body>
</html>
