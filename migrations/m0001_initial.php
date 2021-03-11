<?php
declare(strict_types=1);

use app\core\Application;

class m0001_initial {
    public function up() {
        $database = Application::$app->database;
        $SQL = "
            CREATE TABLE USERS(
                ID INT AUTO_INCREMENT PRIMARY KEY 
                , EMAIL VARCHAR(255) NOT NULL
                , FIRSTNAME VARCHAR(255) NOT NULL
                , LASTNAME VARCHAR(255) NOT NULL   
                , STATUS TINYINT NOT NULL
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