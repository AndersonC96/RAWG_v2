<?php
/**
 * RAWG_v2 Configuration
 * 
 * Centralized configuration file that loads environment variables
 * and provides helper functions used across the application.
 */

// Load environment variables from .env file
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        // Parse KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            // Remove quotes if present
            $value = trim($value, '"\'');
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

// API Configuration
define('RAWG_API_KEY', getenv('RAWG_API_KEY') ?: '');
define('RAWG_BASE_URL', 'https://api.rawg.io/api/');

// Application paths
define('ROOT_PATH', dirname(__DIR__));
define('CONFIG_PATH', __DIR__);
define('VIEWS_PATH', ROOT_PATH . '/pages');
define('COMPONENTS_PATH', ROOT_PATH . '/components');

/**
 * Get the relative path based on current URL
 * Replaces the duplicated path() function across controllers
 * 
 * @return string Relative path to root
 */
function getBasePath(): string {
    $url = explode('/', $_SERVER['REQUEST_URI']);
    $inPages = in_array('pages', $url);
    return $inPages ? '../..' : '.';
}

/**
 * Get the absolute URL for assets
 * 
 * @param string $path Relative path to asset
 * @return string Full path to asset
 */
function asset(string $path): string {
    return getBasePath() . '/' . ltrim($path, '/');
}

/**
 * Safe redirect with proper headers
 * 
 * @param string $location URL to redirect to
 * @return void
 */
function redirect(string $location): void {
    if (!headers_sent()) {
        header("Location: $location");
        exit;
    }
}

/**
 * Display a formatted error message
 * 
 * @param string $message Error message
 * @param int $code HTTP status code
 * @return void
 */
function showError(string $message, int $code = 500): void {
    http_response_code($code);
    $basePath = getBasePath();
    include COMPONENTS_PATH . '/error.php';
    exit;
}

// Verify API key is configured
if (empty(RAWG_API_KEY)) {
    error_log('RAWG API key is not configured. Please check your .env file.');
}
