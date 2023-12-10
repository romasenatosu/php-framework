<?php declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../errors.log');

use inserveofgod\core\Application;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
    ],
];

$app = new Application(__DIR__, $config);

$app->database->applyMigrations();

