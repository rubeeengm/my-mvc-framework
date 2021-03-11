<?php
declare(strict_types=1);

namespace app\core;

use PDO;

class Database {
    public PDO $pdo;

    /**
     * Database constructor.
     * @param array $config
     */
    public function __construct(array $config) {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(
            PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
        );
    }

    public function applyMigrations() {
        $newMigrations = [];

        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR.'/migrations/');
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::$ROOT_DIR.'/migrations/'.$migration;

            $className = pathinfo($migration, PATHINFO_FILENAME);

            $instance = new $className();

            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");

            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log('All migrations are applied');
        }
    }

    /**
     * Create the migration table if not exists in database
     */
    public function createMigrationsTable() : void {
        $this->pdo->exec(
            ' CREATE TABLE IF NOT EXISTS MIGRATIONS(
                    ID INT AUTO_INCREMENT PRIMARY KEY
                    , MIGRATION VARCHAR(255)
                    , CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
                 ) ENGINE=INNODB;
            '
        );
    }


    /**
     * Get all applied migrations
     * @return array
     */
    public function getAppliedMigrations() : array {
        $statement = $this->pdo->prepare(
            'SELECT MIGRATION FROM MIGRATIONS;'
        );

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Save the migrations filenames in database
     * @param array $migrations
     */
    public function saveMigrations(array $migrations) : void {
        $migrations = array_map(fn($migration) => "('$migration')", $migrations);

        $str = implode(",", $migrations);

        $statement = $this->pdo->prepare(
            "INSERT INTO MIGRATIONS (MIGRATION) VALUES $str;"
        );

        $statement->execute();
    }

    protected function log($message) {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}