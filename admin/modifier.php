<?php
require_once __DIR__ . '/garde.php';

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auteur = trim($_POST['auteur'] ?? '');
    $citation = trim($_POST['citation'] ?? '');

    if ($auteur === '' || $citation === '') {
        $erreur = 'Merci de renseigner un auteur et une citation.';
    } else {
        $maj = $pdoAdmin->prepare('UPDATE citations SET auteur = :auteur, citation = :citation WHERE id_citation = :id');
        $maj->execute(['auteur' => $auteur, 'citation' => $citation, 'id' => $id]);
        header('Location: index.php');
        exit;
    }
}

$requete = $pdoAdmin->prepare('SELECT * FROM citations WHERE id_citation = :id');
$requete->execute(['id' => $id]);
$citationActuelle = $requete->fetch(PDO::FETCH_ASSOC);

if (!$citationActuelle) {
    header('Location: index.php');
    exit;
}

$auteurAffiche = $_POST['auteur'] ?? $citationActuelle['auteur'];
$citationAffichee = $_POST['citation'] ?? $citationActuelle['citation'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier une citation</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="page-formulaire">
        <div class="cadre">
            <h1>Modifier la citation #<?php echo $id; ?></h1>

            <?php if ($erreur): ?>
                <div class="message-erreur"><?php echo htmlspecialchars($erreur); ?></div>
            <?php endif; ?>

            <form action="modifier.php?id=<?php echo $id; ?>" method="post">
                <label for="auteur">Auteur</label>
                <input type="text" id="auteur" name="auteur" value="<?php echo htmlspecialchars($auteurAffiche); ?>" required>

                <label for="citation">Citation</label>
                <textarea id="citation" name="citation" required><?php echo htmlspecialchars($citationAffichee); ?></textarea>

                <button class="bouton" type="submit">Enregistrer</button>
            </form>

            <a class="retour" href="index.php">&larr; Retour à la liste</a>
        </div>
    </div>
</body>
</html>
