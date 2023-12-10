<?php

namespace inserveofgod\src\controllers;

use inserveofgod\core\Application;

/**
 * class Controller
 * @package inserveofgod\controllers
 */
abstract class Controller {
    /**
     * An alias function for render in Router
     * 
     * @param string route
     * @param array params
     * @return string
     */
    public function render(string $route, array $params = []):string {
        return Application::$app->router->render($route, $params);
    }
}
