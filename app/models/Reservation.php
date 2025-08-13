<?php

namespace App\models;

use Core\BaseModel;
use Core\Connection;

class Reservation extends BaseModel
{
    private static string $tableName = 'reservations';

    public static function tableName(): string
    {
        return self::$tableName ?? 'reservations';
    }

    public static function attribute(): array
    {
        return ['book_id', 'user_id', 'reservation_date', 'return_date', 'status'];
    }

    public static function all(): array
    {
        return Connection::db_select(self::tableName(), null, '*', true) ?? [];
    }

    public static function updateById(int $id, array $data): ?array
    {
        $table = self::tableName();
        $fields = [];
        $params = [':id' => $id];
        foreach (['book_id','user_id','reservation_date','return_date','status'] as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "`$field` = :$field";
                $params[":$field"] = $data[$field];
            }
        }
        if (empty($fields)) {
            return Connection::db_select($table, "ID=$id");
        }
        $set = implode(', ', $fields);
        $sql = "UPDATE `$table` SET $set WHERE `ID` = :id";
        Connection::query($sql, $params);
        return Connection::db_select($table, "ID=$id");
    }

    public static function deleteById(int $id): bool
    {
        $table = self::tableName();
        $sql = "DELETE FROM `$table` WHERE `ID` = :id";
        Connection::query($sql, [':id' => $id]);
        return true;
    }
}


