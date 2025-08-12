<?php

namespace Core;

class Request implements RequestRulesInterface
{
    public array $errors = [];
    public function rules(): array
    {
        return [];
    }
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        if (!$position) return $path;

        return substr($path, 0, $position);
    }

    public function Method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody(): array
{
    $body = [];

    if ($this->isGet()) {
        foreach ($_GET as $key => $value) {
            $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
    } elseif ($this->isPost()) {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (stripos($contentType, 'application/json') !== false) {
            $rawBody = file_get_contents('php://input');
            $data = json_decode($rawBody, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                foreach ($data as $key => $value) {
                    if (is_string($value)) {
                        $body[$key] = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    } else {
                        $body[$key] = $value;
                    }
                }
            }
        } else {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
    }

    return $body;
}


    public function isGet(): bool
    {
        return $this->Method() === 'get';
    }

    public function isPost(): bool
    {
        return $this->Method() === 'post';
    }

    public function loadData($data): void
    {
        foreach ($data as $key => $value)
        {
            if (property_exists($this, $key))
            {
                $this->{$key} = $value;
            }
        }
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attr => $rules)
        {
            $value = $this->{$attr};
            foreach ($rules as $rule) {
                $ruleName = '';

                if (is_string($rule)) $ruleName = $rule;
                elseif (is_array($rule)) $ruleName = $rule[0];

                if ($ruleName === self::RULE_REQUIRED and empty($value)) {
                    $this->addErrorForRule($attr, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL and !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attr, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN and strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attr, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX and strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attr, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH and $value !== $this->{$rule['match']}) {
                    $this->addErrorForRule($attr, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE)
                {
                    $className = $rule['class'];
                    $tableName = $className::tableName();
                    $sql = "SELECT * FROM `$tableName` WHERE `$attr` = :value LIMIT 1";
                    $record = \Core\Connection::queryFirst($sql, [':value' => $value]);
                    if (is_array($record))
                    {
                        $this->addErrorForRule($attr, self::RULE_UNIQUE, ['field' => $attr]);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, array $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value)
        {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message): void
    {
        $this->errors[$attribute][] = $message;
    }
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists'
        ];
    }

    public function hasError($attribute): bool
    {
        return isset($this->errors[$attribute]);
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? '';
    }

    public function old($attribute)
    {
        return $this->{$attribute} ?? '';
    }
}

