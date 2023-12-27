<?php

namespace Core;

use Exception;
use mysqli;

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
                Log::add($error, Log::ERROR_TYPE);
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
            Log::add($errorMessage, Log::ERROR_TYPE);
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
            Log::add($errorMessage, Log::ERROR_TYPE);
        }
    }

    public static function query(string $sql): array
    {
        $result = [];
        $conn   = self::create();

        try {
            $stmt = $conn->query($sql);
            while (@$row = mysqli_fetch_array($stmt, MYSQLI_ASSOC))
            {
                $result[] = $row;
            }
        }
        catch (Exception $exception)
        {
            $errorMessage = "Error: {$exception->getMessage()}, Line: {$exception->getLine()}";
            Log::add($errorMessage, Log::ERROR_TYPE);
        }
        return $result;
    }

    public static function queryFirst(string $sql): bool|array|null
    {
        $conn = self::create();
        return $conn->query($sql)->fetch_assoc();
    }

    public static function db_insert($attributes, $data, $table): array|null
    {
        $conn = self::create();
        $sql  = "INSERT INTO $table SET ";
        foreach($attributes as $attribute)
        {
            $sql .= "`{$attribute}` = '{$data[$attribute]}', ";
        }

        $sql = rtrim($sql, ", ");

        try {
            $result = $conn->query($sql);
            if ($result)
            {
                if ($conn->insert_id != 0)
                    return self::db_select($table, "ID={$conn->insert_id}");

                return self::db_select($table);

            }

            Log::add("Error Query: `$sql`", Log::ERROR_TYPE);
        }
        catch (Exception $exception)
        {
            Log::add($exception->getMessage(), Log::ERROR_TYPE);
        }

        return null;
    }

    public static function db_select(string $table, string $condition = null, $field = '*', $fetchAll = false, $orderBy = 'ID', $orderType = 'DESC'): bool|array|null
    {
        $field = is_array($field) ? implode(', ', $field) : $field;
        $where = $condition ? " WHERE $condition" : '';
        $sql   = "SELECT {$field} FROM `$table` $where";
        $sql  .= " ORDER BY $orderBy $orderType";
        $sql  .= $fetchAll ? ';' : ' LIMIT 1;';

        return $fetchAll ? self::query($sql) : self::queryFirst($sql);
    }
}
