<?php

use App\controllers\AuthController;
use App\controllers\SiteController;
use Core\Application;
use Core\BaseConfig;

date_default_timezone_set('Asia/Tehran');

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application(BaseConfig::get('BASE_DIR'));

/* Contact Routes */
$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'getContactForm']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);

/* Auth Routes*/
$app->router->get('/register', [AuthController::class, 'showRegisterForm']);
$app->router->get('/login', [AuthController::class, 'showLoginForm']);
$app->router->post('/register', [AuthController::class, 'handleRegister']);
$app->router->post('/login', [AuthController::class, 'handleLogin']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->run();
