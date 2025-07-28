<?php

namespace Core;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public static Application $app;
    public BaseController $controller;
    public array $user = [];
    public function __construct()
    {
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->setSecurityHeaders();

        $userInfo = $this->session->get('user');
        if ($userInfo)
        {
            $this->user = $userInfo;
        }
    }
    private function setSecurityHeaders(): void
    {
        header('X-XSS-Protection: 1; mode=block');
        
        header('X-Content-Type-Options: nosniff');
        
        header('X-Frame-Options: DENY');
        
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; img-src 'self' data: https:; font-src 'self' https://cdn.jsdelivr.net;");
    }

    public static function AuthCheck(): bool
    {
        return !empty(Application::$app->user) AND is_array(Application::$app->user);
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