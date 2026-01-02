<?php
/**
 * Game Controller
 * 
 * Handles the game details page
 */

require_once __DIR__ . '/../services/api.php';

// Get game ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    redirect(getBasePath() . '/index.php');
}

// Fetch game details
$data = apiGameDetails($id);

if (!$data) {
    $errorMessage = 'Jogo não encontrado ou não disponível.';
    http_response_code(404);
} else {
    // Fetch additional data
    $screenshots = apiGameScreenshots($id);
    $additions = apiGameAdditions($id);
    $gameSeries = apiGameSeries($id);
    $achievements = apiGameAchievements($id);
    $devTeam = apiGameDevTeam($id);
    $trailers = apiGameTrailers($id);
}