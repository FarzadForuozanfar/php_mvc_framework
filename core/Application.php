<?php

namespace app\core;

use app\Database\Connection;

class Application
{
    public static  string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public BaseController $controller;
    public function __construct($rootPath)
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run(): void
    {
        if (! Connection::create()) die('No DB Connection');

        echo $this->router->resolve();
    }
}