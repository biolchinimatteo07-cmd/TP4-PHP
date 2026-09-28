<?php
require_once __DIR__ . '/garde.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auteur = trim($_POST['auteur'] ?? '');
    $citation = trim($_POST['citation'] ?? '');

    if ($auteur !== '' && $citation !== '') {
        $insertion = $pdoAdmin->prepare('INSERT INTO citations (auteur, citation) VALUES (:auteur, :citation)');
        $insertion->execute(['auteur' => $auteur, 'citation' => $citation]);
    }
}

header('Location: index.php');
exit;
