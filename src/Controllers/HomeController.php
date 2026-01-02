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

        $response = $this->api->getGames($page);

        $games = [];
        $featured = null;
        $next = null;
        $previous = null;

        if ($response && isset($response->results)) {
            $games = $response->results;
            
            // Select random featured game (with video clip preferred)
            $gamesWithClip = array_filter($games, fn($g) => !empty($g->clip));
            $featured = count($gamesWithClip) > 0 
                ? $gamesWithClip[array_rand($gamesWithClip)]
                : ($games[array_rand($games)] ?? null);

            // Parse pagination URLs
            if ($response->next) {
                preg_match('/page=(\d+)/', $response->next, $matches);
                $next = $matches[1] ?? null;
            }
            if ($response->previous) {
                preg_match('/page=(\d+)/', $response->previous, $matches);
                $previous = $matches[1] ?? null;
            }
        }

        $this->setTitle('RAWG API - Explore o Mundo dos Games');
        $this->setDescription('Explore milhares de jogos com informações detalhadas, screenshots e avaliações.');

        $this->render('home/index', [
            'games' => $games,
            'featured' => $featured,
            'currentPage' => $page,
            'nextPage' => $next,
            'previousPage' => $previous
        ]);
    }
}
