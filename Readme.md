# Confuguration

<h1>Requirement</h1>

* serveur apache

* mariadb ou mysql

* serveur php

<h1>Création base de données</h1>

-- 1. Créer une base de données nommée `chuck_citation`.
CREATE DATABASE chuck_citation;

-- 2. Créer un utilisateur avec un mot de passe sécurisé.
CREATE USER 'hugoruff'@'%' IDENTIFIED BY 'hugorouff';

-- 3. Donner tous les privilèges à l'utilisateur sur la base de données.
GRANT ALL PRIVILEGES ON chuck_citation.* TO 'hugorouff'@'%';

-- 4. Utiliser la base de données nouvellement créée.
USE chuck_citation;

-- 5. Créer la table `citations`.
CREATE TABLE citations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texte TEXT NOT NULL
    auteur VARCHAR(255) NOT NULL,
    
);

-- 6. Appliquer les changements (optionnel si l'auto-commit est activé).
FLUSH PRIVILEGES;

<h1>Important</h1>

MANGER DU POULET et balancer des citations sur Chuck Norris
