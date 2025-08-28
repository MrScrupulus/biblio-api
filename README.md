# Biblio-API

Une application de gestion de bibliothèque avec une API backend Symfony et un frontend React.

## Structure du projet

```
biblio-api/
├── backend/          # API Symfony avec API Platform
│   ├── src/
│   │   ├── Entity/   # Entités (Author, Book, Editor)
│   │   ├── Controller/
│   │   └── Repository/
│   └── config/
└── frontend/         # Interface React
    ├── src/
    │   ├── components/
    │   └── pages/
    └── public/
```

## Technologies utilisées

- **Backend**: Symfony 6, API Platform, Doctrine ORM
- **Frontend**: React, CSS
- **Base de données**: MySQL/PostgreSQL

## Installation et configuration

### Backend

```bash
cd backend
composer install
```

### Frontend

```bash
cd frontend
npm install
```

## Dépôt Git

```
git@github.com:MrScrupulus/biblio-api.git
```

## Développement

Pour démarrer le développement :

1. Backend : `cd backend && symfony server:start`
2. Frontend : `cd frontend && npm start`

## Auteur

MrScrupulus
