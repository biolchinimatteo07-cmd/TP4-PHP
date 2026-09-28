<?php
require_once __DIR__ . '/garde.php';

$citations = $pdoAdmin->query('SELECT id_citation, auteur, citation, date_ajout FROM citations ORDER BY id_citation DESC')->fetchAll(PDO::FETCH_ASSOC);
$supprime = isset($_GET['supprime']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration - Dictionnaire de citations</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="admin-barre">
        <strong>Espace administrateur</strong> — connecté en tant que <?php echo htmlspecialchars($_SESSION['identifiant_admin']); ?>
        <div>
            <a href="../index.php">Voir le site</a> &nbsp;|&nbsp;
            <a href="../logout.php">Déconnexion</a>
        </div>
    </div>

    <div class="admin-contenu">
        <?php if ($supprime): ?>
            <div class="message-succes">Citation supprimée.</div>
        <?php endif; ?>

        <h2>Ajouter une citation</h2>
        <form action="ajouter.php" method="post" class="cadre" style="max-width:none;">
            <label for="auteur">Auteur</label>
            <input type="text" id="auteur" name="auteur" required>

            <label for="citation">Citation</label>
            <textarea id="citation" name="citation" placeholder="Ecrivez une citation ici !" required></textarea>

            <button class="bouton" type="submit">Poster</button>
        </form>

        <h2 style="margin-top:36px;">Citations (<?php echo count($citations); ?>)</h2>
        <table class="citations">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Auteur</th>
                    <th>Citation</th>
                    <th>Ajoutée le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($citations as $c): ?>
                    <tr>
                        <td><?php echo $c['id_citation']; ?></td>
                        <td><?php echo htmlspecialchars($c['auteur']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($c['citation'])); ?></td>
                        <td><?php echo htmlspecialchars($c['date_ajout']); ?></td>
                        <td class="actions">
                            <a href="modifier.php?id=<?php echo $c['id_citation']; ?>">Modifier</a>
                            <a class="lien-danger" href="supprimer.php?id=<?php echo $c['id_citation']; ?>"
                               onclick="return confirm('Supprimer cette citation ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$citations): ?>
                    <tr><td colspan="5">Aucune citation enregistrée.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
