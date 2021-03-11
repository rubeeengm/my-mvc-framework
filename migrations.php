<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use app\core\Application;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(
    __DIR__
);

$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN']
        , 'user' => $_ENV['DB_USER']
        , 'password' => $_ENV['DB_PASSWORD']
    ]
];

$app = new Application(
    __DIR__, $config
);

$app->database->applyMigrations();