<?php

declare(strict_types=1);

/**
 * Game Controller
 * 
 * Handles game details page.
 * 
 * @package App\Controllers
 */

namespace App\Controllers;

/**
 * Class GameController
 */
class GameController extends BaseController
{
    /**
     * Display game details.
     * 
     * @param string $id Game ID
     * @return void
     */
    public function show(string $id): void
    {
        $gameId = (int) $id;

        if ($gameId <= 0) {
            $this->redirect('/');
        }

        $game = $this->api->getGame($gameId);

        if (!$game) {
            http_response_code(404);
            $this->render('errors/404', [
                'message' => 'Jogo não encontrado'
            ]);
            return;
        }

        // Fetch additional data
        $screenshots = $this->api->getGameScreenshots($gameId);
        $trailers = $this->api->getGameTrailers($gameId);
        $additions = $this->api->getGameAdditions($gameId);
        $gameSeries = $this->api->getGameSeries($gameId);
        $achievements = $this->api->getGameAchievements($gameId);
        $devTeam = $this->api->getGameDevTeam($gameId);

        $this->setTitle($game->name . ' - RAWG API');
        $this->setDescription($game->description_raw ?? 'Detalhes do jogo ' . $game->name);

        $this->render('game/show', [
            'game' => $game,
            'screenshots' => $screenshots,
            'trailers' => $trailers,
            'additions' => $additions,
            'gameSeries' => $gameSeries,
            'achievements' => $achievements,
            'devTeam' => $devTeam
        ]);
    }
}
