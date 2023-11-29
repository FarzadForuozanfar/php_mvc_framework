<?php

namespace app\models;

use app\core\BaseModel;

class RegisterModel extends BaseModel
{
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $password;
    public string $passwordConfirm;

    public function register()
    {
        echo "creting new user";
    }
}