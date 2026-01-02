<?php

declare(strict_types=1);

/**
 * Favorites Controller
 * 
 * Handles favorites page (client-side localStorage).
 * 
 * @package App\Controllers
 */

namespace App\Controllers;

/**
 * Class FavoritesController
 */
class FavoritesController extends BaseController
{
    /**
     * Display favorites page.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->setTitle('Meus Favoritos - RAWG API');

        $this->render('favorites/index');
    }
}
