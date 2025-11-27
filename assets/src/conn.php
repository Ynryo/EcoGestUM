<?php
require dirname(__FILE__, 3) . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__FILE__, 3));
$dotenv->load();

try {
    if ($_SERVER["HTTP_HOST"] == "127.0.0.1:8000") {
        $pdo = new PDO(
            "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE_LOCAL'] . ";charset=utf8mb4",
            $_ENV['DB_USERNAME_LOCAL'],
            $_ENV['DB_PASSWORD_LOCAL']
        );
    } else {
        $pdo = new PDO(
            "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE_SSH'] . ";charset=utf8mb4",
            $_ENV['DB_USERNAME_SSH'],
            $_ENV['DB_PASSWORD_SSH']
        );
    }
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<p class=\"error\">Connexion échouée : " . $e->getMessage() . "</p>");
}
