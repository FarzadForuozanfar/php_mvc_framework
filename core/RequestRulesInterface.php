<?php

namespace app\core;

interface RequestRulesInterface
{
    public const RULE_REQUIRED = 'req';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public function rules() : array;
}