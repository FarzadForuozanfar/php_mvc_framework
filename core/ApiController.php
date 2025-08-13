<?php

namespace Core;

class ApiController extends BaseController
{
    protected function json(mixed $data, int $status = 200, array $headers = []): string
    {
        Application::$app->response->setStatusCode($status);
        header('Content-Type: application/json; charset=utf-8');
        foreach ($headers as $name => $value) {
            header($name . ': ' . $value);
        }

        $encoded = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($encoded === false) {
            Application::$app->response->setStatusCode(500);
            $encoded = json_encode([
                'error' => 'Failed to encode response'
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return $encoded;
    }
}


