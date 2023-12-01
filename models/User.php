<?php

namespace app\models;

use app\core\BaseModel;

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

    public function attribute(): array
    {
        return ['firstname', 'lastname', 'email', 'password'];
    }
}