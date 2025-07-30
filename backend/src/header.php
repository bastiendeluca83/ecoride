<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Plateforme EcoRide - covoiturage écologique et économique.">
  <meta name="author" content="EcoRide Team">
  <meta name="keywords" content="covoiturage, écologique, mobilité, EcoRide">
  <title>EcoRide</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" href="assets/favicon.png" type="image/svg+xml">
</head>
<body>

<nav class="navbar navbar-expand-lg px-3" style="background-color: #24884e;" role="navigation" aria-label="Menu principal">
  <a class="navbar-brand d-flex align-items-center text-white" href="index.php" aria-label="Accueil EcoRide">
    <img src="assets/favicon.png" alt="Logo EcoRide" width="32" height="32" class="me-2 rounded-circle">
    <span class="fw-bold">EcoRide</span>
  </a>

  <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Ouvrir le menu">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-between" id="navbarMain">
    <ul class="navbar-nav" role="menubar">
      <li class="nav-item" role="none">
        <a class="nav-link text-white" href="covoiturages.php" role="menuitem">Covoiturages</a>
      </li>
      <li class="nav-item" role="none">
        <a class="nav-link text-white" href="contact.php" role="menuitem">Contact</a>
      </li>
    </ul>

    <ul class="navbar-nav" role="menubar">
      <li class="nav-item dropdown" role="none">
        <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu utilisateur">
          <img src="user-placeholder.jpg" alt="Photo utilisateur" width="32" height="32" class="rounded-circle me-2">
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
          <li><a class="dropdown-item text-primary fw-bold" href="register.php">S'inscrire</a></li>
          <li><a class="dropdown-item text-primary" href="login.php">Se connecter</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>





