<?php
declare(strict_types=1);

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class AuthController extends Controller {

    public function login(Request $request) {
        $this->setLayout('auth');

        return $this->render('login');
    }

    public function register(Request $request) {
        if ($request->isPost()) {
            return 'Handle submitted data';
        }

        $this->setLayout('auth');

        return $this->render('register');
    }
}