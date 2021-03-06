<?php
declare(strict_types=1);

namespace app\core;

class Controller {

    public function render($view, $params = []) {
        return Application::$app->router->renderView(
            $view, $params
        );
    }
}