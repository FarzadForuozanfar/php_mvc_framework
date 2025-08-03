<?php

namespace Core;

require_once '../config/database.php';
require_once '../config/app.php';
require_once '../config/ratelimiter.php';
require_once '../config/redis.php';
require_once '../config/SecurityHeader.php';
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
            'RATE_LIMITER_DRIVER'=> DRIVER,
            'RATE_LIMITER_MAX_ATTEMPTS'=> MAX_ATTEMPTS,
            'RATE_LIMITER_DECAY_MINUTES'=> DECAY_MINUTES,
            'REDIS_HOST'=> REDIS_HOST,
            'REDIS_PORT'=> REDIS_PORT,
            'X_XSS_Protection' => X_XSS_Protection,
            'X_Content_Type_Options' => X_Content_Type_Options,
            'X_Frame_Options' => X_Frame_Options,
            'Referrer_Policy' => Referrer_Policy,
            'Content_Security_Policy' => Content_Security_Policy

        ];
    }

    public static function get(string $key) : string|null
    {
        if (empty(self::$configs))
            self::setConfigs();

        return self::$configs[$key];
    }
}