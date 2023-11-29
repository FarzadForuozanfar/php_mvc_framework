<?php

namespace app\Database;

use app\core\Log;
use Exception;
use mysqli;
use app\configs\BaseConfig;

class Connection
{
    /* @var mysqli */
    private static mysqli $connection;

    private function __construct()
    {
    }

    /**
     * @return false|mysqli|null
     */
    public static function create(): bool|mysqli|null
    {
        if (self::isConnected())
            return self::$connection;
        else
            return self::connect();
    }

    /**
     * @return false|mysqli
     */
    private static function connect(): bool|mysqli
    {
        try {
            $mysqli = mysqli_init();

            mysqli_options($mysqli, MYSQLI_OPT_CONNECT_TIMEOUT, 5);
            mysqli_options($mysqli, MYSQLI_OPT_READ_TIMEOUT, 5);
            mysqli_options($mysqli, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);

            $mysqli->real_connect( BaseConfig::get('DB_HOST'), BaseConfig::get('DB_USER'), BaseConfig::get('DB_PASS'), BaseConfig::get('DB_NAME'));

            if ($mysqli->connect_errno) {
                $error = 'Failed to connect to MySQL: ' . $mysqli->connect_error . ', ' . mysqli_error($mysqli);
                Log::error($error);
            }
            else
            {
                self::$connection =  $mysqli;
            }

            return self::$connection;
        }
        catch (Exception $exception)
        {
            $errorMessage = "Error: {$exception->getMessage()}, Line: {$exception->getLine()}, File: {$exception->getFile()}, DB Params:" .
                            print_r([
                                BaseConfig::get('DB_HOST'), BaseConfig::get('DB_USER'), BaseConfig::get('DB_PASS'), BaseConfig::get('DB_NAME')
                            ], true);
            Log::error($errorMessage);
            return false;
        }
    }

    /**
     * @return bool
     */
    public static function isConnected(): bool
    {
        if (!empty(self::$connection) AND self::$connection->ping())
        {
            return true;
        }
        return false;
    }

    /**
     * @return void
     */
    public static function reConnect(): void
    {
        $conn = [];
        try {
            if (self::isConnected())
            {
                self::$connection->close();
            }
            $conn = self::connect();
        }
        catch (Exception $exception)
        {
            $errorMessage = "Error: {$exception->getMessage()}, Line: {$exception->getLine()}";
            Log::error($errorMessage);
        }
    }

    public static function query(string $sql): array
    {
        $i = 0;
        $result = [];
        $conn = !self::$connection ? self::create() : self::$connection;

        try {
            $stmt = $conn->query($sql);
            while (@$row = mysqli_fetch_array($stmt, MYSQLI_ASSOC))
            {
                $result[$i] = $row;
                $i++;
            }
        }
        catch (Exception $exception)
        {
            $errorMessage = "Error: {$exception->getMessage()}, Line: {$exception->getLine()}";
            Log::error($errorMessage);
        }
        return $result;
    }
}
