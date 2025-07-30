<?php
session_start();
require_once 'db.php';

// Vérification si l'utilisateur est bien administrateur
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
// Requête total crédits
$reqTotalCredits = $pdo->query("SELECT SUM(credits_prelevés_plateforme) AS total FROM transactions");
$totalCredits = $reqTotalCredits->fetch()['total'] ?? 0;

// Requête utilisateurs et employés
$users = $pdo->query("SELECT id, pseudo, email, role, is_active FROM users")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - EcoRide</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Espace Administrateur</h1>

    <section>
        <h2>Total crédits gagnés : <?= htmlspecialchars($totalCredits) ?> ⚡</h2>
    </section>

    <section>
        <h2>Graphique : Covoiturages par jour</h2>
        <canvas id="ridesChart"></canvas>

        <h2>Graphique : Crédits gagnés par jour</h2>
        <canvas id="creditsChart"></canvas>
    </section>

    <section>
        <h2>Gérer les comptes</h2>
        <table border="1">
            <tr><th>ID</th><th>Pseudo</th><th>Email</th><th>Rôle</th><th>Statut</th><th>Action</th></tr>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['pseudo']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= $u['role'] ?></td>
                    <td><?= $u['is_active'] ? 'Actif' : 'Suspendu' ?></td>
                    <td>
                        <?php if ($u['role'] !== 'admin'): ?>
                            <form method="POST" action="suspend_user.php">
                                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                <input type="submit" name="action" value="<?= $u['is_active'] ? 'Suspendre' : 'Réactiver' ?>">
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <script>
    // Graphiques via fetch API
    fetch('chart_data.php')
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('ridesChart'), {
                type: 'line',
                data: {
                    labels: data.rides.labels,
                    datasets: [{
                        label: 'Covoiturages/jour',
                        data: data.rides.data
                    }]
                }
            });

            new Chart(document.getElementById('creditsChart'), {
                type: 'bar',
                data: {
                    labels: data.credits.labels,
                    datasets: [{
                        label: 'Crédits/jour',
                        data: data.credits.data
                    }]
                }
            });
        });
    </script>
</body>
</html>







