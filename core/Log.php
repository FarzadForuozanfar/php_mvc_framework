<?php

namespace app\core;

use app\configs\BaseConfig;

class Log
{
    const INFO_TYPE = 'info';
    const ERROR_TYPE = 'error';
    const WARNING_TYPE = 'warning';

    public static function add(string $message, string $type = self::INFO_TYPE): void
    {
        $filePath = BaseConfig::get('BASE_DIR') . "/logs/" . date('Y-m-d')."_$type.log";
        $logEntry = '['. date('H:i:s') . ']' . " - $message" . PHP_EOL;
        file_put_contents($filePath, $logEntry, FILE_APPEND);
    }

}