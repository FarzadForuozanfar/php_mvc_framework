<?php

use App\controllers\Api\UserController;
use App\controllers\Api\ReservationController;
use Core\Request;

if (isset($router)) {
    $router->get('/api/ping', function () {
        header('Content-Type: application/json; charset=utf-8');
        return json_encode(['message' => 'pong'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    });

    $router->get('/api/users', [UserController::class, 'index']);

    $router->get('/api/reservations', [ReservationController::class, 'index']);
    $router->post('/api/reservations', [ReservationController::class, 'store']);

    $router->get('/api/reservations/show', function ($request) {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $controller = new ReservationController();
        return $controller->show($request, ['id' => $id]);
    });

    $router->post('/api/reservations/update', function ($request) {
        $body = $request->getBody();
        $id = isset($body['id']) ? (int)$body['id'] : 0;
        $controller = new ReservationController();
        return $controller->update($request, ['id' => $id]);
    });

    $router->post('/api/reservations/delete', function ($request) {
        $body = $request->getBody();
        $id = isset($body['id']) ? (int)$body['id'] : 0;
        $controller = new ReservationController();
        return $controller->destroy($request, ['id' => $id]);
    });
}


