<?php
/**
 * Connexion PDO à la BDD sur l'hébergement InfinityFree.
 *
 * L'hébergement mutualisé gratuit ne permet pas de créer plusieurs comptes
 * MySQL avec des droits différents (contrairement à la version locale sur
 * WampServer). On utilise donc l'unique compte MySQL fourni par
 * InfinityFree pour toutes les connexions ; la distinction visiteur /
 * administrateur reste garantie au niveau de l'application, par la session
 * PHP (voir admin/garde.php et login.php).
 *
 * IMPORTANT : remplace MOT_DE_PASSE_A_COMPLETER ci-dessous par ton mot de
 * passe MySQL InfinityFree avant d'uploader ce fichier.
 */

function getConnexion(bool $enTantQuAdmin = false): PDO
{
    $serveur = 'sql304.infinityfree.com';
    $db = 'if0_42941270_citations';
    $utilisateur = 'if0_42941270';
    $mot_passe = 'MOT_DE_PASSE_A_COMPLETER';

    try {
        $connexion = new PDO("mysql:host=$serveur;dbname=$db;charset=utf8mb4", $utilisateur, $mot_passe);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connexion;
    } catch (PDOException $event) {
        die('Erreur de connexion à la base de données : ' . $event->getMessage());
    }
}
