<?php

namespace Core;

class BaseController
{
    public string $layout = 'main';
    protected function render($view, $params = []): bool|array|string
    {
        $params['request'] = $params['request'] ?? new  Request();
        return Application::$app->router->renderView($view, $params);
    }

    protected function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    protected function redirect(string $path): void
    {
        Application::$app->response->redirect($path);
    }
}