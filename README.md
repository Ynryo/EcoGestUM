# EcoGestUM
EcoGestUM est le service de recyclage de Le Mans Université, permettant aux étudiants et au personnel de donner et récupérer du matériel réutilisable au sein de la communauté universitaire.

# Setup
Pour setup le projet :
```
git clone https://github.com/Ynryo/EcoGestUM.git
```

Ouvrez PHPMyAdmin en local, puis importez les fichiers /setup/creates.sql et /setup/inserts.sql.<br>
Une fois cela fait, tapez cette commande dans le shell de XAMPP (ou tout autre invite de commande exécutant php.exe) : 
```
php -S 127.0.0.1:8000 -t C:\xampp\htdocs\ecogestum
```

Le site est disponible sur 127.0.0.1:8000<br>
Créez un fichier .env à la racine du projet en suivant le modèle ci-dessous : 
```
DB_CONNECTION="mysql"
DB_HOST="127.0.0.1"
DB_PORT="3306"
DB_DATABASE_SSH="ecogestum"
DB_USERNAME_SSH="ecogestum_user"
DB_PASSWORD_SSH="password123"
```

Testez la connexion à la base de données avec http://127.0.0.1:8000/setup/testConnexion.php<br>
Si la connexion marche correctement, exécutez une seule fois le fichier http://127.0.0.1:8000/setup/encrypt.php

Et voilà, vous pouvez maintenant profiter du service EcoGestUM

