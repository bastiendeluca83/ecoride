<?php echo "✅ Fichier détecté<br>"; ?>


$pdo = new PDO(
    'mysql:host=' . getenv("DB_HOST") . ';dbname=' . getenv("DB_NAME"),
    getenv("DB_USER"),
    getenv("DB_PASSWORD")
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query("SELECT * FROM admins");
$admins = $stmt->fetchAll();

echo "<h2>📋 Liste des admins :</h2>";
if (!$admins) {
    echo "<p>Aucun administrateur trouvé.</p>";
} else {
    echo "<ul>";
    foreach ($admins as $admin) {
        echo "<li>👤 " . htmlspecialchars($admin["username"]) . " | 🔑 " . htmlspecialchars($admin["password"]) . "</li>";
    }
    echo "</ul>";
}
?>
