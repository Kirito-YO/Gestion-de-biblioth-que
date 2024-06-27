# Projet : Gestion de Bibliothèque en Ligne

## Description

Le projet "Gestion de Bibliothèque en Ligne" est une application web qui permet de gérer les livres d'une bibliothèque universitaire. Les fonctionnalités principales incluent l'ajout, la mise à jour, l'emprunt, le retour, la vente et le téléchargement de livres. L'application distingue les utilisateurs en fonction de leurs rôles (administrateurs, étudiants, utilisateurs externes) et fournit une interface utilisateur intuitive grâce à l'utilisation de HTML, CSS (avec Bootstrap) et PHP.

## Fonctionnalités

- **Ajout et mise à jour de livres** : Permet aux administrateurs d'ajouter de nouveaux livres et de mettre à jour les livres existants, avec la possibilité de télécharger des fichiers PDF et des affiches.
- **Gestion des utilisateurs** : Authentification des utilisateurs avec des rôles différents (administrateurs, étudiants, utilisateurs externes).
- **Emprunts et retours de livres** : Permet aux utilisateurs connectés d'emprunter et de retourner des livres.
- **Recherche de livres** : Fonctionnalité de recherche pour trouver des livres spécifiques.
- **Vente de livres** : Les utilisateurs externes peuvent acheter des livres sans créer de compte.
- **Téléchargement de livres numériques** : Téléchargement de livres en format PDF pour les utilisateurs connectés.

## Prérequis

- XAMPP ou tout autre serveur web local avec support PHP et MySQL.
- Navigateur web moderne (Chrome, Firefox, etc.).

## Installation

1. Clonez le dépôt GitHub :
    ```bash
    git clone https://github.com/Kirito-YO/Gestion-de-biblioth-que.git
    ```
2. Déplacez-vous dans le répertoire du projet :
    ```bash
    cd gestion-de*
    ```
3. Placez le répertoire du projet dans le répertoire `htdocs` de XAMPP.
4. Importez la base de données MySQL :
    - Ouvrez phpMyAdmin et créez une nouvelle base de données nommée `library`.
    - Importez le fichier `library.sql` dans cette base de données.
5. Modifiez le fichier `db.php` pour configurer les paramètres de connexion à la base de données :
    ```php
    $conn = new mysqli('localhost', 'root', '', 'library');
    ```
6. Lancez XAMPP et démarrez les modules Apache et MySQL.
7. Ouvrez votre navigateur web et accédez à l'application :
    ```
    http://localhost/Gestion-de-biblioth-que
    ```

## Utilisation

### Page d'Accueil

Affiche la liste des livres disponibles avec des options pour visualiser les détails, emprunter et télécharger des livres.

### Page de Gestion des Livres (Administrateurs)

Permet aux administrateurs d'ajouter ou de mettre à jour des livres, y compris le téléchargement de fichiers PDF et d'affiches.

### Formulaire d'Ajout/Mise à Jour de Livre

Formulaire permettant de saisir les informations du livre et de télécharger des fichiers PDF et des affiches.

## Code Principal

### index.php

Affiche la liste des livres disponibles.

### books.php

Page de gestion des livres pour les administrateurs.

## Contribution

Les contributions sont les bienvenues ! Veuillez suivre les étapes ci-dessous pour contribuer au projet :

1. Fork le projet.
2. Créez une nouvelle branche (`git checkout -b ma-nouvelle-fonctionnalité`).
3. Faites vos modifications et commitez-les (`git commit -am 'Ajout d'une nouvelle fonctionnalité'`).
4. Poussez les modifications vers la branche (`git push origin ma-nouvelle-fonctionnalité`).
5. Créez une Pull Request.


## Auteurs

- **OURRADI Youssef** - *Développeur Principal* - [Kirito-YO](https://github.com/Kirito-YO)