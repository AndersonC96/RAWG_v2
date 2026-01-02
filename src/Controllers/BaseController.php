<?php

declare(strict_types=1);

/**
 * Base Controller
 * 
 * Abstract base class for all controllers.
 * 
 * @package App\Controllers
 */

namespace App\Controllers;

use App\Services\RawgApiService;

/**
 * Class BaseController
 * 
 * Provides common functionality for all controllers.
 */
abstract class BaseController
{
    /** @var RawgApiService API service instance */
    protected RawgApiService $api;

    /** @var array<string, mixed> View data */
    protected array $data = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->api = new RawgApiService();
    }

    /**
     * Render a view.
     * 
     * @param string $view View name (e.g., 'home/index')
     * @param array<string, mixed> $data Data to pass to view
     * @return void
     */
    protected function render(string $view, array $data = []): void
    {
        $data = array_merge($this->data, $data);
        extract($data);

        $viewPath = ROOT_PATH . "/src/Views/{$view}.php";
        
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View not found: {$view}");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require ROOT_PATH . '/src/Views/layouts/main.php';
    }

    /**
     * Render a partial view without layout.
     * 
     * @param string $partial Partial view name
     * @param array<string, mixed> $data Data to pass
     * @return void
     */
    protected function renderPartial(string $partial, array $data = []): void
    {
        extract(array_merge($this->data, $data));
        require ROOT_PATH . "/src/Views/{$partial}.php";
    }

    /**
     * Redirect to another URL.
     * 
     * @param string $url URL to redirect to
     * @return never
     */
    protected function redirect(string $url): never
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Return JSON response.
     * 
     * @param mixed $data Data to encode
     * @param int $statusCode HTTP status code
     * @return never
     */
    protected function json(mixed $data, int $statusCode = 200): never
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Get request parameter.
     * 
     * @param string $key Parameter key
     * @param mixed $default Default value
     * @return mixed
     */
    protected function getParam(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $_POST[$key] ?? $default;
    }

    /**
     * Get POST data.
     * 
     * @param string $key Key name
     * @param mixed $default Default value
     * @return mixed
     */
    protected function post(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Set page title.
     * 
     * @param string $title Page title
     * @return void
     */
    protected function setTitle(string $title): void
    {
        $this->data['pageTitle'] = $title;
    }

    /**
     * Set meta description.
     * 
     * @param string $description Meta description
     * @return void
     */
    protected function setDescription(string $description): void
    {
        $this->data['metaDescription'] = $description;
    }
}
