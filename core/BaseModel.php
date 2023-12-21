<?php

namespace Core;

abstract class BaseModel
{
    abstract public static function tableName(): string;
    abstract public function attribute(): array;

    public function create($data): int|string|null
    {
        $tableName = $this->tableName();
        $attributes = $this->attribute();

        return Connection::db_insert($attributes, $data, $tableName);
    }

    public static function find($value, string $field = "ID"): bool|array|null
    {
        return Connection::db_select('users', "$field='$value'");
    }
}