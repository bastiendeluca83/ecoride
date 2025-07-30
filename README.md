# 🚗 EcoRide – Plateforme de covoiturage écologique

Projet réalisé dans le cadre du Titre Professionnel Développeur Web & Web Mobile (DWWM)

## 🧪 Stack technique

- Frontend : HTML, CSS, Bootstrap
- Backend : PHP (PDO)
- BDD relationnelle : MySQL (via Docker)
- BDD NoSQL : MongoDB
- Déploiement local : Docker + docker-compose

## 🗂️ Structure

- `/frontend` : fichiers HTML, CSS, interface utilisateur
- `/backend/src` : scripts PHP, logique serveur
- `/database/init.sql` : script de création des tables
- `docker-compose.yml` : configuration complète des services

## 👤 Identifiants par défaut

| Rôle  | Login  | Mot de passe |
|-------|--------|---------------|
| Admin | admin  | test123       |

## 🚀 Lancer le projet en local

```bash
docker compose up -d
