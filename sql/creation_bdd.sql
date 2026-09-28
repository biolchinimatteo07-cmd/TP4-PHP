-- TP4 - Dictionnaire de citations littéraires interactif
-- Version pour hébergement mutualisé (InfinityFree) :
-- la base existe déjà (créée depuis le panneau de contrôle), on ne fait
-- qu'y créer les tables et insérer les données de départ. Pas de
-- CREATE DATABASE / CREATE USER / GRANT : l'hébergement mutualisé ne les
-- autorise pas.

SET NAMES utf8mb4;

-- Table des citations
CREATE TABLE IF NOT EXISTS citations (
    id_citation INT AUTO_INCREMENT PRIMARY KEY,
    auteur VARCHAR(150) NOT NULL,
    citation TEXT NOT NULL,
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table des administrateurs (authentification du domaine administrateur)
CREATE TABLE IF NOT EXISTS administrateurs (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    identifiant VARCHAR(50) UNIQUE NOT NULL,
    mot_passe VARCHAR(255) NOT NULL
);

-- Citations de démonstration
INSERT INTO citations (auteur, citation) VALUES
('Paulo Coelho', 'La vie est un mystère qu''il faut vivre, et non un problème à résoudre.'),
('Victor Hugo', 'La forme, c''est le fond qui remonte à la surface.'),
('Albert Camus', 'Vivre, c''est faire vivre en soi tous les paradoxes.'),
('Antoine de Saint-Exupéry', 'On ne voit bien qu''avec le cœur. L''essentiel est invisible pour les yeux.'),
('Marcel Proust', 'Le seul véritable voyage, ce ne serait pas d''aller vers de nouveaux paysages, mais d''avoir d''autres yeux.');

-- Compte administrateur par défaut : identifiant "admin", mot de passe "admin123"
-- (mot de passe haché avec password_hash() / PASSWORD_DEFAULT côté PHP)
INSERT INTO administrateurs (identifiant, mot_passe) VALUES
('admin', '$2y$10$tfifXSiYX5Omvg.NMSDSheuj4Bu/NL9h8bPtgM7OmhB4SmWBbWH7W');
