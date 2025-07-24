<?php
require_once 'db.php';

try {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Liste des utilisateurs</h2>";
    foreach ($users as $user) {
        echo "<p>{$user['firstname']} {$user['lastname']} - {$user['email']}</p>";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
