<?php

namespace Core;

use Exception;
use PDO;
use PDOException;

class Connection
{
    private static ?Connection $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $config = [
            'host' => config('DB_HOST'),
            'user' => config('DB_USER'),
            'password' => config('DB_PASS'),
            'database' => config('DB_NAME')
        ];
        try {
            $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['database'] . ';charset=utf8';
            $this->connection = new PDO($dsn, $config['user'], $config['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            Log::add('PDO Connection failed: ' . $e->getMessage() . ' configs:' . json_encode($config), Log::ERROR_TYPE);
            throw new Exception('Database connection error');
        }
    }

    public static function getInstance(): Connection
    {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public static function create(): ?PDO
    {
        return self::getInstance()->getConnection();
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public static function query(string $sql, array $params = []): array
    {
        $result = [];
        $conn = self::create();
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Log::add('Query Error: ' . $e->getMessage(), Log::ERROR_TYPE);
        }
        return $result;
    }

    public static function queryFirst(string $sql, array $params = []): ?array
    {
        $conn = self::create();
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row !== false ? $row : null;
        } catch (PDOException $e) {
            Log::add('QueryFirst Error: ' . $e->getMessage(), Log::ERROR_TYPE);
            return null;
        }
    }

    public static function db_insert($attributes, $data, $table): ?array
    {
        $conn = self::create();
        $fields = [];
        $placeholders = [];
        $values = [];
        foreach ($attributes as $attribute) {
            $fields[] = "`$attribute`";
            $placeholders[] = ":$attribute";
            $values[":$attribute"] = $data[$attribute];
        }
        $fieldsStr = implode(", ", $fields);
        $placeholdersStr = implode(", ", $placeholders);
        $sql = "INSERT INTO $table ($fieldsStr) VALUES ($placeholdersStr)";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute($values);
            $lastId = $conn->lastInsertId();
            if ($lastId) {
                return self::db_select($table, "ID=$lastId");
            }
            return self::db_select($table);
        } catch (PDOException $e) {
            Log::add('Insert Error: ' . $e->getMessage(), Log::ERROR_TYPE);
            return null;
        }
    }

    public static function db_select(string $table, ?string $condition = null, $field = '*', $fetchAll = false, $orderBy = 'ID', $orderType = 'DESC'): array|null
    {
        $field = is_array($field) ? implode(', ', $field) : $field;
        $where = $condition ? " WHERE $condition" : '';
        $sql = "SELECT {$field} FROM `$table` $where ORDER BY $orderBy $orderType";
        if (!$fetchAll) {
            $sql .= ' LIMIT 1';
        }
        return $fetchAll ? self::query($sql) : self::queryFirst($sql);
    }
}
