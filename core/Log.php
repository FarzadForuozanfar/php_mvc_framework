<?php

namespace Core;

class Log
{
    const INFO_TYPE = 'info';
    const ERROR_TYPE = 'error';
    const WARNING_TYPE = 'warning';

    public static function add(string $message, string $type = self::INFO_TYPE): void
    {
        $filePath = config('BASE_DIR') . "/logs/" . date('Y-m-d')."_$type.log";
        $logEntry = '['. date('H:i:s') . ']' . " - $message" . PHP_EOL;
        file_put_contents($filePath, $logEntry, FILE_APPEND);
    }

}