<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit();
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$totalUsersQuery = $pdo->query("SELECT COUNT(*) FROM users");
$totalUsers = $totalUsersQuery->fetchColumn();
$totalPages = ceil($totalUsers / $limit);

// Recherche
$search = $_GET['search'] ?? '';
$searchSql = $search ? "WHERE email LIKE :search" : "";

$stmt = $pdo->prepare("SELECT id, pseudo, email, password, credits, role, is_active FROM users $searchSql ORDER BY id DESC LIMIT :limit OFFSET :offset");
if ($search) {
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();

// Total crédits
$reqTotalCredits = $pdo->query("SELECT SUM(credits) AS total FROM rides");
$totalCredits = $reqTotalCredits->fetch()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - EcoRide</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4">Espace Administrateur</h1>
    <h2>Total crédits gagnés : <?= htmlspecialchars($totalCredits) ?> ⚡</h2>

    <h2 class="mt-5">📈 Covoiturages par jour</h2>
    <canvas id="ridesChart" width="400" height="200"></canvas>

    <h2 class="mt-5">💰 Crédits gagnés par jour</h2>
    <canvas id="creditsChart" width="400" height="200"></canvas>

    <h2 class="mt-5">👥 Gérer les comptes utilisateurs</h2>

    <form method="get" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Recherche par email" value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-success" type="submit">Filtrer</button>
        <a href="admin.php" class="btn btn-secondary ms-2">Réinitialiser</a>
    </form>

    <table class="table table-bordered">
        <thead class="table-success">
            <tr>
                <th>ID</th><th>Pseudo</th><th>Email</th><th>Mot de passe</th><th>Crédits</th><th>Rôle</th><th>Statut</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['pseudo']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['password']) ?></td>
                <td><?= $u['credits'] ?></td>
                <td><?= $u['role'] ?></td>
                <td><?= $u['is_active'] ? 'Actif' : 'Suspendu' ?></td>
                <td>
                    <form method="POST" action="modify_user.php" class="d-inline">
                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                        <button type="submit" class="btn btn-warning btn-sm">Modifier</button>
                    </form>
                    <form method="POST" action="delete_user.php" class="d-inline">
                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
      <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i === $page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>

    <h3 class="mt-4">Ajouter un nouvel utilisateur</h3>
    <form method="POST" action="add_user.php" class="row g-3">
        <div class="col-md-3"><input type="text" name="pseudo" class="form-control" placeholder="Pseudo" required></div>
        <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="col-md-3"><input type="text" name="password" class="form-control" placeholder="Mot de passe" required></div>
        <div class="col-md-3"><input type="number" name="credits" class="form-control" placeholder="Crédits" required></div>
        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="user">Utilisateur</option>
                <option value="admin">Admin</option>
                <option value="employe">Employé</option>
            </select>
        </div>
        <div class="col-md-12"><button type="submit" class="btn btn-primary">Ajouter</button></div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    fetch("chart_data.php")
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById("ridesChart"), {
                type: 'line',
                data: {
                    labels: data.rides.labels,
                    datasets: [{
                        label: 'Covoiturages / jour',
                        data: data.rides.data,
                        borderColor: 'green',
                        tension: 0.3
                    }]
                },
                options: { responsive: true }
            });

            new Chart(document.getElementById("creditsChart"), {
                type: 'bar',
                data: {
                    labels: data.credits.labels,
                    datasets: [{
                        label: 'Crédits gagnés / jour',
                        data: data.credits.data,
                        backgroundColor: '#24884e'
                    }]
                },
                options: { responsive: true }
            });
        });
});
</script>
</body>
</html>











