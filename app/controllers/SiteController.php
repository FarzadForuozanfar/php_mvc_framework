<?php

namespace App\controllers;

use Core\BaseController;
use Core\Request;

class SiteController extends BaseController
{
    public function home(): bool|array|string
    {
        $param = ['name' => 'farzad'];
        return $this->render('home', $param);
    }
    public function getContactForm(): bool|array|string
    {
        return $this->render('contact');
    }

    public function handleContact(Request $request)
    {
        echo '<pre>';
        var_dump($request->getBody());
        die('</pre>');
    }
}