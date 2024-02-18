# Projet SAE 4.01 - Développement Web - Musics 2024

## 🖈 Rendu dans CELENE
- [Dépôt GitHub](https://github.com/Nathan-Pigoreau/Sae_PHP.git)
- Liste des membres du groupe: Nathan PIGOREAU, Daniel MALLERON, Samuel NIVEAU
- Enseignants à mettre en reporter sur le dépôt: C.DALAIGRE

## Documentations demandées
1. ### Présentation
   À partir des données disponibles dans le fichier `extrait.yml` dans Celene, l'objectif est de créer une application présentant le contenu de cette base d'albums de musique, comprenant des informations sur les albums, les artistes, et les pochettes d'albums.

2. ### Fonctionnalités attendues
    2.1 **Affichage des albums**
    - Affichage de la liste des albums disponibles.

    2.2 **Détail des albums**
    - Affichage détaillé des informations sur un album sélectionné.

    2.3 **Détail d’un artiste avec ses albums**
    - Affichage des détails d'un artiste et de la liste de ses albums associés.

    2.4 **Recherche avancée dans les albums**
    - Possibilité de recherche par artiste, genre, année, etc.

3. ### Fonctionnalités souhaitées
    3.1 **CRUD pour un album**
    - Création, lecture, mise à jour et suppression d'un album.

    3.2 **CRUD pour un artiste**
    - Création, lecture, mise à jour et suppression d'un artiste.

4. ### Fonctionnalités possibles
    4.1 **Inscription / Login Utilisateur**
    - Système d'inscription et de connexion pour les utilisateurs.

    4.2 **Playlist par utilisateur**
    - Possibilité pour les utilisateurs de créer et gérer des playlists.

    4.3 **Système de notation des albums**
    - Mise en place d'un système de notation pour les albums.

5. ### Contraintes
    5.1 **Organisation du code dans une arborescence cohérente**
    - Structurez le code de manière logique et claire.

    5.2 **Utilisation des namespaces**
    - Utilisez des namespaces pour organiser votre code.

    5.3 **Utilisation d’un provider pour charger le fichier YAML**
    - Mettez en œuvre un provider pour charger le fichier YAML.

    5.4 **Utilisation d'un autoloader pour charger les classes d’objets nécessaires**
    - Utilisez un autoloader pour charger les classes d'objets nécessaires.

    5.5 **Utilisation de PDO avec base de données sqlite**
    - Utilisez PDO avec une base de données SQLite.

    5.6 **Utilisation de sessions**
    - Intégrez l'utilisation de sessions.

    5.7 **Mise en place CSS**
    - Mettez en place le style CSS pour améliorer l'interface.

## Documentations
6.1 **Modèle Conceptuel de Données pour la BDD**
    - [Fichier diagramme.pdf](diagramme.pdf)

6.2 **Diagramme des classes présentes dans votre code**
    - [Fichier diagramme.pdf](diagramme.pdf)

6.3 **Diagramme d’activité**
    - [Fichier diagramme.pdf](diagramme.pdf)

6.4 **Diagramme de séquence**
    - [Fichier diagramme.pdf](diagramme.pdf)

6.5 **Requirements**
    - Requirement : Php et PDO version 8.3.0

### Consigne pour lancer l'application
- Cloner le dépôt GitHub [Sae_PHP](https://github.com/Nathan-Pigoreau/Sae_PHP.git)
- Initialiser la base de donnée avec la commande `php ./Data/creaDB.php`
- Charger les données de base avec la commande `php ./Data/insertDB.php`
- Lancer le serveur avec la commande `php -S localhost:8000`
