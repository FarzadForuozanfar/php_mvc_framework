<?php

use App\controllers\AuthController;
use App\controllers\SiteController;
use Core\Application;

require_once __DIR__ . '/../vendor/autoload.php';

// Create a new instance of Dotenv with immutable settings, specifying the directory containing the .env file.
$dotenv = Dotenv\Dotenv::createImmutable("../");

// Load the environment variables from the .env file into the application.
$dotenv->load();

// Check if the environment variable "APP_DEBUG" is set to true and strictly compare its value.
if (env("APP_DEBUG") === true) {
    // If "APP_DEBUG" is true, enable displaying of errors on the screen.
    ini_set('display_errors', 'on');

    // Set error reporting to display all types of errors for better debugging.
    error_reporting(E_ALL);
}

date_default_timezone_set(config('TIMEZONE'));

$app = new Application();

$app->router->get('/', function () {
    return view('home');
});

$app->router->get('users', 'users');

/* Contact Routes */
$app->router->get('/contact', [SiteController::class, 'getContactForm']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);

/* Auth Routes*/
$app->router->get('/register', [AuthController::class, 'showRegisterForm']);
$app->router->get('/login', [AuthController::class, 'showLoginForm']);
$app->router->post('/register', [AuthController::class, 'handleRegister']);
$app->router->post('/login', [AuthController::class, 'handleLogin']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->run();
