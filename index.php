<?php

declare(strict_types=1);

/**
 * RAWG_v2 - Application Entry Point
 * 
 * Front controller that handles all incoming requests.
 * 
 * @package RAWG_v2
 */

// Error handling for development
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// Define root path
define('ROOT_PATH', __DIR__);

// Autoload classes (simple implementation - no Composer vendor)
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = ROOT_PATH . '/src/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Initialize configuration
use App\Config\Config;
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\GameController;
use App\Controllers\SearchController;
use App\Controllers\GenreController;
use App\Controllers\FavoritesController;

Config::init();

// Create router
$router = new Router('/RAWG_v2');

// Define routes
$router->get('/', HomeController::class, 'index');
$router->get('/game/{id}', GameController::class, 'show');
$router->get('/search', SearchController::class, 'index');
$router->post('/search', SearchController::class, 'index');
$router->get('/genres', GenreController::class, 'index');
$router->get('/favorites', FavoritesController::class, 'index');

// Dispatch request
$router->dispatch();