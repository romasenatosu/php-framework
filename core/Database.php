<?php

namespace romasenatosu\core;

use PDO;

/**
 * class Database
 * @package romasenatosu\core
 */
class Database {
    public PDO $pdo;

    /**
     * @param array config
     */
    function __construct(array $config) {
        $dsn = $config['dsn'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * Migrates tables and data
     * 
     * @return void
     */
    public function applyMigrations():void {
        $this->createMigrationsTable();
        $applied_migrations = $this->getAppliedMigrations();

        $migration_files = scandir(Application::$ROOT_DIR . '/migrations');
        $migrate_files = array_diff($migration_files, $applied_migrations);
        $migrations = [];

        foreach ($migrate_files as $file) {
            $source = Application::$ROOT_DIR . '/migrations/' . $file;

            if (is_file($source)) {
                require_once $source;
                
                $classname = pathinfo($file, PATHINFO_FILENAME);
                $class = new $classname();

                echo "Migrating $file" . PHP_EOL;
                $class->up();
                echo "Migrated $file" . PHP_EOL;

                $migrations[] = $file;
            }
        }

        if (!empty($migrations)) {
            $this->saveAppliedMigrations($migrations);
        } else {
            echo "No migrations to apply." . PHP_EOL;
        }
    }

    /**
     * Creates 'migrations' table in database if it wasn't created before
     * 
     * @return void
     */
    public function createMigrationsTable():void {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS `migrations` (
                `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
                `migration` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP 
            ) ENGINE=INNODB;
        ");
    }

    /**
     * Gets the applied migrations from database
     * 
     * @return array
     */
    public function getAppliedMigrations():array {
        $stmt = $this->pdo->prepare("SELECT `migration` FROM `migrations`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Creates record for the applied migrations
     * 
     * @param array migrations
     * @return void
     */
    public function saveAppliedMigrations(array $migrations):void {
        $stmt_migrations = implode(",", array_map(fn($migration) => "('$migration')", $migrations));
        $stmt = $this->pdo->prepare("INSERT INTO `migrations` (`migration`) VALUES $stmt_migrations");
        $stmt->execute();
    }
}
