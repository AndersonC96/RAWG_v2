<?php
/**
 * Error Component
 * Displays user-friendly error messages
 */
?>
<div class="error-container">
    <div class="error-content">
        <span class="material-icons error-icon">error_outline</span>
        <h1>Ops! Algo deu errado</h1>
        <p><?= htmlspecialchars($message ?? 'Ocorreu um erro inesperado.') ?></p>
        <a href="<?= getBasePath() ?>/index.php" class="error-button">
            <span class="material-icons">home</span>
            Voltar ao Início
        </a>
    </div>
</div>
<style>
.error-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 60vh;
    padding: 20px;
}
.error-content {
    text-align: center;
    background: rgba(51, 46, 89, 0.8);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 40px;
    max-width: 400px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}
.error-icon {
    font-size: 64px;
    color: #ff6b6b;
    margin-bottom: 20px;
}
.error-content h1 {
    color: #fff;
    font-size: 24px;
    margin-bottom: 10px;
}
.error-content p {
    color: #a9a5bc;
    margin-bottom: 30px;
}
.error-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    padding: 12px 24px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 500;
    transition: transform 0.2s, box-shadow 0.2s;
}
.error-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
}
</style>
