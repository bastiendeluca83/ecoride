<?php
session_start();
require_once 'db.php';
include 'header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... votre logique de connexion ...
}
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm p-4">
        <h2 class="card-title text-center mb-3">Se connecter</h2>
        <p class="text-center text-muted">Pas encore membre ? <a href="register.php">Inscrivez-vous</a></p>

        <?php if ($error): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" class="form-control" placeholder="Adresse email" required>
            </div>
          </div>

          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
            </div>
          </div>

          <button type="submit" class="btn btn-success w-100 mb-2">Connexion</button>

          <div class="text-center">
            <a href="#">Mot de passe oublié ? Cliquez ici</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'footer-green.php'; ?>








