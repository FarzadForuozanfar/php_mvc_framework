<?php

namespace App\controllers;

use Core\Application;
use Core\BaseController;
use Core\Request;
use App\models\User;
use App\requests\LoginRequest;
use App\requests\RegisterRequest;
use Core\RateLimiter;

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
        if (!rate_limit('login:' . $_SERVER['REMOTE_ADDR'], 2, 1)) {
            echo "زیادی تلاش کردی، یه دقیقه صبر کن.";
            exit;
        }
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
        if (!rate_limit('register:' . $_SERVER['REMOTE_ADDR'], 90, 1)) {
            echo "زیادی تلاش کردی، یه دقیقه صبر کن.";
            exit;
        }
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
                session()->setFlash('error', 'Registration failed. Please try again later.');
            }
        } else {
            $firstError = '';
            foreach ($registerRequest->errors as $fieldErrors) {
                if (!empty($fieldErrors)) {
                    $firstError = $fieldErrors[0];
                    break;
                }
            }
            if ($firstError) {
                session()->setFlash('error', $firstError);
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