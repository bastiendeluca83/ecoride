<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

$pdo = new PDO(
    'mysql:host=' . getenv("DB_HOST") . ';dbname=' . getenv("DB_NAME"),
    getenv("DB_USER"),
    getenv("DB_PASSWORD")
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Supprimer un utilisateur
if (isset($_GET["delete"])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET["delete"]]);
    header("Location: admin-users.php");
    exit;
}

// Modifier un utilisateur
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["edit_id"])) {
    $stmt = $pdo->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
    $stmt->execute([
        $_POST["firstname"],
        $_POST["lastname"],
        $_POST["email"],
        $_POST["edit_id"]
    ]);
    header("Location: admin-users.php");
    exit;
}

// Récupération des utilisateurs
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$editId = isset($_GET["edit"]) ? intval($_GET["edit"]) : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
</head>
<body>
    <h2>👨‍💼 Interface Admin – Utilisateurs</h2>
    <p><a href="admin.php">⬅ Retour au tableau de bord</a> | <a href="logout.php">🔓 Déconnexion</a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Créé le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <?php if ($editId === (int)$user["id"]): ?>
                <form method="post">
                    <tr>
                        <td><?= $user["id"] ?></td>
                        <td><input type="text" name="firstname" value="<?= htmlspecialchars($user["firstname"]) ?>"></td>
                        <td><input type="text" name="lastname" value="<?= htmlspecialchars($user["lastname"]) ?>"></td>
                        <td><input type="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>"></td>
                        <td><?= $user["created_at"] ?></td>
                        <td>
                            <input type="hidden" name="edit_id" value="<?= $user["id"] ?>">
                            <button type="submit">💾 Enregistrer</button>
                            <a href="admin-users.php">❌ Annuler</a>
                        </td>
                    </tr>
                </form>
            <?php else: ?>
                <tr>
                    <td><?= $user["id"] ?></td>
                    <td><?= htmlspecialchars($user["firstname"]) ?></td>
                    <td><?= htmlspecialchars($user["lastname"]) ?></td>
                    <td><?= htmlspecialchars($user["email"]) ?></td>
                    <td><?= $user["created_at"] ?></td>
                    <td>
                        <a href="admin-users.php?edit=<?= $user["id"] ?>">✏️ Modifier</a> |
                        <a href="admin-users.php?delete=<?= $user["id"] ?>" onclick="return confirm('Supprimer cet utilisateur ?')">🗑 Supprimer</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
