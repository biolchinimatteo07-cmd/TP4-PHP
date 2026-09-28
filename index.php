<?php
session_start();
require_once __DIR__ . '/connexion.php';

$pdo = getConnexion(false);
$citations = $pdo->query('SELECT auteur, citation FROM citations ORDER BY id_citation ASC')->fetchAll(PDO::FETCH_ASSOC);

$estAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
$erreurConnexion = isset($_GET['erreur']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dictionnaire de citations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="carrousel">
        <div class="carrousel-fond" id="fond"></div>

        <div class="entete">
            <h1 class="titre-site">Dictionnaire de citations</h1>

            <?php if ($estAdmin): ?>
                <div class="encart-connexion">
                    Connecté en tant qu'administrateur.<br>
                    <a class="lien-bouton" href="admin/index.php" style="margin-top:10px;display:inline-block;">Espace administrateur</a>
                    <a class="lien-bouton secondaire" href="logout.php" style="margin-top:10px;display:inline-block;">Déconnexion</a>
                </div>
            <?php else: ?>
                <form class="encart-connexion" action="login.php" method="post">
                    <strong>Veuillez entrer l'utilisateur et le mot de passe pour accéder au domaine administrateur :</strong>
                    <label for="identifiant">Utilisateur</label>
                    <input type="text" id="identifiant" name="identifiant" required>
                    <label for="mot_passe">Mot de passe</label>
                    <input type="password" id="mot_passe" name="mot_passe" required>
                    <button type="submit">Valider</button>
                    <?php if ($erreurConnexion): ?>
                        <div class="erreur">Identifiant ou mot de passe incorrect.</div>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </div>

        <div class="citation-zone">
            <p class="citation-texte" id="texte-citation">&nbsp;</p>
            <p class="citation-auteur" id="auteur-citation">&nbsp;</p>
        </div>

        <div class="pied-accueil">
            <a class="lien-bouton" href="deposer.php">Déposer une citation</a>
        </div>
    </div>

    <script>
        const citations = <?php echo json_encode($citations, JSON_UNESCAPED_UNICODE); ?>;
        const images = ['images/fond1.svg', 'images/fond2.svg', 'images/fond3.svg', 'images/fond4.svg', 'images/fond5.svg'];

        let index = citations.length ? Math.floor(Math.random() * citations.length) : 0;
        const fond = document.getElementById('fond');
        const texteEl = document.getElementById('texte-citation');
        const auteurEl = document.getElementById('auteur-citation');

        function afficherCitation() {
            if (!citations.length) {
                texteEl.textContent = 'Aucune citation pour le moment. Soyez le premier à en déposer une !';
                auteurEl.textContent = '';
                fond.style.backgroundImage = `url('${images[0]}')`;
                return;
            }

            const c = citations[index];

            texteEl.style.opacity = 0;
            auteurEl.style.opacity = 0;

            setTimeout(() => {
                texteEl.textContent = '« ' + c.citation + ' »';
                auteurEl.textContent = '— ' + c.auteur;
                fond.style.backgroundImage = `url('${images[index % images.length]}')`;
                texteEl.style.opacity = 1;
                auteurEl.style.opacity = 1;
            }, 300);
        }

        function citationSuivante() {
            index = (index + 1) % citations.length;
            afficherCitation();
        }

        afficherCitation();
        if (citations.length > 1) {
            setInterval(citationSuivante, 15000);
        }
    </script>
</body>
</html>
