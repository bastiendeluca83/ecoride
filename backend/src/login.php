<?php
session_start();

if (isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}

require 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && $password === $admin["password"]) {
        $_SESSION["admin"] = $admin["username"];
        header("Location: admin.php");
        exit;
    } else {
        $error = "❌ Identifiants invalides";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>

   <!-- Bootstrap CSS & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Connexion sécurisée à l'espace administrateur du site EcoRide">
    <meta name="author" content="EcoRide Team">
    <meta name="theme-color" content="#28a745">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">

    <title>Connexion Admin - EcoRide</title>

    <!-- Feuilles de style -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    <?php include 'header.php'; ?>

    <main class="flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="card p-4 shadow" style="max-width: 400px; width: 100%; margin-top: 100px;">
            <h4 class="text-center mb-4">🔐 Connexion Administrateur</h4>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>
        </div>
    </main>

    <footer class="text-center mt-auto py-3 text-muted">
        © 2023 EcoRide - Tous droits réservés
    </footer>

    <!-- Bootstrap JS -->
    <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>



