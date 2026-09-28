# TP4 - Dictionnaire de citations littéraires interactif

## Sujet

Site dynamique en PHP / MySQL permettant à tout visiteur de consulter et de
déposer des citations littéraires, et à un administrateur de gérer
l'ensemble des citations (C.R.U.D).

### Diagramme des cas d'utilisation

- **Visiteurs** : Déposer une citation, Consulter une citation
- **Administrateur** : C.R.U.D (Create, Read, Update, Delete) sur les citations

## Fichiers

- `sql/creation_bdd.sql` : crée la base `tp4_citations`, les tables
  `citations` et `administrateurs`, insère des citations de démonstration et
  crée **deux comptes MySQL avec des droits différents** :
  - `tp4_visiteur` : `SELECT` sur toute la base + `INSERT` sur `citations`
  - `tp4_admin` : tous les droits (`ALL PRIVILEGES`)
- `connexion.php` : fonction `getConnexion($enTantQuAdmin)` qui ouvre une
  connexion PDO avec le compte MySQL correspondant au rôle (visiteur ou
  administrateur, selon la session).
- `index.php` : page d'accueil publique. Carrousel qui affiche une citation
  aléatoire au chargement puis change automatiquement de citation **et
  d'image de fond toutes les 15 secondes** (transition en fondu, en JS pur).
  Contient aussi le formulaire "Veuillez entrer l'utilisateur et le mot de
  passe pour accéder au domaine administrateur".
- `deposer.php` : formulaire "Déposer une citation" (Auteur + zone de texte +
  bouton Poster), accessible à tout visiteur.
- `login.php` : vérifie l'identifiant/mot de passe dans la table
  `administrateurs` (hachage `password_hash` / `password_verify`) et ouvre
  une session administrateur.
- `logout.php` : ferme la session.
- `admin/` : espace protégé par session (`garde.php`) :
  - `index.php` : liste des citations + formulaire d'ajout
  - `ajouter.php`, `modifier.php`, `supprimer.php` : CRUD complet
- `images/fond1.svg` à `fond5.svg` : visuels de fond du carrousel (dégradés
  ciel + silhouettes, dessinés en SVG, pas de dépendance externe).

## Installation

1. Démarrer WampServer (MySQL + Apache).
2. Importer `sql/creation_bdd.sql` (phpMyAdmin, ou en ligne de commande) :
   ce script crée la base, les tables et les deux comptes MySQL. Il doit
   être exécuté avec un compte ayant les droits `GRANT` (ex : `root`).
3. Ouvrir `http://localhost/TP4/`.

## Compte administrateur par défaut

- Identifiant : `admin`
- Mot de passe : `admin123`

## Notes

- Les mots de passe administrateur sont stockés hachés (`PASSWORD_DEFAULT`),
  jamais en clair.
- Les requêtes SQL utilisent des requêtes préparées PDO (protection contre
  les injections SQL).
- Le texte affiché (citations, auteurs) est échappé avec `htmlspecialchars`
  côté HTML (protection XSS).
