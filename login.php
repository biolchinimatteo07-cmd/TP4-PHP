<?php
session_start();
require_once __DIR__ . '/connexion.php';

$identifiant = trim($_POST['identifiant'] ?? '');
$mot_passe = $_POST['mot_passe'] ?? '';

if ($identifiant === '' || $mot_passe === '') {
    header('Location: index.php?erreur=1');
    exit;
}

$pdo = getConnexion(false);
$requete = $pdo->prepare('SELECT mot_passe FROM administrateurs WHERE identifiant = :identifiant');
$requete->execute(['identifiant' => $identifiant]);
$admin = $requete->fetch(PDO::FETCH_ASSOC);

if ($admin && password_verify($mot_passe, $admin['mot_passe'])) {
    $_SESSION['admin'] = true;
    $_SESSION['identifiant_admin'] = $identifiant;
    header('Location: admin/index.php');
    exit;
}

header('Location: index.php?erreur=1');
exit;
