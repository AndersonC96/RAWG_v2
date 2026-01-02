<?php

declare(strict_types=1);

/**
 * Simple Router
 * 
 * Handles URL routing to controllers.
 * 
 * @package App\Core
 */

namespace App\Core;

/**
 * Class Router
 * 
 * Simple router for mapping URLs to controller actions.
 */
class Router
{
    /** @var array<string, array<string, mixed>> Route definitions */
    private array $routes = [];

    /** @var string Current base path */
    private string $basePath = '';

    /**
     * Constructor
     * 
     * @param string $basePath Application base path
     */
    public function __construct(string $basePath = '')
    {
        $this->basePath = $basePath;
    }

    /**
     * Add a GET route.
     * 
     * @param string $path URL path
     * @param string $controller Controller class name
     * @param string $action Action method name
     * @return self
     */
    public function get(string $path, string $controller, string $action): self
    {
        $this->routes['GET'][$path] = [
            'controller' => $controller,
            'action' => $action
        ];
        return $this;
    }

    /**
     * Add a POST route.
     * 
     * @param string $path URL path
     * @param string $controller Controller class name
     * @param string $action Action method name
     * @return self
     */
    public function post(string $path, string $controller, string $action): self
    {
        $this->routes['POST'][$path] = [
            'controller' => $controller,
            'action' => $action
        ];
        return $this;
    }

    /**
     * Dispatch the request to the appropriate controller.
     * 
     * @return void
     */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->getUri();

        // Try to match exact route
        if (isset($this->routes[$method][$uri])) {
            $this->executeRoute($this->routes[$method][$uri]);
            return;
        }

        // Try to match dynamic routes
        foreach ($this->routes[$method] ?? [] as $path => $route) {
            $pattern = $this->convertToRegex($path);
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $this->executeRoute($route, $matches);
                return;
            }
        }

        // 404 Not Found
        $this->notFound();
    }

    /**
     * Get the current URI.
     * 
     * @return string
     */
    private function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Remove base path
        if ($this->basePath && str_starts_with($uri, $this->basePath)) {
            $uri = substr($uri, strlen($this->basePath));
        }

        // Remove query string
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        return '/' . trim($uri, '/');
    }

    /**
     * Convert route path to regex pattern.
     * 
     * @param string $path Route path
     * @return string Regex pattern
     */
    private function convertToRegex(string $path): string
    {
        $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    /**
     * Execute a route.
     * 
     * @param array<string, mixed> $route Route configuration
     * @param array<int, string> $params URL parameters
     * @return void
     */
    private function executeRoute(array $route, array $params = []): void
    {
        $controllerClass = $route['controller'];
        $action = $route['action'];

        if (!class_exists($controllerClass)) {
            $this->notFound();
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $action)) {
            $this->notFound();
            return;
        }

        call_user_func_array([$controller, $action], $params);
    }

    /**
     * Handle 404 Not Found.
     * 
     * @return void
     */
    private function notFound(): void
    {
        http_response_code(404);
        require ROOT_PATH . '/src/Views/errors/404.php';
        exit;
    }
}
