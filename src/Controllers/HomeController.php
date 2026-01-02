<?php

declare(strict_types=1);

/**
 * Home Controller
 * 
 * Handles the home page with featured game and games grid.
 * 
 * @package App\Controllers
 */

namespace App\Controllers;

/**
 * Class HomeController
 */
class HomeController extends BaseController
{
    /**
     * Display the home page.
     * 
     * @return void
     */
    public function index(): void
    {
        $page = (int) $this->getParam('page', 1);
        $page = max(1, $page);

        // Filters
        $filters = [];
        $currentFilters = [
            'ordering' => $this->getParam('ordering', ''),
            'year' => $this->getParam('year', ''),
            'metacritic' => $this->getParam('metacritic', '')
        ];

        if (!empty($currentFilters['ordering'])) {
            $filters['ordering'] = $currentFilters['ordering'];
        }

        if (!empty($currentFilters['year'])) {
            $filters['dates'] = $currentFilters['year'] . '-01-01,' . $currentFilters['year'] . '-12-31';
        }

        if (!empty($currentFilters['metacritic'])) {
            $filters['metacritic'] = $currentFilters['metacritic'] . ',100';
        }

        $response = $this->api->getGames($page, $filters);

        $games = [];
        $featured = null;
        $next = null;
        $previous = null;

        if ($response && isset($response->results)) {
            $games = $response->results;
            
            // Select random featured game
            $gamesWithClip = array_filter($games, fn($g) => !empty($g->clip));
            
            if (!empty($gamesWithClip)) {
                $featured = $gamesWithClip[array_rand($gamesWithClip)];
            } elseif (!empty($games)) {
                $featured = $games[array_rand($games)];
            }

            // Parse pagination URLs
            if ($response->next) {
                // Keep filters in pagination
                $query = parse_url($response->next, PHP_URL_QUERY);
                parse_str($query, $params);
                $next = $params['page'] ?? null;
            }
            if ($response->previous) {
                $query = parse_url($response->previous, PHP_URL_QUERY);
                parse_str($query, $params);
                $previous = $params['page'] ?? null;
            }
        }

        $this->setTitle('RAWG API - Explore o Mundo dos Games');
        $this->setDescription('Explore milhares de jogos com informações detalhadas, screenshots e avaliações.');

        $this->render('home/index', [
            'games' => $games,
            'featured' => $featured,
            'currentPage' => $page,
            'nextPage' => $next,
            'previousPage' => $previous,
            'filters' => $currentFilters
        ]);
    }
}
