<?php
require __DIR__ . '/../vendor/autoload.php';
use Authentication\PasswordHasher\DefaultPasswordHasher;

try {
    $pdo = new PDO('mysql:host=localhost;dbname=jyza_autoadministrable;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare('SELECT password FROM users WHERE id = 1');
    $stmt->execute();
    $hash = $stmt->fetchColumn();
    $hasher = new DefaultPasswordHasher();
    $password = 'Admin123!';
    $ok = $hasher->check($password, $hash);
    echo $ok ? "MATCH\n" : "NO MATCH\n";
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
