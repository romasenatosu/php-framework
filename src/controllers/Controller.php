<?php

namespace romasenatosu\src\controllers;

use romasenatosu\core\Application;

/**
 * class Controller
 * @package romasenatosu\controllers
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

    /**
     * An alias function for redirecting
     * 
     * @param string route
     * @param string redirect_method
     * @return void
     */
    public function redirect(string $route, string $redirect_method="HTTP/1.1 302 Redirected"):void {
        header($redirect_method);
        header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $route);
        exit(0);
    }

    /**
     * An alias function for adding flash in Session
     * 
     * @param string type
     * @param string message
     * @return void
     */
    public function addFlash(string $type, string $message):void {
        Application::$app->session->addFlash($type, $message);
    }

    /**
     * An alias function for logout in Session
     * 
     * @return void
     */
    public function removeUser():void {
        Application::$app->session->removeUser();
    }

    /**
     * An alias function for getting user info in Session
     * 
     * @return void
     */
    public function removeUser():void {
        Application::$app->session->removeUser();
    }
}
