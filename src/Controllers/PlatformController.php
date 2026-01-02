<?php

declare(strict_types=1);

/**
 * Platform Controller
 * 
 * Handles platform listings.
 * 
 * @package App\Controllers
 */

namespace App\Controllers;

/**
 * Class PlatformController
 */
class PlatformController extends BaseController
{
    /**
     * Display platforms list.
     * 
     * @return void
     */
    public function index(): void
    {
        $response = $this->api->getPlatforms();
        $platforms = $response->results ?? [];

        $selectedId = (int) $this->getParam('id', 0);
        $games = [];

        if ($selectedId > 0) {
            $gamesResponse = $this->api->getGamesFiltered([
                'platforms' => $selectedId,
                'page' => (int) $this->getParam('page', 1)
            ]);
            $games = $gamesResponse->results ?? [];
        }

        $this->setTitle('Plataformas - RAWG API');

        $this->render('platform/index', [
            'platforms' => $platforms,
            'games' => $games,
            'selectedId' => $selectedId
        ]);
    }
}
