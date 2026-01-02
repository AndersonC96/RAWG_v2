<?php

declare(strict_types=1);

/**
 * Publisher Controller
 * 
 * Handles publisher listings and details.
 * 
 * @package App\Controllers
 */

namespace App\Controllers;

/**
 * Class PublisherController
 */
class PublisherController extends BaseController
{
    /**
     * Display publishers list.
     * 
     * @return void
     */
    public function index(): void
    {
        $page = (int) $this->getParam('page', 1);
        $page = max(1, $page);

        $response = $this->api->getPublishers($page);
        $publishers = $response->results ?? [];
        $totalCount = $response->count ?? 0;
        $hasNextPage = !empty($response->next);
        $hasPrevPage = $page > 1;

        $this->setTitle('Publishers - RAWG API');

        $this->render('publisher/index', [
            'publishers' => $publishers,
            'currentPage' => $page,
            'totalCount' => $totalCount,
            'hasNextPage' => $hasNextPage,
            'hasPrevPage' => $hasPrevPage,
            'pageSize' => 20
        ]);
    }

    /**
     * Display publisher details with games.
     * 
     * @param string $id Publisher ID
     * @return void
     */
    public function show(string $id): void
    {
        $publisherId = (int) $id;

        if ($publisherId <= 0) {
            $this->redirect('/publishers');
        }

        $publisher = $this->api->getPublisher($publisherId);

        if (!$publisher) {
            http_response_code(404);
            $this->render('errors/404', ['message' => 'Publisher não encontrado']);
            return;
        }

        $this->setTitle($publisher->name . ' - RAWG API');

        $this->render('publisher/show', [
            'publisher' => $publisher,
            'gamesCount' => $publisher->games_count ?? 0
        ]);
    }
}
