<?php

declare(strict_types=1);

/**
 * Developer Controller
 * 
 * Handles developer listings and details.
 * 
 * @package App\Controllers
 */

namespace App\Controllers;

/**
 * Class DeveloperController
 */
class DeveloperController extends BaseController
{
    /**
     * Display developers list.
     * 
     * @return void
     */
    public function index(): void
    {
        $page = (int) $this->getParam('page', 1);
        $page = max(1, $page);

        $response = $this->api->getDevelopers($page);
        
        $developers = $response->results ?? [];
        $next = null;
        $previous = null;

        $totalCount = $response->count ?? 0;
        $pageSize = 20; // Default RAWG page size

        // Calculate pagination based on current page and response
        $next = ($response->next ?? null) ? $page + 1 : null;
        $previous = $page > 1 ? $page - 1 : null;

        $this->setTitle('Desenvolvedores - RAWG API');

        $this->render('developer/index', [
            'developers' => $developers,
            'currentPage' => $page,
            'nextPage' => $next,
            'previousPage' => $previous,
            'totalCount' => $totalCount,
            'pageSize' => $pageSize
        ]);
    }

    /**
     * Display developer details with games.
     * 
     * @param string $id Developer ID
     * @return void
     */
    public function show(string $id): void
    {
        $developerId = (int) $id;

        if ($developerId <= 0) {
            $this->redirect('/developers');
        }

        $developer = $this->api->getDeveloper($developerId);

        if (!$developer) {
            http_response_code(404);
            $this->render('errors/404', ['message' => 'Desenvolvedor não encontrado']);
            return;
        }

        $page = (int) $this->getParam('page', 1);
        $games = $this->api->getGamesByDeveloper($developerId, $page);

        $this->setTitle($developer->name . ' - RAWG API');

        $this->render('developer/show', [
            'developer' => $developer,
            'games' => $games->results ?? [],
            'gamesCount' => $developer->games_count ?? 0
        ]);
    }
}
