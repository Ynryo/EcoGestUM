# **EcoGestUM ♻️🎓**

Une plateforme web collaborative dédiée à l'économie circulaire au sein de Le Mans Université. Donnez une seconde vie au matériel universitaire et réduisez le gaspillage grâce à un système intuitif de dons et de récupération.

## **✨ Fonctionnalités**

* 📦 **Gestion de Dons Simplifiée** : Déposez du matériel réutilisable, ajoutez des photos et des descriptions en quelques clics.  
* 🔍 **Inventaire Intelligent** :  
  * Navigation fluide par catégories et localisations.  
  * **Filtres Avancés** : Triez par état, disponibilité ou département.  
  * **Wishlist** : Ajoutez des objets en favoris ❤️ pour les retrouver plus tard.  
* 📅 **Système de Réservation** :  
  * Réservez le matériel directement depuis la plateforme.  
  * Suivi du statut en temps réel (Disponible, Réservé, Indisponible).  
* 🔐 **Gestion des Rôles Granulaire** :  
  * Interface adaptée selon le profil (Président, Chef de composante, Chef de département, Responsable de service).  
  * **Visibilité cloisonnée** : Chaque responsable gère son propre périmètre (Composante, Service, etc.).  
* 🔔 **Notifications & Suivi** : Messagerie intégrée pour gérer les demandes et valider les transactions.  
* 📊 **Panel d'Administration** : Statistiques d'utilisation et historique des mouvements.

## **🛠️ Stack Technique**

* **Langage Backend** : PHP 8+ (Architecture MVC native).  
* **Base de données** : MySQL / MariaDB (Gestion via PDO).  
* **Frontend** :  
  * HTML5 / CSS3 (Design responsive et custom).  
  * JavaScript Vanilla (AJAX pour les interactions dynamiques sans rechargement).  
* **Dépendances** : [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) pour la gestion sécurisée des variables d'environnement.  
* **Serveur** : Compatible Apache (XAMPP/WAMP/MAMP) ou Serveur interne PHP.

## **🛠️ Configuration & Installation**

### **Prérequis**

* PHP 8.0 ou supérieur.  
* Composer.  
* Un serveur MySQL local (via XAMPP par exemple).

### **Installation Rapide**

1. **Cloner le projet** :  
   ```
   git clone https://github.com/Ynryo/EcoGestUM.git
   cd EcoGestUM
   ```

2. **Base de données** :  
   * Ouvrez votre gestionnaire SQL (ex: PHPMyAdmin).  
   * Importez les fichiers dans cet ordre précis :  
     1. /setup/creates.sql (Structure)  
     2. /setup/inserts.sql (Données initiales)  
3. **Configuration de l'environnement** :  
   Créez un fichier .env à la racine du projet et configurez vos accès BDD : 
   ``` 
   DB_CONNECTION="mysql"  
   DB_HOST="127.0.0.1"  
   DB_PORT="3306"  
   DB_DATABASE_SSH="ecogestum"  
   DB_USERNAME_SSH="ecogestum_user"  
   DB_PASSWORD_SSH="password123"
   ```

   *(Note : Adaptez DB_USERNAME_SSH et DB_PASSWORD_SSH selon votre config locale, souvent root et vide sous XAMPP).*  
4. **Lancement du serveur** :  
   Dans votre terminal (ou shell XAMPP), lancez :  
   ```
   php \-S 127.0.0.1:8000 \-t C:\\xampp\\htdocs\\ecogestum
   ```

   *(Adaptez le chemin `C:\\xampp...` selon votre installation)*  
5. **Initialisation Finale** :  
   * Testez la connexion : [http://127.0.0.1:8000/setup/testConnexion.php](http://127.0.0.1:8000/setup/testConnexion.php)  
   * **Important** : Exécutez ce script une seule fois pour sécuriser les mots de passe des comptes par défaut :  
     [http://127.0.0.1:8000/setup/encrypt.php](http://127.0.0.1:8000/setup/encrypt.php)

🚀 **Et voilà \!** Le site est accessible sur `http://127.0.0.1:8000`.

## **📂 Structure du Projet**

* `assets/models/` : Cerveau de l'application. Contient toute la logique métier et les requêtes SQL (Gestion des dons, Auth, Réservations...).  
* `assets/view/` : Les composants visuels (Header, Footer, Affichage des produits).  
* `assets/js/` : Scripts pour l'interactivité client (Bouton "J'aime", modales, graphiques).  
* `setup/` : Scripts d'initialisation de la base de données et de sécurité.  
* `index.php` : Point d'entrée, gère le routing basique entre la page d'accueil et le dashboard connecté.

## **📝 À propos**

Projet étudiant développé pour **Le Mans Université** dans le but de faciliter la gestion des ressources et promouvoir l'écologie sur le campus.