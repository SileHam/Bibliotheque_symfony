# Bibliothèque Symfony

Application web de gestion de bibliothèque développée avec Symfony 6.4 et PHP 8.0.2+.

## Description

Cette application permet de gérer une collection de livres avec leurs auteurs et genres. Elle inclut un système d'authentification des utilisateurs avec des rôles (USER/ADMIN) et des fonctionnalités CRUD complètes.

## Fonctionnalités

### Pour tous les utilisateurs
- Consultation de la liste des livres (paginée)
- Recherche de livres par titre
- Affichage des détails d'un livre
- Consultation de la liste des auteurs et leurs livres
- Consultation de la liste des genres
- Inscription et connexion

### Pour les administrateurs (ROLE_ADMIN)
- CRUD complet sur les livres (création, modification, suppression)
- CRUD complet sur les auteurs
- CRUD complet sur les genres
- Gestion des utilisateurs

## Technologies utilisées

- **Framework** : Symfony 6.4.*
- **PHP** : >= 8.0.2
- **Base de données** : MySQL/MariaDB (via Doctrine ORM)
- **Templating** : Twig 2.12/3.0
- **ORM** : Doctrine 2.10
- **CSS Framework** : Bootstrap 5.3.0
- **Icons** : Font Awesome 6.4.0

## Prérequis

- PHP >= 8.0.2
- Composer
- MySQL/MariaDB
- Extensions PHP : `ext-ctype`, `ext-iconv`

## Installation

1. **Cloner le projet**
   ```bash
   git clone https://github.com/VOTRE-USERNAME/VOTRE-REPO.git
   cd bookstore
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   ```

3. **Configurer la base de données**
   
   Modifier le fichier `.env` avec vos informations de base de données :
   ```
   DATABASE_URL="mysql://user:password@127.0.0.1:3306/bibliotheque?serverVersion=8.0&charset=utf8mb4"
   ```

4. **Créer la base de données**
   ```bash
   php bin/console doctrine:database:create
   ```

5. **Exécuter les migrations**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

6. **Charger les données de test (optionnel)**
   ```bash
   php bin/console doctrine:fixtures:load
   ```

7. **Lancer le serveur de développement**
   ```bash
   symfony server:start
   # ou
   php -S localhost:8000 -t public
   ```

8. **Accéder à l'application**
   - URL : `http://localhost:8000`

## Comptes par défaut (après chargement des fixtures)

- **Administrateur** :
  - Email : `admin@bookstore.com`
  - Mot de passe : `admin123`

- **Utilisateur** :
  - Email : `user@bookstore.com`
  - Mot de passe : `user123`

## Structure du projet

```
bookstore/
├── bin/                  # Scripts exécutables
├── config/               # Configurations
├── migrations/           # Migrations de base de données
├── public/               # Point d'entrée public
├── src/                  # Code source
│   ├── Controller/       # Contrôleurs
│   ├── Entity/          # Entités Doctrine
│   ├── Form/            # Formulaires
│   ├── Repository/      # Repositories
│   ├── DataFixtures/    # Données de test
│   └── Security/        # Configuration de sécurité
├── templates/           # Templates Twig
└── tests/               # Tests unitaires
```

## Commandes utiles

- Créer une migration : `php bin/console make:migration`
- Exécuter les migrations : `php bin/console doctrine:migrations:migrate`
- Charger les fixtures : `php bin/console doctrine:fixtures:load`
- Vider le cache : `php bin/console cache:clear`
- Créer un utilisateur : `php bin/console make:user`

## Licence

Proprietary

## Auteur

Votre nom
