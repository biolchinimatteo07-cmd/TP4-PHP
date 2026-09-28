<?php
require_once __DIR__ . '/connexion.php';

$succes = false;
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auteur = trim($_POST['auteur'] ?? '');
    $citation = trim($_POST['citation'] ?? '');

    if ($auteur === '' || $citation === '') {
        $erreur = 'Merci de renseigner un auteur et une citation.';
    } else {
        $pdo = getConnexion(false);
        $insertion = $pdo->prepare('INSERT INTO citations (auteur, citation) VALUES (:auteur, :citation)');
        $insertion->execute(['auteur' => $auteur, 'citation' => $citation]);
        $succes = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Déposer une citation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="page-formulaire">
        <div class="cadre">
            <h1>Déposer une citation</h1>

            <?php if ($succes): ?>
                <div class="message-succes">Merci, votre citation a bien été ajoutée !</div>
            <?php endif; ?>
            <?php if ($erreur): ?>
                <div class="message-erreur"><?php echo htmlspecialchars($erreur); ?></div>
            <?php endif; ?>

            <form action="deposer.php" method="post">
                <label for="auteur">Auteur</label>
                <input type="text" id="auteur" name="auteur" required>

                <label for="citation">Citation</label>
                <textarea id="citation" name="citation" placeholder="Ecrivez une citation ici !" required></textarea>

                <button class="bouton" type="submit">Poster</button>
            </form>

            <a class="retour" href="index.php">&larr; Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>
