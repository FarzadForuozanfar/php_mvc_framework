<?php

namespace app\core;

abstract class BaseModel
{
    public const RULE_REQUIRED = 'req';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';

    public array $errors = [];

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

    abstract public function rules() : array;

    public function validate(): bool
    {
        foreach ($this->rules() as $attr => $rules)
        {
            $value = $this->{$attr};
            foreach ($rules as $rule)
            {
                $ruleName = '';

                if (is_string($rule)) $ruleName = $rule;
                elseif (is_array($rule)) $ruleName = $rule[0];

                if ($ruleName === self::RULE_REQUIRED AND empty($value))
                {
                    $this->addError($attr, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL AND !filter_var($value, FILTER_VALIDATE_EMAIL))
                {
                    $this->addError($attr, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN AND strlen($value) < $rule['min'])
                {
                    $this->addError($attr, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX AND strlen($value) > $rule['max'])
                {
                    $this->addError($attr, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH AND $value !== $this->{$rule['match']})
                {
                    $this->addError($attr, self::RULE_MATCH, $rule);
                }
            }
        }

        return empty($this->errors);
    }

    public function addError(string $attribute, string $rule, array $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value)
        {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages(): array
    {
        return [
          self::RULE_REQUIRED => 'This field is required',
          self::RULE_EMAIL => 'This field must be valid email address',
          self::RULE_MIN => 'Min length of this field must be {min}',
          self::RULE_MAX => 'Max length of this field must be {max}',
          self::RULE_MATCH => 'This field must be the same as {match}'
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
}