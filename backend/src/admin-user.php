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

// Suppression//
if (isset($_GET["delete"])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET["delete"]]);
    $_SESSION["message"] = "Utilisateur supprimé.";
    header("Location: admin-users.php");
    exit;
}

// Modification//
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["edit_id"])) {
    $stmt = $pdo->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
    $stmt->execute([
        $_POST["firstname"],
        $_POST["lastname"],
        $_POST["email"],
        $_POST["credits"],
        $_POST["edit_id"]
    ]);
    $_SESSION["message"] = "Utilisateur modifié.";
    header("Location: admin-users.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$editId = isset($_GET["edit"]) ? intval($_GET["edit"]) : null;

$pageTitle = "Admin – Gestion des utilisateurs";
include("header.php");
?>

<div class="container mt-4">
    <h2 class="mb-4">👨‍💼 Interface Admin – Utilisateurs</h2>

    <?php if (!empty($_SESSION["message"])): ?>
        <div class="alert alert-success">
            <?= $_SESSION["message"]; unset($_SESSION["message"]); ?>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="admin.php" class="btn btn-secondary">⬅ Retour au tableau de bord</a>
        <a href="logout.php" class="btn btn-danger float-end">🔓 Déconnexion</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Crédits</th>
                    <th>Créé le</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <?php if ($editId === (int)$user["id"]): ?>
                   <form method="post">
    <tr>
        <td><?= $user["id"] ?></td>
        <td><input type="text" name="firstname" class="form-control" value="<?= htmlspecialchars($user["firstname"]) ?>"></td>
        <td><input type="text" name="lastname" class="form-control" value="<?= htmlspecialchars($user["lastname"]) ?>"></td>
        <td><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user["email"]) ?>"></td>
        <td><input type="number" name="credits" class="form-control" value="<?= htmlspecialchars($user["credits"]) ?>"></td>
        <td><?= $user["created_at"] ?></td>
        <td class="text-center">
            <input type="hidden" name="edit_id" value="<?= $user["id"] ?>">
            <button type="submit" class="btn btn-success btn-sm">💾 Enregistrer</button>
            <a href="admin-users.php" class="btn btn-secondary btn-sm">❌ Annuler</a>
        </td>
    </tr>
</form>

                <?php else: ?>
                    <tr>
                        <td><?= $user["id"] ?></td>
                        <td><?= htmlspecialchars($user["firstname"]) ?></td>
                        <td><?= htmlspecialchars($user["lastname"]) ?></td>
                        <td><?= htmlspecialchars($user["email"]) ?></td>
                        <td><?= htmlspecialchars($user["credits"]) ?></td>
                        <td><?= $user["created_at"] ?></td>
                        <td class="text-center">
                            <a href="admin-users.php?edit=<?= $user["id"] ?>" class="btn btn-warning btn-sm">✏️ Modifier</a>
                            <a href="admin-users.php?delete=<?= $user["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet utilisateur ?')">🗑 Supprimer</a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("footer.php"); ?>
