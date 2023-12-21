<?php

namespace Core;

class Response
{
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect($path): void
    {
        header("Location: $path");
    }
}