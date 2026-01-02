<?php
/**
 * Home Controller
 * 
 * Handles the main page with featured game and games grid
 */

require_once __DIR__ . '/../services/api.php';

// Get current page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Fetch games
$response = api('games', ['page' => $page]);

if (!$response || !isset($response->results)) {
    $data = [];
    $next = null;
    $previous = null;
    $errorMessage = 'Não foi possível carregar os jogos. Tente novamente mais tarde.';
} else {
    $data = $response->results;
    
    // Select random featured game
    $sorty = count($data) > 0 ? array_rand($data) : 0;
    
    // Parse pagination
    $next = $response->next ? preg_match('/page=(\d+)/', $response->next, $m) ? $m : null : null;
    $previous = $response->previous ? preg_match('/page=(\d+)/', $response->previous, $m) ? $m : null : null;
}