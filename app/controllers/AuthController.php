<?php

namespace App\controllers;

use Core\Application;
use Core\BaseController;
use Core\Request;
use App\models\User;
use App\requests\LoginRequest;
use App\requests\RegisterRequest;

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

    public function handleLogin(Request $request): bool|array|string
    {
        $this->setLayout('auth');
        $loginRequest = new LoginRequest();
        $loginRequest->loadData($request->getBody());

        if ($loginRequest->validate())
        {
            if (User::login(['email' => $loginRequest->email, 'password' => $loginRequest->password]))
            {
                session_regenerate_id(true);
                $this->redirect('/');
                return true;
            }
            else
            {
                $loginRequest->addError('email', 'The information are not correct');
            }
        }

        return $this->render('login', [
            'request' => $loginRequest
        ]);
    }

    public function handleRegister(Request $request): bool|array|string
    {
        $this->setLayout('auth');
        $registerRequest = new RegisterRequest();
        $registerRequest->loadData($request->getBody());

        if ($registerRequest->validate())
        {
            $user = User::create([
                'firstname' => $registerRequest->firstname,
                'lastname'  => $registerRequest->lastname,
                'email'     => $registerRequest->email,
                'password'  => password_hash($registerRequest->password, PASSWORD_DEFAULT)
            ]);

            if (is_array($user))
            {
            session_regenerate_id(true);
                session()->set('user', $user);
                session()->setFlash('success', 'Welcome to our site');
                $this->redirect('/');
            }
            else
            {
                // TODO Handle Error
            }

        }

        return $this->render('register', [
            'request' => $registerRequest
        ]);
    }

    public function logout(Request $request): void
    {
        User::logOut();
        $this->redirect('/');
    }
}