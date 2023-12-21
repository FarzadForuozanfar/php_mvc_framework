<?php

use Core\Application;
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

