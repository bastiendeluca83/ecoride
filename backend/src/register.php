<?php
session_start();
require_once 'db.php';
include 'header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($pseudo && $email && $password && $confirm) {
        if ($password !== $confirm) {
            $error = "Les mots de passe ne correspondent pas.";
        } elseif (strlen($password) < 6) {
            $error = "Mot de passe trop court (6 caractères minimum).";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $pdo->prepare("INSERT INTO users (pseudo, email, password, credits, role) VALUES (:pseudo, :email, :password, 20, 'user')");
                $stmt->execute([
                    'pseudo' => $pseudo,
                    'email' => $email,
                    'password' => $hash
                ]);
                $success = "Compte créé avec succès !";
            } catch (PDOException $e) {
                $error = ($e->getCode() == 23000) ? "Email déjà utilisé." : "Erreur : " . $e->getMessage();
            }
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="register.css">
</head>
<body>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
      <div class="card shadow-sm p-4">
        <h2 class="text-center">Inscription</h2>
        <p class="text-center text-muted">Déjà membre ? <a href="login.php">Connectez-vous</a></p>

        <?php if ($error): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
          <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
          </div>

          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-person-plus"></i></span>
            <input type="text" name="pseudo" class="form-control" placeholder="Pseudo" required>
          </div>

          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
          </div>

          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-check2-circle"></i></span>
            <input type="password" name="confirm" class="form-control" placeholder="Confirmer le mot de passe" required>
          </div>

          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" required>
            <label class="form-check-label">
              Je suis d'accord avec les <a href="#">Conditions Générales d'Utilisation</a>.
            </label>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-success">Valider</button>
          </div>

          <div class="text-center mt-3">
            <small>Besoin d’aide ? <a href="#">Contactez-nous</a></small>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<footer class="text-center py-4" style="background-color: #24884e;">
  <div class="container text-white">
    <p class="mb-2 fw-bold">contact@ecoride.site</p>
    <hr class="my-2" style="max-width: 300px; margin: auto; border-color: rgba(255,255,255,0.3);">
    <div class="d-flex justify-content-center gap-4 flex-wrap mt-3">
      <a href="mentions-legales.php" class="text-white text-decoration-none">Mentions légales</a>
      <a href="confidentialite.php" class="text-white text-decoration-none">Politique de confidentialité</a>
      <a href="cgu.php" class="text-white text-decoration-none">CGU</a>
    </div>
  </div>
</footer>
    </div>
  </div>
</footer>
<?php include 'footer.php'; ?>
</body>
</html>


