<?php
declare(strict_types=1);

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class SiteController extends Controller {

    public function home() {
        $params = [
            'name' => "The Codeholic"
        ];

        return $this->render('home', $params);
    }

    public function contact() {
        return $this->render('contact');
    }

    public function handleContact(Request $request) {
        $body = $request->getBody();

        return 'Handling submitted data';
    }
}