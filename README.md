# 👥 Application Web de Gestion des Personnes

## 📖 1. DESCRIPTION DU PROJET

Cette application web permet de gérer un répertoire de contacts/personnes avec des fonctionnalités complètes de création, lecture, modification et suppression (CRUD). Elle est développée avec le framework Laravel et intègre un système d'authentification sécurisé basé sur JWT (JSON Web Token).

### Objectif principal
Fournir une plateforme intuitive pour gérer une base de données de personnes avec recherche, filtrage et pagination.

### Fonctionnalités clés
- **Authentification sécurisée** : Inscription, connexion et déconnexion avec JWT
- **Gestion complète des personnes** : Ajouter, modifier, supprimer et lister des contacts
- **Recherche avancée** : Rechercher par nom, prénom, email ou téléphone
- **Filtrage** : Filtrer les personnes par ville
- **Pagination** : Navigation facile avec 10 résultats par page
- **Interface responsive** : Compatible mobile, tablette et desktop
- **Validation des données** : Sécurité et intégrité des informations

### Technologies utilisées
- **Backend** : Laravel 10.x, PHP 8.2, MySQL
- **Frontend** : Bootstrap 5, Blade Templates, Font Awesome
- **Sécurité** : JWT Authentication (php-open-source-saver/jwt-auth)
- **Serveur local** : XAMPP (Apache + MySQL)

---

## ⚙️ 2. COMMENT L'APPLICATION FONCTIONNE

### Architecture MVC (Model-View-Controller)

L'application suit le pattern MVC de Laravel :

#### **Models (Modèles)**
- `User.php` : Représente un utilisateur de l'application (pour l'authentification)
- `Person.php` : Représente une personne dans le répertoire

#### **Controllers (Contrôleurs)**
- `AuthController.php` : Gère l'inscription, la connexion et la déconnexion
- `PersonController.php` : Gère toutes les opérations CRUD sur les personnes

#### **Views (Vues)**
- Pages d'authentification : `login.blade.php`, `register.blade.php`
- Pages de gestion : `index.blade.php` (liste), `create.blade.php` (ajout), `edit.blade.php` (modification)

### Flux de fonctionnement

#### 1. **Inscription d'un utilisateur**
```
Utilisateur → Formulaire d'inscription → Validation des données → 
Hachage du mot de passe → Enregistrement en base → Génération token JWT → 
Stockage en session → Redirection vers la liste des personnes
```

#### 2. **Connexion**
```
Utilisateur → Email + Password → Vérification en base de données → 
Génération token JWT → Stockage en session → Accès aux routes protégées
```

#### 3. **Protection des routes**
```
Requête utilisateur → Middleware JwtMiddleware → Vérification du token → 
Si valide : Accès autorisé | Si invalide : Redirection vers login
```

#### 4. **Ajout d'une personne**
```
Utilisateur connecté → Formulaire d'ajout → Validation (email unique, champs requis) → 
Enregistrement en base → Message de succès → Affichage dans la liste
```

#### 5. **Recherche et filtrage**
```
Utilisateur → Saisie de recherche/filtre → Requête SQL avec LIKE → 
Résultats filtrés → Affichage paginé
```

### Base de données

**Table `users`** : Stocke les comptes utilisateurs
- id, name, email, password, created_at, updated_at

**Table `people`** : Stocke les personnes/contacts
- id, nom, prenom, email, telephone, ville, date_naissance, created_at, updated_at

### Système de sécurité JWT

1. Lors de la connexion, un token JWT est généré contenant l'ID de l'utilisateur
2. Le token est stocké dans la session PHP
3. À chaque requête vers une route protégée, le middleware vérifie le token
4. Le token expire après 60 minutes (configurable)
5. Lors de la déconnexion, le token est invalidé

---

## 🚀 3. ÉTAPES POUR INSTALLER L'APPLICATION

### Prérequis

Assurez-vous d'avoir installé :
- **XAMPP** (ou Apache + MySQL + PHP 8.1+)
- **Composer** (gestionnaire de dépendances PHP)
- **Git**

### Installation complète

#### Étape 1 : Cloner le projet
```bash
git clone https://github.com/votre-username/gestion-personnes.git
cd gestion-personnes
```

#### Étape 2 : Installer les dépendances PHP
```bash
composer install
```

#### Étape 3 : Configurer l'environnement
```bash
# Copier le fichier d'exemple
cp .env.example .env

# Générer la clé d'application Laravel
php artisan key:generate
```

#### Étape 4 : Installer et configurer JWT
```bash
# Installer le package JWT
composer require php-open-source-saver/jwt-auth

# Publier la configuration JWT
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"

# Générer la clé secrète JWT
php artisan jwt:secret
```

#### Étape 5 : Créer la base de données

1. Démarrez XAMPP et lancez **Apache** et **MySQL**
2. Ouvrez **phpMyAdmin** : http://localhost/phpmyadmin
3. Créez une nouvelle base de données :
```sql
CREATE DATABASE gestion_personnes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Étape 6 : Configurer la connexion à la base de données

Modifiez le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_personnes
DB_USERNAME=root
DB_PASSWORD=
```

#### Étape 7 : Exécuter les migrations
```bash
php artisan migrate
```

Cette commande créera automatiquement les tables `users` et `people` dans votre base de données.

#### Étape 8 : (Optionnel) Ajouter des données de test
```bash
php artisan tinker
```
Puis dans le shell Tinker :
```php
\App\Models\User::create([
    'name' => 'Admin Test',
    'email' => 'admin@test.com',
    'password' => bcrypt('password123')
]);

\App\Models\Person::create([
    'nom' => 'Trabelsi',
    'prenom' => 'Mohamed',
    'email' => 'mohamed@example.com',
    'telephone' => '98765432',
    'ville' => 'Tunis',
    'date_naissance' => '1990-05-15'
]);
```

---

## 🎯 4. COMMANDES POUR LANCER LE PROJET

### Démarrage de l'application

#### 1. Démarrer XAMPP
- Ouvrez le panneau de contrôle XAMPP
- Cliquez sur **Start** pour **Apache** et **MySQL**

#### 2. Lancer le serveur Laravel
```bash
cd gestion-personnes
php artisan serve
```

**Sortie attendue :**
```
INFO  Server running on [http://127.0.0.1:8000]
```

#### 3. Accéder à l'application
Ouvrez votre navigateur et allez à : **http://127.0.0.1:8000**

### Commandes utiles de développement

#### Vider tous les caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### Réinitialiser la base de données
```bash
# Supprime toutes les tables et recrée tout
php artisan migrate:fresh
```

#### Voir toutes les routes disponibles
```bash
php artisan route:list
```

#### Lancer sur un port différent
```bash
php artisan serve --port=8080
```

#### Mode debug
Dans le fichier `.env`, assurez-vous que :
```env
APP_DEBUG=true
```

#### Optimisation pour la production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 📡 5. DOCUMENTATION COMPLÈTE DES API

### Configuration de base

**Base URL :** `http://127.0.0.1:8000`

**Format des réponses :** HTML (redirections avec messages flash) ou JSON (si configuré)

**Authentication :** JWT Token stocké en session PHP

---

## 🔐 ENDPOINTS D'AUTHENTIFICATION

### 1. Afficher la page d'inscription

**Méthode :** `GET`  
**Endpoint :** `/register`  
**Auth requis :** Non

**Description :** Affiche le formulaire d'inscription

**Réponse :**
- **200 OK** : Page HTML du formulaire d'inscription

**Exemple de requête :**
```bash
curl http://127.0.0.1:8000/register
```

---

### 2. Créer un compte (Inscription)

**Méthode :** `POST`  
**Endpoint :** `/register`  
**Auth requis :** Non

**Description :** Crée un nouveau compte utilisateur et génère un token JWT

**Paramètres (Body - form-data) :**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| name | string | Oui | Nom complet de l'utilisateur (max 255 caractères) |
| email | string | Oui | Email unique (format valide) |
| password | string | Oui | Mot de passe (minimum 6 caractères) |
| password_confirmation | string | Oui | Confirmation du mot de passe (doit correspondre) |

**Exemple de requête :**
```bash
curl -X POST http://127.0.0.1:8000/register \
  -d "name=Ahmed Ben Salem" \
  -d "email=ahmed@example.com" \
  -d "password=123456" \
  -d "password_confirmation=123456"
```

**Réponse succès :**
- **302 Found** : Redirection vers `/people`
- Message flash : "Inscription réussie!"
- Token JWT stocké en session

**Erreurs possibles :**
- **422 Unprocessable Entity** : Validation échouée
  ```json
  {
    "message": "The email has already been taken.",
    "errors": {
      "email": ["The email has already been taken."]
    }
  }
  ```

---

### 3. Afficher la page de connexion

**Méthode :** `GET`  
**Endpoint :** `/login`  
**Auth requis :** Non

**Description :** Affiche le formulaire de connexion

**Réponse :**
- **200 OK** : Page HTML du formulaire de connexion

**Exemple de requête :**
```bash
curl http://127.0.0.1:8000/login
```

---

### 4. Se connecter

**Méthode :** `POST`  
**Endpoint :** `/login`  
**Auth requis :** Non

**Description :** Authentifie un utilisateur et génère un token JWT

**Paramètres (Body - form-data) :**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| email | string | Oui | Email du compte |
| password | string | Oui | Mot de passe |

**Exemple de requête :**
```bash
curl -X POST http://127.0.0.1:8000/login \
  -d "email=ahmed@example.com" \
  -d "password=123456"
```

**Réponse succès :**
- **302 Found** : Redirection vers `/people`
- Message flash : "Connexion réussie!"
- Token JWT : `eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...` (stocké en session)
- Nom d'utilisateur stocké en session

**Erreurs possibles :**
- **422 Unprocessable Entity** : Identifiants incorrects
  ```json
  {
    "message": "Email ou mot de passe incorrect",
    "errors": {
      "email": ["Email ou mot de passe incorrect"]
    }
  }
  ```

---

### 5. Se déconnecter

**Méthode :** `POST`  
**Endpoint :** `/logout`  
**Auth requis :** Oui (Token JWT)

**Description :** Déconnecte l'utilisateur et invalide le token JWT

**Headers requis :**
```
Authorization: Bearer {votre_token_jwt}
```

**Exemple de requête :**
```bash
curl -X POST http://127.0.0.1:8000/logout \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc..."
```

**Réponse succès :**
- **302 Found** : Redirection vers `/login`
- Message flash : "Déconnexion réussie!"
- Token JWT invalidé
- Session supprimée

---

## 👥 ENDPOINTS DE GESTION DES PERSONNES

### 6. Lister toutes les personnes

**Méthode :** `GET`  
**Endpoint :** `/people`  
**Auth requis :** Oui (Token JWT)

**Description :** Affiche la liste paginée de toutes les personnes avec possibilité de recherche et filtrage

**Headers requis :**
```
Authorization: Bearer {votre_token_jwt}
```

**Paramètres Query (optionnels) :**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| search | string | Non | Recherche dans nom, prénom, email, téléphone |
| ville | string | Non | Filtre par ville |
| page | integer | Non | Numéro de page (défaut: 1) |

**Exemples de requêtes :**

```bash
# Liste complète (page 1)
curl http://127.0.0.1:8000/people \
  -H "Authorization: Bearer {token}"

# Recherche par nom
curl http://127.0.0.1:8000/people?search=mohamed \
  -H "Authorization: Bearer {token}"

# Filtre par ville
curl http://127.0.0.1:8000/people?ville=Tunis \
  -H "Authorization: Bearer {token}"

# Recherche + filtre + pagination
curl "http://127.0.0.1:8000/people?search=ahmed&ville=Sousse&page=2" \
  -H "Authorization: Bearer {token}"
```

**Réponse succès :**
- **200 OK** : Page HTML avec tableau des personnes

**Structure des données affichées :**
```
| ID | Nom | Prénom | Email | Téléphone | Ville | Date de naissance | Actions |
|----|-----|--------|-------|-----------|-------|-------------------|---------|
| 1  | Trabelsi | Mohamed | m@ex.com | 98765432 | Tunis | 15/05/1990 | ✏️ 🗑️ |
```

**Pagination :**
- 10 personnes par page
- Liens de navigation (Précédent, 1, 2, 3, Suivant)
- Conservation des paramètres de recherche/filtre

**Erreurs possibles :**
- **401 Unauthorized** : Token invalide ou expiré
- **302 Found** : Redirection vers `/login` si non authentifié

---

### 7. Afficher le formulaire d'ajout

**Méthode :** `GET`  
**Endpoint :** `/people/create`  
**Auth requis :** Oui (Token JWT)

**Description :** Affiche le formulaire pour ajouter une nouvelle personne

**Headers requis :**
```
Authorization: Bearer {votre_token_jwt}
```

**Exemple de requête :**
```bash
curl http://127.0.0.1:8000/people/create \
  -H "Authorization: Bearer {token}"
```

**Réponse succès :**
- **200 OK** : Page HTML avec formulaire d'ajout

**Champs du formulaire :**
- Nom * (requis)
- Prénom * (requis)
- Email * (requis, unique)
- Téléphone (optionnel)
- Ville (optionnel)
- Date de naissance (optionnel)

---

### 8. Ajouter une personne

**Méthode :** `POST`  
**Endpoint :** `/people`  
**Auth requis :** Oui (Token JWT)

**Description :** Crée une nouvelle personne dans la base de données

**Headers requis :**
```
Authorization: Bearer {votre_token_jwt}
Content-Type: application/x-www-form-urlencoded
```

**Paramètres (Body - form-data) :**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| nom | string | Oui | Nom de famille (max 255 caractères) |
| prenom | string | Oui | Prénom (max 255 caractères) |
| email | string | Oui | Email unique (format valide) |
| telephone | string | Non | Numéro de téléphone (max 20 caractères) |
| ville | string | Non | Ville de résidence (max 255 caractères) |
| date_naissance | date | Non | Date de naissance (format: YYYY-MM-DD) |

**Exemple de requête :**
```bash
curl -X POST http://127.0.0.1:8000/people \
  -H "Authorization: Bearer {token}" \
  -d "nom=Trabelsi" \
  -d "prenom=Mohamed" \
  -d "email=mohamed@example.com" \
  -d "telephone=98765432" \
  -d "ville=Tunis" \
  -d "date_naissance=1990-05-15"
```

**Réponse succès :**
- **302 Found** : Redirection vers `/people`
- Message flash : "Personne ajoutée avec succès!"

**Erreurs possibles :**
- **422 Unprocessable Entity** : Validation échouée
  ```json
  {
    "message": "The email has already been taken.",
    "errors": {
      "email": ["The email has already been taken."],
      "nom": ["The nom field is required."]
    }
  }
  ```

---

### 9. Afficher le formulaire de modification

**Méthode :** `GET`  
**Endpoint :** `/people/{id}/edit`  
**Auth requis :** Oui (Token JWT)

**Description :** Affiche le formulaire pré-rempli pour modifier une personne

**Headers requis :**
```
Authorization: Bearer {votre_token_jwt}
```

**Paramètres URL :**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| id | integer | Oui | ID de la personne à modifier |

**Exemple de requête :**
```bash
curl http://127.0.0.1:8000/people/1/edit \
  -H "Authorization: Bearer {token}"
```

**Réponse succès :**
- **200 OK** : Page HTML avec formulaire pré-rempli

**Erreurs possibles :**
- **404 Not Found** : Personne avec cet ID n'existe pas

---

### 10. Modifier une personne

**Méthode :** `PUT` (ou `POST` avec `_method=PUT`)  
**Endpoint :** `/people/{id}`  
**Auth requis :** Oui (Token JWT)

**Description :** Met à jour les informations d'une personne existante

**Headers requis :**
```
Authorization: Bearer {votre_token_jwt}
Content-Type: application/x-www-form-urlencoded
```

**Paramètres URL :**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| id | integer | Oui | ID de la personne à modifier |

**Paramètres (Body - form-data) :**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| _method | string | Oui | Doit être "PUT" |
| nom | string | Oui | Nom de famille |
| prenom | string | Oui | Prénom |
| email | string | Oui | Email (peut être le même que l'actuel) |
| telephone | string | Non | Téléphone |
| ville | string | Non | Ville |
| date_naissance | date | Non | Date de naissance |

**Exemple de requête :**
```bash
curl -X PUT http://127.0.0.1:8000/people/1 \
  -H "Authorization: Bearer {token}" \
  -d "_method=PUT" \
  -d "nom=Trabelsi" \
  -d "prenom=Mohamed" \
  -d "email=mohamed.updated@example.com" \
  -d "telephone=20123456" \
  -d "ville=Sfax" \
  -d "date_naissance=1990-05-15"
```

**Réponse succès :**
- **302 Found** : Redirection vers `/people`
- Message flash : "Personne modifiée avec succès!"

**Erreurs possibles :**
- **404 Not Found** : Personne n'existe pas
- **422 Unprocessable Entity** : Validation échouée (ex: email déjà utilisé par une autre personne)

---

### 11. Supprimer une personne

**Méthode :** `DELETE` (ou `POST` avec `_method=DELETE`)  
**Endpoint :** `/people/{id}`  
**Auth requis :** Oui (Token JWT)

**Description :** Supprime définitivement une personne de la base de données

**Headers requis :**
```
Authorization: Bearer {votre_token_jwt}
Content-Type: application/x-www-form-urlencoded
```

**Paramètres URL :**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| id | integer | Oui | ID de la personne à supprimer |

**Paramètres (Body - form-data) :**
| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| _method | string | Oui | Doit être "DELETE" |

**Exemple de requête :**
```bash
curl -X DELETE http://127.0.0.1:8000/people/1 \
  -H "Authorization: Bearer {token}" \
  -d "_method=DELETE"
```

**Réponse succès :**
- **302 Found** : Redirection vers `/people`
- Message flash : "Personne supprimée avec succès!"

**Erreurs possibles :**
- **404 Not Found** : Personne n'existe pas

---

## 📊 RÉCAPITULATIF DES ENDPOINTS

| # | Méthode | Endpoint | Description | Auth | Paramètres |
|---|---------|----------|-------------|------|------------|
| 1 | GET | `/register` | Formulaire d'inscription | Non | - |
| 2 | POST | `/register` | Créer un compte | Non | name, email, password, password_confirmation |
| 3 | GET | `/login` | Formulaire de connexion | Non | - |
| 4 | POST | `/login` | Se connecter | Non | email, password |
| 5 | POST | `/logout` | Se déconnecter | Oui | - |
| 6 | GET | `/people` | Liste des personnes | Oui | search?, ville?, page? |
| 7 | GET | `/people/create` | Formulaire d'ajout | Oui | - |
| 8 | POST | `/people` | Ajouter une personne | Oui | nom, prenom, email, telephone?, ville?, date_naissance? |
| 9 | GET | `/people/{id}/edit` | Formulaire de modification | Oui | id |
| 10 | PUT | `/people/{id}` | Modifier une personne | Oui | id, nom, prenom, email, telephone?, ville?, date_naissance? |
| 11 | DELETE | `/people/{id}` | Supprimer une personne | Oui | id |

---

## 🔑 CODES DE STATUT HTTP

| Code | Signification | Utilisation |
|------|---------------|-------------|
| 200 | OK | Requête réussie, page affichée |
| 302 | Found | Redirection après succès d'une action |
| 401 | Unauthorized | Non authentifié, token invalide |
| 404 | Not Found | Ressource (personne) non trouvée |
| 422 | Unprocessable Entity | Erreur de validation des données |

---

## 📝 EXEMPLES D'UTILISATION COMPLÈTE

### Scénario 1 : Inscription et ajout de personnes

```bash
# 1. S'inscrire
curl -X POST http://127.0.0.1:8000/register \
  -d "name=Ahmed Ben Salem" \
  -d "email=ahmed@example.com" \
  -d "password=123456" \
  -d "password_confirmation=123456"

# Le token JWT est automatiquement stocké en session

# 2. Ajouter une première personne
curl -X POST http://127.0.0.1:8000/people \
  -H "Authorization: Bearer {votre_token}" \
  -d "nom=Trabelsi" \
  -d "prenom=Mohamed" \
  -d "email=mohamed@example.com" \
  -d "telephone=98765432" \
  -d "ville=Tunis" \
  -d "date_naissance=1990-05-15"

# 3. Ajouter une deuxième personne
curl -X POST http://127.0.0.1:8000/people \
  -H "Authorization: Bearer {votre_token}" \
  -d "nom=Ben Ali" \
  -d "prenom=Fatma" \
  -d "email=fatma@example.com" \
  -d "telephone=22123456" \
  -d "ville=Sousse"

# 4. Voir la liste
curl http://127.0.0.1:8000/people \
  -H "Authorization: Bearer {votre_token}"
```

### Scénario 2 : Recherche et modification

```bash
# 1. Rechercher "Mohamed"
curl "http://127.0.0.1:8000/people?search=mohamed" \
  -H "Authorization: Bearer {votre_token}"

# 2. Modifier les infos de Mohamed (ID 1)
curl -X PUT http://127.0.0.1:8000/people/1 \
  -H "Authorization: Bearer {votre_token}" \
  -d "_method=PUT" \
  -d "nom=Trabelsi" \
  -d "prenom=Mohamed" \
  -d "email=mohamed.new@example.com" \
  -d "telephone=99887766" \
  -d "ville=Sfax" \
  -d "date_naissance=1990-05-15"
```

### Scénario 3 : Filtrage et suppression

```bash
# 1. Filtrer par ville "Tunis"
curl "http://127.0.0.1:8000/people?ville=Tunis" \
  -H "Authorization: Bearer {votre_token}"

# 2. Supprimer une personne (ID 2)
curl -X DELETE http://127.0.0.1:8000/people/2 \
  -H "Authorization: Bearer {votre_token}" \
  -d "_method=DELETE"

# 3. Se déconnecter
curl -X POST http://127.0.0.1:8000/logout \
  -H "Authorization: Bearer {votre_token}"
```

---

## 🐛 DÉBOGAGE ET RÉSOLUTION DE PROBLÈMES

### Erreur : "JWT secret not set"
**Solution :**
```bash
php artisan jwt:secret
```

### Erreur : "SQLSTATE[HY000] [1049] Unknown database"
**Solution :**
```bash
# Créer la base de données dans phpMyAdmin
# Puis vérifier le fichier .env
php artisan migrate
```

### Erreur : "Class 'App\Http\Middleware\JwtMiddleware' not found"
**Solution :**
```bash
# Vérifier que le middleware existe dans app/Http/Middleware/
# Vérifier qu'il est enregistré dans app/Http/Kernel.php
```

### Token expiré
**Solution :**
```bash
# Se reconnecter pour obtenir un nouveau token
curl -X POST http://127.0.0.1:8000/login \
  -d "email=votre@email.com" \
  -d "password=votre_password"
```
