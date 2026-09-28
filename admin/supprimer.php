<?php
require_once __DIR__ . '/garde.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $suppression = $pdoAdmin->prepare('DELETE FROM citations WHERE id_citation = :id');
    $suppression->execute(['id' => $id]);
}

header('Location: index.php?supprime=1');
exit;
