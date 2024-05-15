<?php declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../errors.log');

use romasenatosu\src\controllers\AuthController;
use romasenatosu\core\Application;
use romasenatosu\src\controllers\HomeController;

require_once __DIR__ . '/../vendor/autoload.php';

$rootPath = dirname(__DIR__);

$dotenv = Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
    ],
];

$app = new Application($rootPath, $config);

$app->router->get('/', [HomeController::class, 'index']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->run();
