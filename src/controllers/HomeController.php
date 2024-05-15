<?php

namespace romasenatosu\src\controllers;

/**
 * class HomeController
 * @package romasenatosu\controllers
 */
class HomeController extends Controller {
    public function index() {
        return $this->render('home/index', [
            'name' => 'maho',
        ]);
    }
}
