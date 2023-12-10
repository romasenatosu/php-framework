<?php

use inserveofgod\core\Application;

/**
 * class m0001
 * 
 * @package inserveofgod\core\Application
 */
class m0001 {
    function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `fullname` VARCHAR(64) NOT NULL,
            `username` VARCHAR(32) NOT NULL UNIQUE KEY,
            `email` VARCHAR(255) NOT NULL UNIQUE KEY,
            `password` VARCHAR(255) NOT NULL,
            `is_admin` TINYINT(1) DEFAULT 0 NOT NULL,
            `created_at` TIMESTAMP NOT NULL,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            `deleted_at` TIMESTAMP DEFAULT NULL
        ) ENGINE=INNODB";

        Application::$app->database->pdo->exec($sql);
    }
    
    function down() {
        Application::$app->database->pdo->exec("DROP TABLE `users`");
    }
}
