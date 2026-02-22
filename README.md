# LilBook 📚

LilBook est un site web développée en PHP permettant de gérer une bibliothèque en ligne.
Elle propose un système d’authentification avec rôles (utilisateur / administrateur) ainsi qu’un CRUD complet pour la gestion des livres.

## 👤 Auteur
ABBAR LOUBNA

## 🚀 Fonctionnalités
- Inscription et connexion sécurisée (bcrypt)
- Gestion des rôles (user / admin)
- Affichage public des livres
- Ajout, modification et suppression de livres (admin uniquement)
- Protection CSRF
- Slug unique pour chaque livre
- Interface responsive et moderne

## 🔧 Installation
1. Importer `sql/lilbook.sql` dans phpMyAdmin
2. Configurer `includes/db.php` avec vos identifiants MySQL
3. Accéder au site via localhost

## 👑 Comptes par défaut
- **Admin** : `admin` / `admin123`
- **User** : `user` / `password`

## 📁 Structure
- `index.php` - Accueil public
- `login/register.php` - Authentification
- `admin/` - Espace administrateur
- `includes/` - Fichiers de configuration
- `assets/` - CSS