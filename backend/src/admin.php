<?php
ob_start();
session_start();
require 'db.php';

// Redirection si non connecté
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Traitement ajout
if (isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, email) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['firstname'], $_POST['lastname'], $_POST['email']]);
    header("Location: admin.php");
    exit;
}

// Traitement suppression
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: admin.php");
    exit;
}

// Traitement modification
if (isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
    $stmt->execute([$_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['id']]);
    header("Location: admin.php");
    exit;
}

// Si modification demandée
$editUser = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editUser = $stmt->fetch();
}

// Liste des utilisateurs
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des utilisateurs</title>
    <link rel="stylesheet" href="/backend/src/admin.css">
    <link rel="stylesheet" href="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page d'administration pour la gestion des utilisateurs - EcoRide">
    <meta name="author" content="EcoRide Team">     

</head>
<body>
    <body class="d-flex flex-column min-vh-100">
     <?php include 'header.php'; ?> 
    <h2>👑 Bienvenue, <?= $_SESSION['admin'] ?> 

    <h3><?= $editUser ? "✏️ Modifier l'utilisateur" : "➕ Ajouter un utilisateur" ?></h3>
    <form method="post">
        <input type="hidden" name="id" value="<?= $editUser['id'] ?? '' ?>">
        <input type="text" name="firstname" placeholder="Prénom" value="<?= $editUser['firstname'] ?? '' ?>" required>
        <input type="text" name="lastname" placeholder="Nom" value="<?= $editUser['lastname'] ?? '' ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?= $editUser['email'] ?? '' ?>" required>
        <button type="submit" name="<?= $editUser ? 'update' : 'add' ?>">
            <?= $editUser ? 'Mettre à jour' : 'Ajouter' ?>
        </button>
    </form>

    <h3>📋 Liste des utilisateurs</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th><th>Prénom</th><th>Nom</th><th>Email</th><th>Créé le</th><th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['firstname']) ?></td>
            <td><?= htmlspecialchars($user['lastname']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['created_at'] ?></td>
            <td>
                <a href="?edit=<?= $user['id'] ?>">✏️ Modifier</a> |
                <a href="?delete=<?= $user['id'] ?>" onclick="return confirm('Supprimer cet utilisateur ?')">❌ Supprimer</a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    <?php include 'footer.php'; ?>

</body>
</html>






