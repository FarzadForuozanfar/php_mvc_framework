<?php

namespace Core;

abstract class BaseModel
{
    abstract public static function tableName(): string;
    abstract public static function attribute(): array;

    public static function create($data): array|null
    {
        $tableName  = static::tableName();
        $attributes = static::attribute();
        return Connection::db_insert($attributes, $data, $tableName);
    }

    public static function find($value, string $field = "ID"): array|null
    {
        // Use parameterized query for security
        $table = static::tableName();
        $sql = "SELECT * FROM `$table` WHERE `$field` = :value LIMIT 1";
        $result = Connection::queryFirst($sql, [':value' => $value]);
        return $result;
    }
}