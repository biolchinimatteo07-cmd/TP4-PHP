<?php
// Garde d'accès : à inclure en haut de chaque page de l'espace administrateur.
session_start();
require_once __DIR__ . '/../connexion.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: ../index.php?erreur=1');
    exit;
}

$pdoAdmin = getConnexion(true);
