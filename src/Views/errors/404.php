<?php
/**
 * 404 Error Page
 */
$basePath = '/RAWG_v2';
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada - RAWG API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }
        .error-code { font-size: 8rem; font-weight: 800; line-height: 1; }
        .error-glitch {
            animation: glitch 1s linear infinite;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        @keyframes glitch {
            2%, 64% { transform: translate(2px, 0) skew(0deg); }
            4%, 60% { transform: translate(-2px, 0) skew(0deg); }
            62% { transform: translate(0, 0) skew(5deg); }
        }
    </style>
</head>
<body>
    <div class="text-center">
        <div class="error-code error-glitch">404</div>
        <h1 class="h3 mb-3">Página não encontrada</h1>
        <p class="text-muted mb-4"><?= htmlspecialchars($message ?? 'A página que você está procurando não existe.') ?></p>
        <a href="<?= $basePath ?>/" class="btn btn-primary btn-lg">
            <i class="bi bi-house me-2"></i>
            Voltar ao início
        </a>
    </div>
</body>
</html>
