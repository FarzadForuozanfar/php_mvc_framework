<?php

namespace app\requests;

use app\core\Request;

class LoginRequest extends Request
{
    public string $email;
    public string $password;

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
        ];
    }
}