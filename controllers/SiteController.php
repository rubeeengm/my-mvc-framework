<?php
declare(strict_types=1);

namespace app\controllers;

use app\core\Application;
use app\core\Controller;

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

    public function handleContact() {
        return 'Handling submitted data';
    }
}