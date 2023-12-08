<?php

namespace inserveofgod\controllers;

use inserveofgod\core\Request;

/**
 * class AuthController
 * @package inserveofgod\controllers
 */
class AuthController extends Controller {
    public function login(Request $request) {
        if ($request->isPost()) {
            var_dump($request->getBody());
        }

        return $this->render('auth/login', [
            'auth' => true,
        ]);
    }

    public function register(Request $request) {
        if ($request->isPost()) {
            var_dump($request->getBody());
        }

        return $this->render('auth/register', [
            'auth' => true,
        ]);
    }
}
