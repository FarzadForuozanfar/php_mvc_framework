<?php

use Core\Application;
use Core\BaseConfig;
use Core\Request;
use Core\Session;

if (!function_exists('bcrypt'))
{
    /**
     * @param $data
     * @return string
     */
    function bcrypt($data): string
    {
        return hash('sha256', uniqid() . md5($data) . time()) . md5(uniqid() . md5($data) . time());
    }
}

if (!function_exists('AuthCheck'))
{
    /**
     * @return bool
     */
    function AuthCheck(): bool
    {
        return Application::AuthCheck();
    }
}

if (!function_exists('getDisplayName'))
{
    /**
     * @return string
     */
    function getDisplayName(): string
    {
        return Application::getDisplayName();
    }
}

if (!function_exists('session'))
{
    /**
     * @return Session
     */
    function session(): Session
    {
        return Application::$app->session;
    }
}

if (!function_exists('view'))
{
    function view(string $view, array $params = []): bool|array|string
    {
        $params['request'] = $params['request'] ?? new Request();
        return Application::$app->router->renderView($view, $params);
    }
}

if (!function_exists('config'))
{
    function config(string $key): ?string
    {
        return BaseConfig::get($key);
    }
}

if (!function_exists('rate_limit'))
{

    function rate_limit(string $key, int $maxAttempts = 5, int $decayMinutes = 1): bool
    {
        $rateLimiter = \Core\RateLimiter::getInstance();
        return $rateLimiter->attempt($key, $maxAttempts, $decayMinutes);
    }
}

