<?php
declare(strict_types=1);

use app\core\Application;

class m0001_initial {
    public function up() {
        $database = Application::$app->database;
        $SQL = "
            CREATE TABLE USERS(
                id INT AUTO_INCREMENT PRIMARY KEY 
                , email VARCHAR(255) NOT NULL
                , firstName VARCHAR(255) NOT NULL
                , lastName VARCHAR(255) NOT NULL   
                , status TINYINT NOT NULL
                , CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ";

        $database->pdo->exec($SQL);
    }

    public function down() {
        $database = Application::$app->database;
        $SQL = "
            DROP TABLE USERS;
        ";

        $database->pdo->exec($SQL);
    }
}