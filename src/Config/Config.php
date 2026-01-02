<?php

declare(strict_types=1);

/**
 * Application Configuration
 * 
 * Loads environment variables and defines application constants.
 * 
 * @package App\Config
 */

namespace App\Config;

/**
 * Class Config
 * 
 * Handles application configuration and environment variables.
 */
class Config
{
    /** @var array<string, mixed> Configuration cache */
    private static array $config = [];

    /**
     * Initialize configuration by loading environment variables.
     * 
     * @return void
     */
    public static function init(): void
    {
        self::loadEnv();
        self::defineConstants();
    }

    /**
     * Load environment variables from .env file.
     * 
     * @return void
     */
    private static function loadEnv(): void
    {
        $envPath = dirname(__DIR__, 2) . '/.env';
        
        if (!file_exists($envPath)) {
            return;
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim(trim($value), '"\'');
                
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
                self::$config[$key] = $value;
            }
        }
    }

    /**
     * Define application constants.
     * 
     * @return void
     */
    private static function defineConstants(): void
    {
        if (!defined('ROOT_PATH')) {
            define('ROOT_PATH', dirname(__DIR__, 2));
        }
        
        if (!defined('APP_PATH')) {
            define('APP_PATH', dirname(__DIR__));
        }
    }

    /**
     * Get a configuration value.
     * 
     * @param string $key Configuration key
     * @param mixed $default Default value if key not found
     * @return mixed Configuration value
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return self::$config[$key] ?? getenv($key) ?: $default;
    }

    /**
     * Get RAWG API key.
     * 
     * @return string API key
     */
    public static function getApiKey(): string
    {
        return self::get('RAWG_API_KEY', '');
    }

    /**
     * Get RAWG API base URL.
     * 
     * @return string Base URL
     */
    public static function getApiBaseUrl(): string
    {
        return 'https://api.rawg.io/api/';
    }

    /**
     * Check if application is in debug mode.
     * 
     * @return bool
     */
    public static function isDebug(): bool
    {
        return self::get('APP_DEBUG', 'false') === 'true';
    }
}
