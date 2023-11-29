<?php

namespace app\controllers;

use app\core\BaseController;
use app\core\Request;
use app\models\RegisterModel;

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
        $registerModel = new RegisterModel();
        $registerModel->loadData($request->getBody());

        if ($registerModel->validate() AND $registerModel->register())
        {
            return "Success";
        }

        return $this->render('register', [
            'model' => $registerModel
        ]);
    }
}