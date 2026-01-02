<?php
/**
 * RAWG API Service
 * 
 * Handles all API communication with RAWG.io
 * Uses configuration from config/config.php
 */

// Load configuration
require_once __DIR__ . '/../config/config.php';

/**
 * Make an API request to RAWG
 * 
 * @param string $endpoint API endpoint (e.g., 'games', 'games/123')
 * @param array $params Additional query parameters
 * @return object|null Decoded JSON response or null on error
 * @throws Exception If API key is not configured
 */
function api(string $endpoint = 'games', array $params = []): ?object {
    if (empty(RAWG_API_KEY)) {
        throw new Exception('API key not configured. Please check your .env file.');
    }
    
    // Build query string
    $params['key'] = RAWG_API_KEY;
    $queryString = http_build_query($params);
    $url = RAWG_BASE_URL . $endpoint . '?' . $queryString;
    
    // Initialize cURL
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'User-Agent: RAWG_v2/1.0'
        ]
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    // Handle errors
    if ($error) {
        error_log("RAWG API cURL Error: $error");
        return null;
    }
    
    if ($httpCode !== 200) {
        error_log("RAWG API HTTP Error: $httpCode for endpoint $endpoint");
        return null;
    }
    
    if (empty($response)) {
        error_log("RAWG API Empty Response for endpoint $endpoint");
        return null;
    }
    
    $decoded = json_decode($response);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("RAWG API JSON Error: " . json_last_error_msg());
        return null;
    }
    
    return $decoded;
}

/**
 * Search games by name
 * 
 * @param string $query Search term
 * @param int $page Page number
 * @return object|null Search results
 */
function apiSearch(string $query, int $page = 1): ?object {
    return api('games', [
        'search' => $query,
        'page' => $page
    ]);
}

/**
 * Get all genres
 * 
 * @return object|null Genres list
 */
function apiGenres(): ?object {
    return api('genres');
}

/**
 * Get games by genre
 * 
 * @param int $genreId Genre ID
 * @param int $page Page number
 * @return object|null Games list
 */
function apiGamesByGenre(int $genreId, int $page = 1): ?object {
    return api('games', [
        'genres' => $genreId,
        'page' => $page
    ]);
}

/**
 * Get game details by ID
 * 
 * @param int $gameId Game ID
 * @return object|null Game details
 */
function apiGameDetails(int $gameId): ?object {
    return api("games/$gameId");
}

/**
 * Get game screenshots
 * 
 * @param int $gameId Game ID
 * @return object|null Screenshots
 */
function apiGameScreenshots(int $gameId): ?object {
    return api("games/$gameId/screenshots");
}

/**
 * Get game achievements
 * 
 * @param int $gameId Game ID
 * @return object|null Achievements
 */
function apiGameAchievements(int $gameId): ?object {
    return api("games/$gameId/achievements");
}

/**
 * Get game DLCs and additions
 * 
 * @param int $gameId Game ID
 * @return object|null Additions
 */
function apiGameAdditions(int $gameId): ?object {
    return api("games/$gameId/additions");
}

/**
 * Get games from the same series
 * 
 * @param int $gameId Game ID
 * @return object|null Game series
 */
function apiGameSeries(int $gameId): ?object {
    return api("games/$gameId/game-series");
}

/**
 * Get game development team
 * 
 * @param int $gameId Game ID
 * @return object|null Dev team
 */
function apiGameDevTeam(int $gameId): ?object {
    return api("games/$gameId/development-team");
}

/**
 * Get game trailers/movies
 * 
 * @param int $gameId Game ID
 * @return object|null Trailers
 */
function apiGameTrailers(int $gameId): ?object {
    return api("games/$gameId/movies");
}