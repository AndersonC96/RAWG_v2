<?php

declare(strict_types=1);

/**
 * Search Controller
 * 
 * Handles game search functionality.
 * 
 * @package App\Controllers
 */

namespace App\Controllers;

/**
 * Class SearchController
 */
class SearchController extends BaseController
{
    /**
     * Display search page and results.
     * 
     * @return void
     */
    public function index(): void
    {
        $query = trim($this->post('search', $this->getParam('q', '')));
        $games = [];

        if (!empty($query)) {
            $response = $this->api->searchGames($query);
            if ($response && isset($response->results)) {
                $games = $response->results;
            }
        }

        $this->setTitle('Pesquisar Jogos - RAWG API');

        $this->render('search/index', [
            'query' => $query,
            'games' => $games,
            'hasSearched' => !empty($query)
        ]);
    }
}
