<?php

declare(strict_types=1);

/**
 * Genre Controller
 * 
 * Handles genre browsing functionality.
 * 
 * @package App\Controllers
 */

namespace App\Controllers;

/**
 * Class GenreController
 */
class GenreController extends BaseController
{
    /**
     * Display genres page with games.
     * 
     * @return void
     */
    public function index(): void
    {
        $genresResponse = $this->api->getGenres();
        $genres = $genresResponse->results ?? [];

        $selectedId = (int) $this->getParam('id', $genres[0]->id ?? 0);
        $page = (int) $this->getParam('page', 1);

        $games = [];
        if ($selectedId > 0) {
            $response = $this->api->getGamesByGenre($selectedId, $page);
            if ($response && isset($response->results)) {
                $games = $response->results;
            }
        }

        $this->setTitle('Gêneros - RAWG API');

        $this->render('genre/index', [
            'genres' => $genres,
            'games' => $games,
            'selectedId' => $selectedId,
            'page' => $page
        ]);
    }
}
