# Flow ERP Backend (v1)

Flow ERP Backend est une API construite avec Laravel, conteneurisée à l'aide de Docker. Ce projet est la **version 1** du backend, offrant une base solide pour la gestion des données métier. Il utilise Laravel pour la logique backend, MariaDB pour la base de données, et Docker Compose pour l'orchestration des conteneurs.

---

## Prérequis

Assurez-vous d'avoir les outils suivants installés sur votre machine :

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

---

## Initialisation du projet

Suivez les étapes ci-dessous pour configurer et lancer le projet :

### 1. Clonez le dépôt

Clonez le dépôt sur votre machine locale :

```bash
git clone https://github.com/Mvthis/flow-erp
cd flow-erp-backend
```

### 2. Configurez les variables d'environnement

Dupliquez le fichier .env.example et renommez-le en .env :

```bash
cp .env.example .env
```

Vérifiez que les variables suivantes sont correctement définies dans le fichier .env :
```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel-user
DB_PASSWORD=securepassword
```

### 3. Lancez les conteneurs Docker

Démarrez les conteneurs Docker avec la commande suivante :

```bash
docker-compose up --build
```
- Cette commande construira les conteneurs et lancera l'application ainsi que la base de données.
- Cela peut prendre quelques minutes lors du premier démarrage.

### 4. Exécutez les migrations

Une fois les conteneurs lancés, exécutez les migrations pour configurer la base de données :

```bash
docker exec -it laravel_app php artisan migrate
```

### 5. Vérifiez l'état des conteneurs
Assurez-vous que les conteneurs laravel_app et laravel_db sont en cours d'exécution :

```bash
docker ps
```

# Accéder à l'API

L'API sera disponible sur l'adresse suivante une fois les conteneurs démarrés :

```bash
http://localhost:8000
```

## Test des requêtes avec Postman

### Importation de la collection Postman
Une collection Postman dédiée est disponible pour tester facilement les différentes routes de l'API. Suivez ces étapes pour l'utiliser :

    1. Téléchargez le fichier Postman JSON : Ce fichier se trouve dans le dépôt, nommé Flow-ERP-Backend.postman_collection.json.

    2. Ouvrez Postman.

    3. Cliquez sur Importer dans le coin supérieur gauche.

    4. Glissez-déposez ou sélectionnez le fichier Flow-ERP-Backend.postman_collection.json.
    
    5. Vous pouvez maintenant tester les requêtes configurées dans la collection.


## Fonctionnalités actuelles

### V1 (Backend uniquement)

    1. Création, lecture, mise à jour et suppression (CRUD) des entités principales.
    2. Gestion des utilisateurs et des produits.
    3. Authentification via token (Laravel Sanctum).

## À venir 🚀

Ce projet est en constante évolution. Voici un aperçu des prochaines étapes prévues :

    1. Frontend :
        -   Développement d'un frontend moderne en Vue.js.
        - Intégration avec ce backend pour une expérience utilisateur complète.

    2. Nouvelles fonctionnalités :
        - Gestion avancée des droits utilisateur (RBAC).
        - Tableau de bord interactif avec statistiques.
        - Génération automatisée de rapports PDF.

    3. Tests et CI/CD :
        - Couverture des tests pour assurer la qualité du code.
        - Intégration d'un pipeline CI/CD pour automatiser les déploiements.


## Commandes utiles

### Arrêter les conteneurs
Pour arrêter les conteneurs Docker sans les supprimer :
```bash
docker-compose stop
```

### Redémarrer les conteneurs
Pour redémarrer les conteneurs :
```bash
docker-compose start
```

### Supprimer les conteneurs et les volumes
Pour arrêter et supprimer tous les conteneurs et leurs volumes associés :
```bash
docker-compose down --volumes
```

## Auteur

Créé par Mathis.# flow-erp
