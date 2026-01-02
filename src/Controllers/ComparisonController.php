<?php

declare(strict_types=1);

namespace App\Controllers;

class ComparisonController extends BaseController
{
    public function index(): void
    {
        $ids = $this->getParam('ids', '');
        $gameIds = array_filter(explode(',', $ids), fn($id) => is_numeric($id));
        
        $games = [];
        if (!empty($gameIds)) {
            // Limit to 3
            $gameIds = array_slice($gameIds, 0, 3);
            
            foreach ($gameIds as $id) {
                $game = $this->api->getGame((int)$id);
                if ($game) {
                    $games[] = $game;
                }
            }
        }

        $this->render('comparison/index', [
            'games' => $games
        ]);
    }
}
