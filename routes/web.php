<?php 

use App\controllers\AuthController;
use App\controllers\SiteController;
use Core\Router;

return function (Router $router) {
    $router->get('/', function () {
        $start = microtime(true);
        // sleep(15);
        $end = microtime(true);
        $duration = $end - $start;
        echo "Hello World! This page took {$duration} seconds to load.";

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

    $router->get('/bench', function () {
        for ($i=0;$i<1000;$i++){$x=$i*$i;} ;
        return 'ok';
    });
};