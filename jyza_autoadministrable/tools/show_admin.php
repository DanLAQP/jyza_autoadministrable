<?php
require __DIR__ . '/../vendor/autoload.php';
try {
    $pdo = new PDO('mysql:host=localhost;dbname=jyza_autoadministrable;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare('SELECT id, username, password, estado FROM users WHERE id = 1');
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "ID: " . $row['id'] . "\n";
        echo "USERNAME: " . $row['username'] . "\n";
        echo "ESTADO: " . $row['estado'] . "\n";
        echo "PASSWORD HASH: " . $row['password'] . "\n";
    } else {
        echo "No admin user found\n";
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
