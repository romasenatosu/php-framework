<?php

namespace inserveofgod\src\controllers;

use inserveofgod\core\Request;
use inserveofgod\src\models\User;

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
        $User = new User();

        if ($request->isPost()) {
            $User->loadData($request->getBody());

            if ($User->validate()) {
                return "success. Redirecting...";
            }
        }

        return $this->render('auth/register', [
            'user' => $User,
            'auth' => true,
        ]);
    }
}
