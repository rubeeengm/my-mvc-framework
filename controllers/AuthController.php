<?php
declare(strict_types=1);

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\UserModel;

class AuthController extends Controller {

    public function login(Request $request) {
        $this->setLayout('auth');

        return $this->render('login');
    }

    public function register(Request $request) {
        $userModel = new UserModel();

        if ($request->isPost()) {
            $userModel->loadData($request->getBody());

            if ($userModel->validate() && $userModel->save()) {
                Application::$app->response->redirect('/');
            }

            return $this->render('register', [
                'model' => $userModel
            ]);
        }

        $this->setLayout('auth');

        return $this->render('register', [
            'model' => $userModel
        ]);
    }
}