<?php

use Core\Application;
use Core\BaseConfig;
use Core\Request;
use Core\Session;

if (!function_exists('bcrypt')) {
    /**
     * @param $data
     * @return string
     */
    function bcrypt($data): string
    {
        return hash('sha256', uniqid() . md5($data) . time()) . md5(uniqid() . md5($data) . time());
    }
}

if (!function_exists('AuthCheck')) {
    /**
     * @return bool
     */
    function AuthCheck(): bool
    {
        return Application::AuthCheck();
    }
}

if (!function_exists('getDisplayName')) {
    /**
     * @return string
     */
    function getDisplayName(): string
    {
        return Application::getDisplayName();
    }
}

if (!function_exists('session')) {
    /**
     * @return Session
     */
    function session(): Session
    {
        return Application::$app->session;
    }
}

if (!function_exists('view')) {
    function view(string $view, array $params = []): bool|array|string
    {
        $params['request'] = $params['request'] ?? new Request();
        return Application::$app->router->renderView($view, $params);
    }
}

if (!function_exists('config')) {
    function config(string $key): ?string
    {
        return BaseConfig::get($key);
    }
}

/**
 * Dumps a variable and ends execution.
 *
 * This function dumps a variable using var_dump() wrapped in <pre> tags
 * for better readability, and then exits the script.
 *
 * @param mixed $var The variable to dump
 */
function dd($var)
{
    // Dump the variable and exit
    echo '<pre>';
    var_dump($var);
    exit;
}

/**
 * Retrieves the value of an environment variable.
 *
 * This function retrieves the value of the specified environment variable.
 *
 * @param string $name The name of the environment variable
 * @return mixed The value of the environment variable
 */
function env($name)
{
    return $_ENV[$name];
}
