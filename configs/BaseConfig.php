<?php

namespace app\configs;

require_once 'database.php';
require_once 'app.php';
class BaseConfig
{
    private static array $configs;
    public static function getConfigs(): array
    {
        self::$configs = [
            'DB_HOST' => DB_HOST,
            'DB_NAME' => DB_NAME,
            'DB_PASS' => DB_PASS,
            'DB_USER' => DB_USER,
            'APP_NAME'=> APP_NAME,
            'APP_PORT'=> APP_PORT,
            'APP_URL' => APP_URL,
            'BASE_DIR'=> BASE_DIR
        ];

        return self::$configs;
    }

    public static function get($key) : string|null
    {
        return self::getConfigs()[$key];
    }
}