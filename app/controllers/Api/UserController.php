<?php

namespace App\controllers\Api;

use Core\ApiController;
use Core\Request;
use Core\Connection;

class UserController extends ApiController
{
    public function index(Request $request): string
    {
        $users = Connection::db_select('users', null, '*', true, 'ID', 'DESC') ?? [];
        return $this->json([
            'data' => $users,
        ], 200);
    }
}


