<?php

namespace romasenatosu\src\controllers;

use romasenatosu\core\Request;
use romasenatosu\src\models\User;

/**
 * class AuthController
 * @package romasenatosu\controllers
 */
class AuthController extends Controller {
    public function login(Request $request) {
        if ($request->isGet()) {
            $User = new User();
        }

        if ($request->isPost()) {
            $User->loadData($request->getBody());
            
            if ($User->validate()) {
                $User->create();
                $this->redirect("/");
            }
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
                $User->create();
                $this->addFlash("success", "You are registered");
                $this->redirect("/login");
            }
        }

        return $this->render('auth/register', [
            'user' => $User,
            'auth' => true,
        ]);
    }

    public function logout() {
        $this->removeUser();
        $this->redirect('/register');
    }
}
