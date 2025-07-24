<?php
$pdo = new PDO(
    'mysql:host=' . getenv("DB_HOST") . ';dbname=' . getenv("DB_NAME"),
    getenv("DB_USER"),
    getenv("DB_PASSWORD")
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

