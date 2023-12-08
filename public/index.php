<?php declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../errors.log');

require_once __DIR__ . '/../vendor/autoload.php';

use inserveofgod\controllers\AuthController;
use inserveofgod\core\Application;
use inserveofgod\controllers\HomeController;

$app = new Application(dirname(__DIR__));

$app->router->get('/', [HomeController::class, 'index']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->run();
