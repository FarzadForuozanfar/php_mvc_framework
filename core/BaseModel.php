<?php

namespace app\core;

abstract class BaseModel
{
    public static function query($sql)
    {

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

    public function validate()
    {
    }
}