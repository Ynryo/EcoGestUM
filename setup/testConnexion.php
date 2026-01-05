<?php
echo "testConnexion.php";

echo "<br>Loading Vendor...<br>";
require dirname(__FILE__, 2) . '/vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();
echo "<br>Vendor Loaded !<br>";

echo "<br>Environment Variables:<br>";
echo "Host:";
echo $_ENV["DB_HOST"];
echo "<br>Database:";
echo $_ENV["DB_DATABASE_SSH"];
echo "<br>User:";
echo $_ENV["DB_USERNAME_SSH"];
echo "<br>Password:";
echo $_ENV["DB_PASSWORD_SSH"];
echo "<br>";

echo "<br>Testing conn.php...<br>";
include_once(dirname(__FILE__, 2) . '/assets/models/conn.php');
echo "<br>conn.php loaded !<br>";

try {
    $pdo = new PDO("mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_DATABASE_SSH"], $_ENV["DB_USERNAME_SSH"], $_ENV["DB_PASSWORD_SSH"]);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}