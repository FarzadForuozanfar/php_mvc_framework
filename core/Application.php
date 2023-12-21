<?php

namespace Core;

class Application
{
    public static  string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public static Application $app;
    public BaseController $controller;
    public array $user = [];
    public function __construct($rootPath)
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;

        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $userInfo = $this->session->get('user');
        if ($userInfo)
        {
            $this->user = $userInfo;
        }
    }

    public static function AuthCheck(): bool
    {
        return !is_null(Application::$app->user) AND is_array(Application::$app->user);
    }

    public static function getDisplayName(): string
    {
        return self::$app->user ? self::$app->user['firstname'] . ' ' . self::$app->user['lastname'] : 'Guest';
    }

    public function run(): void
    {
        if (! Connection::create()) die('No DB Connection');

        echo $this->router->resolve();
    }
}