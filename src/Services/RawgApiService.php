<?php

declare(strict_types=1);

/**
 * RAWG API Service
 * 
 * Handles all API communication with RAWG.io
 * 
 * @package App\Services
 */

namespace App\Services;

use App\Config\Config;

/**
 * Class RawgApiService
 * 
 * Provides methods to interact with the RAWG API.
 */
class RawgApiService
{
    /** @var string API base URL */
    private string $baseUrl;

    /** @var string API key */
    private string $apiKey;

    /** @var int Request timeout in seconds */
    private int $timeout = 30;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->baseUrl = Config::getApiBaseUrl();
        $this->apiKey = Config::getApiKey();
    }

    /**
     * Make an API request.
     * 
     * @param string $endpoint API endpoint
     * @param array<string, mixed> $params Query parameters
     * @return object|null Decoded response or null on error
     */
    public function request(string $endpoint, array $params = []): ?object
    {
        if (empty($this->apiKey)) {
            error_log('RAWG API: API key not configured');
            return null;
        }

        $params['key'] = $this->apiKey;
        $url = $this->baseUrl . $endpoint . '?' . http_build_query($params);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'User-Agent: RAWG_v2/2.0'
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log("RAWG API cURL Error: {$error}");
            return null;
        }

        if ($httpCode !== 200) {
            error_log("RAWG API HTTP Error: {$httpCode} for {$endpoint}");
            return null;
        }

        $decoded = json_decode($response);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('RAWG API JSON Error: ' . json_last_error_msg());
            return null;
        }

        return $decoded;
    }

    /**
     * Get games list.
     * 
     * @param int $page Page number
     * @param array<string, mixed> $filters Additional filters
     * @return object|null Games response
     */
    public function getGames(int $page = 1, array $filters = []): ?object
    {
        return $this->request('games', array_merge(['page' => $page], $filters));
    }

    /**
     * Get game details.
     * 
     * @param int $id Game ID
     * @return object|null Game details
     */
    public function getGame(int $id): ?object
    {
        return $this->request("games/{$id}");
    }

    /**
     * Search games.
     * 
     * @param string $query Search term
     * @param int $page Page number
     * @return object|null Search results
     */
    public function searchGames(string $query, int $page = 1): ?object
    {
        return $this->request('games', [
            'search' => $query,
            'page' => $page
        ]);
    }

    /**
     * Get all genres.
     * 
     * @return object|null Genres list
     */
    public function getGenres(): ?object
    {
        return $this->request('genres');
    }

    /**
     * Get games by genre.
     * 
     * @param int $genreId Genre ID
     * @param int $page Page number
     * @return object|null Games list
     */
    public function getGamesByGenre(int $genreId, int $page = 1): ?object
    {
        return $this->request('games', [
            'genres' => $genreId,
            'page' => $page
        ]);
    }

    /**
     * Get game screenshots.
     * 
     * @param int $id Game ID
     * @return object|null Screenshots
     */
    public function getGameScreenshots(int $id): ?object
    {
        return $this->request("games/{$id}/screenshots");
    }

    /**
     * Get game achievements (single page).
     * 
     * @param int $id Game ID
     * @param int $page Page number
     * @return object|null Achievements
     */
    public function getGameAchievements(int $id, int $page = 1): ?object
    {
        return $this->request("games/{$id}/achievements", ['page' => $page]);
    }

    /**
     * Get ALL game achievements with automatic pagination.
     * 
     * @param int $id Game ID
     * @param int $maxPages Maximum pages to fetch (default 10, safety limit)
     * @return object|null All achievements combined
     */
    public function getAllGameAchievements(int $id, int $maxPages = 10): ?object
    {
        $allResults = [];
        $page = 1;
        $totalCount = 0;
        
        do {
            $response = $this->getGameAchievements($id, $page);
            
            if (!$response || empty($response->results)) {
                break;
            }
            
            if ($page === 1) {
                $totalCount = $response->count ?? 0;
            }
            
            $allResults = array_merge($allResults, $response->results);
            $hasMore = !empty($response->next);
            $page++;
            
        } while ($hasMore && $page <= $maxPages);
        
        // Return combined result
        return (object) [
            'count' => $totalCount,
            'results' => $allResults
        ];
    }

    /**
     * Get game DLCs/additions (single page).
     * 
     * @param int $id Game ID
     * @param int $page Page number
     * @return object|null Additions
     */
    public function getGameAdditions(int $id, int $page = 1): ?object
    {
        return $this->request("games/{$id}/additions", ['page' => $page]);
    }

    /**
     * Get ALL game DLCs/additions with automatic pagination.
     * 
     * @param int $id Game ID
     * @param int $maxPages Maximum pages to fetch (default 10)
     * @return object|null All additions combined
     */
    public function getAllGameAdditions(int $id, int $maxPages = 10): ?object
    {
        $allResults = [];
        $page = 1;
        $totalCount = 0;
        
        do {
            $response = $this->getGameAdditions($id, $page);
            
            if (!$response || empty($response->results)) {
                break;
            }
            
            if ($page === 1) {
                $totalCount = $response->count ?? 0;
            }
            
            $allResults = array_merge($allResults, $response->results);
            $hasMore = !empty($response->next);
            $page++;
            
        } while ($hasMore && $page <= $maxPages);
        
        return (object) [
            'count' => $totalCount,
            'results' => $allResults
        ];
    }

    /**
     * Get games from the same series.
     * 
     * @param int $id Game ID
     * @return object|null Game series
     */
    public function getGameSeries(int $id): ?object
    {
        return $this->request("games/{$id}/game-series");
    }

    /**
     * Get game development team (single page).
     * 
     * @param int $id Game ID
     * @param int $page Page number
     * @return object|null Dev team
     */
    public function getGameDevTeam(int $id, int $page = 1): ?object
    {
        return $this->request("games/{$id}/development-team", ['page' => $page]);
    }

    /**
     * Get ALL game development team with automatic pagination.
     * 
     * @param int $id Game ID
     * @param int $maxPages Maximum pages to fetch (default 10)
     * @return object|null All dev team combined
     */
    public function getAllGameDevTeam(int $id, int $maxPages = 10): ?object
    {
        $allResults = [];
        $page = 1;
        $totalCount = 0;
        
        do {
            $response = $this->getGameDevTeam($id, $page);
            
            if (!$response || empty($response->results)) {
                break;
            }
            
            if ($page === 1) {
                $totalCount = $response->count ?? 0;
            }
            
            $allResults = array_merge($allResults, $response->results);
            $hasMore = !empty($response->next);
            $page++;
            
        } while ($hasMore && $page <= $maxPages);
        
        return (object) [
            'count' => $totalCount,
            'results' => $allResults
        ];
    }

    /**
     * Get platforms list.
     * 
     * @return object|null Platforms
     */
    public function getPlatforms(): ?object
    {
        return $this->request('platforms');
    }

    /**
     * Get game trailers/movies.
     * 
     * @param int $id Game ID
     * @return object|null Trailers
     */
    public function getGameTrailers(int $id): ?object
    {
        return $this->request("games/{$id}/movies");
    }

    /**
     * Get developers list.
     * 
     * @param int $page Page number
     * @return object|null Developers
     */
    public function getDevelopers(int $page = 1): ?object
    {
        return $this->request('developers', ['page' => $page, 'page_size' => 20]);
    }

    /**
     * Get developer details.
     * 
     * @param int $id Developer ID
     * @return object|null Developer
     */
    public function getDeveloper(int $id): ?object
    {
        return $this->request("developers/{$id}");
    }

    /**
     * Get games by developer.
     * 
     * @param int $developerId Developer ID
     * @param int $page Page number
     * @return object|null Games
     */
    public function getGamesByDeveloper(int $developerId, int $page = 1): ?object
    {
        return $this->request('games', [
            'developers' => $developerId,
            'page' => $page
        ]);
    }

    /**
     * Get publishers list.
     * 
     * @param int $page Page number
     * @return object|null Publishers
     */
    public function getPublishers(int $page = 1): ?object
    {
        return $this->request('publishers', ['page' => $page, 'page_size' => 20]);
    }

    /**
     * Get publisher details.
     * 
     * @param int $id Publisher ID
     * @return object|null Publisher
     */
    public function getPublisher(int $id): ?object
    {
        return $this->request("publishers/{$id}");
    }

    /**
     * Get tags list.
     * 
     * @param int $page Page number
     * @return object|null Tags
     */
    public function getTags(int $page = 1): ?object
    {
        return $this->request('tags', ['page' => $page, 'page_size' => 40]);
    }

    /**
     * Get stores list.
     * 
     * @return object|null Stores
     */
    public function getStores(): ?object
    {
        return $this->request('stores');
    }

    /**
     * Get games with advanced filters.
     * 
     * @param array<string, mixed> $filters
     * @return object|null Games
     */
    public function getGamesFiltered(array $filters = []): ?object
    {
        $params = [
            'page' => $filters['page'] ?? 1,
            'page_size' => $filters['page_size'] ?? 20
        ];

        if (!empty($filters['platforms'])) {
            $params['platforms'] = $filters['platforms'];
        }
        if (!empty($filters['dates'])) {
            $params['dates'] = $filters['dates'];
        }
        if (!empty($filters['metacritic'])) {
            $params['metacritic'] = $filters['metacritic'];
        }
        if (!empty($filters['ordering'])) {
            $params['ordering'] = $filters['ordering'];
        }
        if (!empty($filters['tags'])) {
            $params['tags'] = $filters['tags'];
        }
        if (!empty($filters['developers'])) {
            $params['developers'] = $filters['developers'];
        }
        if (!empty($filters['publishers'])) {
            $params['publishers'] = $filters['publishers'];
        }

        return $this->request('games', $params);
    }
}
