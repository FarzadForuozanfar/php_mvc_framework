<?php

namespace app\core;

class BaseController
{
    public string $layout = 'main';
    protected function render($view, $params = []): bool|array|string
    {
        return Application::$app->router->renderView($view, $params);
    }

    protected function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }
}