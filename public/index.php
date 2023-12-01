<?php

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;
use app\configs\BaseConfig;

date_default_timezone_set('Asia/Tehran');

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application(BaseConfig::get('BASE_DIR'));

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'getContactForm']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);

$app->router->get('/register', [AuthController::class, 'showRegisterForm']);
$app->router->get('/login', [AuthController::class, 'showLoginForm']);
$app->router->post('/register', [AuthController::class, 'handleRegister']);
$app->router->post('/login', [AuthController::class, 'handleLogin']);
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->run();