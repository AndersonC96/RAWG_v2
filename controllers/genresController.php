<?php
/**
 * Genres Controller
 * 
 * Handles the genres listing and filtering page
 */

require_once __DIR__ . '/../services/api.php';

// Fetch all genres
$genresResponse = apiGenres();
$genres = $genresResponse ? $genresResponse->results : [];

// Get selected genre and page
$id = isset($_GET['id']) ? intval($_GET['id']) : (count($genres) > 0 ? $genres[0]->id : 0);
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Fetch games by genre
$response = apiGamesByGenre($id, $page);

if (!$response || !isset($response->results)) {
    $data = [];
    $errorMessage = 'Não foi possível carregar os jogos deste gênero.';
} else {
    $data = $response->results;
}