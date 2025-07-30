<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? null;
    $action = $_POST['action'] ?? '';

    if ($userId && in_array($action, ['Suspendre', 'Réactiver'])) {
        $newStatus = ($action === 'Suspendre') ? 0 : 1;

        $stmt = $pdo->prepare("UPDATE users SET is_active = :status WHERE id = :id");
        $stmt->execute([
            'status' => $newStatus,
            'id' => $userId
        ]);
    }
}

header('Location: admin.php');
exit();
