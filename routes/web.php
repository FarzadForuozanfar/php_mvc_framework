<?php 

use App\controllers\AuthController;
use App\controllers\SiteController;
use Core\Router;

return function (Router $router) {
    $router->get('/', function () {
        return view('home');
    });

    $router->get('users', 'users');
    $router->get('/contact', [SiteController::class, 'getContactForm']);
    $router->post('/contact', [SiteController::class, 'handleContact']);

    $router->get('/register', [AuthController::class, 'showRegisterForm']);
    $router->get('/login', [AuthController::class, 'showLoginForm']);
    $router->post('/register', [AuthController::class, 'handleRegister']);
    $router->post('/login', [AuthController::class, 'handleLogin']);
    $router->get('/logout', [AuthController::class, 'logout']);
};