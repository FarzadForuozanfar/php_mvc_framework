<?php

namespace app\core;

class Log
{
    public static function info(string $message): void
    {

        $filePath = Application::$ROOT_DIR . "\\logs\\" . date('Y-m-d')."_info.log";
        $logEntry = '['. date('H:i:s') . ']' . " - $message" . PHP_EOL;
        file_put_contents($filePath, $logEntry, FILE_APPEND);
    }

    public static function error(string $message): void
    {

        $filePath = Application::$ROOT_DIR . "\\logs\\" . date('Y-m-d')."_error.log";
        $logEntry = '['. date('H:i:s') . ']' . " - $message" . PHP_EOL;
        file_put_contents($filePath, $logEntry, FILE_APPEND);
    }

    public static function warning(string $message): void
    {

        $filePath = Application::$ROOT_DIR . "\\logs\\" . date('Y-m-d')."_warning.log";
        $logEntry = '['. date('H:i:s') . ']' . " - $message" . PHP_EOL;
        file_put_contents($filePath, $logEntry, FILE_APPEND);
    }

}