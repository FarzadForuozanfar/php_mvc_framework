<?php

namespace App\models;

use Core\Application;
use Core\BaseModel;

class User extends BaseModel
{
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $password;
    public string $confirmPassword;

    public static function tableName(): string
    {
        return 'users';
    }

    public static function login(array $data): bool
    {
        $user = self::find($data['email'], 'email');

        if (is_array($user) AND password_verify($data['password'], $user['password']))
        {
            Application::$app->session->set('user', $user);
            return true;
        }

        return false;
    }

    public static function logOut(): void
    {
        Application::$app->user = [];
        Application::$app->session->remove('user');
    }

    public function attribute(): array
    {
        return ['firstname', 'lastname', 'email', 'password'];
    }
}