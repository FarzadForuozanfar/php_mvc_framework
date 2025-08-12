<?php

use App\controllers\Api\UserController;

if (isset($router)) {
    $router->get('/api/ping', function () {
        header('Content-Type: application/json; charset=utf-8');
        return json_encode(['message' => 'pong'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    });

    $router->get('/api/users', [UserController::class, 'index']);
}


