<?php

namespace Core;

require_once '../config/database.php';
require_once '../config/app.php';
require_once '../config/ratelimiter.php';
class BaseConfig
{
    private static array $configs;
    public static function setConfigs(): void
    {
        self::$configs = [
            'DB_HOST' => DB_HOST,
            'DB_NAME' => DB_NAME,
            'DB_PASS' => DB_PASS,
            'DB_USER' => DB_USER,
            'APP_NAME'=> APP_NAME,
            'APP_PORT'=> APP_PORT,
            'APP_URL' => APP_URL,
            'BASE_DIR'=> BASE_DIR,
            'TIMEZONE'=> TIMEZONE,
            'DRIVER'=> DRIVER,
            'MAX_ATTEMPTS'=> MAX_ATTEMPTS,
            'DECAY_MINUTES'=> DECAY_MINUTES,
        ];
    }

    public static function get(string $key) : string|null
    {
        if (empty(self::$configs))
            self::setConfigs();

        return self::$configs[$key];
    }
}