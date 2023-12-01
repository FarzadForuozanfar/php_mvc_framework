<?php

namespace app\controllers;

use app\core\Application;
use app\core\BaseController;
use app\core\Request;
use app\helpers\Helper;
use app\models\User;
use app\requests\RegisterRequest;

class AuthController extends BaseController
{
    public function showLoginForm(): bool|array|string
    {
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function showRegisterForm(): bool|array|string
    {
        $this->setLayout('auth');
        return $this->render('register');
    }

    public function handleLogin(Request $request)
    {

    }

    public function handleRegister(Request $request): bool|array|string
    {
        $this->setLayout('auth');
        $registerRequest = new RegisterRequest();
        $registerRequest->loadData($request->getBody());

        if ($registerRequest->validate())
        {
            $userId = (new User())->create([
                'firstname' => $registerRequest->firstname,
                'lastname' => $registerRequest->lastname,
                'email' => $registerRequest->email,
                'password' => Helper::bcrypt($registerRequest->password)
            ]);

            if (is_numeric($userId))
            {
                Application::$app->session->setFlash('success', 'Welcome to our site');
                $this->redirect('/');
            }
            else
            {
                echo '<pre>';
                var_dump($userId);
                die('</pre>');
            }

        }

        return $this->render('register', [
            'request' => $registerRequest
        ]);
    }
}