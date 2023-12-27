<?php

namespace App\models;

use Core\Application;
use Core\BaseModel;

class User extends BaseModel
{
    private static string $tableName = 'users';
    public static function tableName(): string
    {
        return self::$tableName ?? 'users';
    }

    public static function login(array $data): bool
    {
        $user = self::find($data['email'], 'email');

        if (is_array($user) AND password_verify($data['password'], $user['password']))
        {
            session()->set('user', $user);
            return true;
        }

        return false;
    }

    public static function logOut(): void
    {
        Application::$app->user = [];
        session()->remove('user');
    }

    public function attribute(): array
    {
        return ['firstname', 'lastname', 'email', 'password'];
    }
}