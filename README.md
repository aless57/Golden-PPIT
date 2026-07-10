# 🎉 Golden-PPIT

**Plateforme web collaborative de gestion d'événements** — création d'événements, invitations, gestion partagée des besoins (matériel, tâches), notifications et calendrier intégré.

> 📚 Projet de groupe (équipe de 5+) réalisé en Licence 3 Informatique dans le cadre du module PPIT (Projet Professionnel d'Ingénierie et de Technologie). Non maintenu, conservé comme trace de mon apprentissage du développement web full-stack.

## ✨ Fonctionnalités

- 🔐 **Comptes utilisateurs** — inscription, connexion, modification, suppression, réinitialisation de mot de passe par email
- 📅 **Gestion d'événements** — création, modification, suppression, consultation, calendrier
- ✉️ **Invitations & notifications** — inviter des participants, système de notifications intégré
- 🎯 **Répartition des besoins** — ajout, association et proposition de besoins entre participants d'un événement
- 🗺️ **Localisation** — sélection basée sur la base des communes de France
- 📮 **Formulaire de contact**

## 🛠️ Stack technique

**Backend**
- PHP 7+
- [Slim Framework](https://www.slimframework.com/) — micro-framework HTTP
- [Eloquent ORM](https://laravel.com/docs/eloquent) — ORM Laravel (utilisé en standalone)
- MySQL

**Frontend**
- JavaScript
- SCSS / CSS
- Templates PHP

**Architecture**
- Pattern MVC (controllers séparés par domaine : Compte, Événement, Notification, Contact)
- Routing centralisé dans `index.php`

## 📂 Structure du projet

```
Golden-PPIT/
├── config/          # Configuration BDD (config.ini à créer)
├── css/             # Feuilles de style compilées
├── images/          # Assets visuels
├── src/             # Contrôleurs, modèles, vues
├── tests/           # Tests unitaires
├── composer.json    # Dépendances PHP
├── goldenppit.sql   # Schéma de base de données
└── index.php        # Point d'entrée + routing
```

## 🚀 Installation

**Prérequis :** PHP 7+, Composer, MySQL/phpMyAdmin

```bash
# 1. Cloner le repo
git clone https://github.com/aless57/Golden-PPIT.git
cd Golden-PPIT

# 2. Installer les dépendances
composer install

# 3. Configurer la base de données
# - Créer une base "goldenppit" dans phpMyAdmin
# - Importer goldenppit.sql
# - Créer le fichier config/config.ini avec le format ci-dessous
```

**`config/config.ini` :**
```ini
driver=mysql
username=votre_user
password=votre_password
host=localhost
database=goldenppit
charset=utf8
collation=utf8_unicode_ci
```

Puis lancer le serveur PHP intégré depuis la racine :
```bash
php -S localhost:8000
```

## 👥 Équipe

Projet réalisé en équipe de 5+ étudiants dans le cadre du PPIT L3.

## 📄 Licence

Voir [LICENSE.md](LICENSE.md).
