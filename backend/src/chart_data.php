<?php
require_once 'db.php';
header('Content-Type: application/json');

// Covoiturages par jour
$stmt1 = $pdo->query("SELECT DATE(date) AS jour, COUNT(*) AS total FROM rides GROUP BY jour ORDER BY jour ASC");
$rides = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// Crédits gagnés par jour
$stmt2 = $pdo->query("SELECT DATE(date) AS jour, SUM(credits) AS total FROM rides GROUP BY jour ORDER BY jour ASC");
$credits = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Structure de réponse
echo json_encode([
    'rides' => [
        'labels' => array_column($rides, 'jour'),
        'data' => array_column($rides, 'total')
    ],
    'credits' => [
        'labels' => array_column($credits, 'jour'),
        'data' => array_map('intval', array_column($credits, 'total'))
    ]
]);


