# EcoGestUM
EcoGestUM est le service de recyclage de Le Mans Université, permettant aux étudiants et au personnel de donner et récupérer du matériel réutilisable au sein de la communauté universitaire.

# Setup
Pour setup le projet :
```
git clone https://github.com/Ynryo/EcoGestUM.git
```

Ouvrez PHPMyAdmin en local, puis importez les fichiers /setup/creates.sql et /setup/inserts.sql.
Une fois cela fait, exécutez une seule fois le fichier /setup/encrypt.php

Vous n'avez plus qu'à lancer cette commande dans le shell de XAMPP : 
```
php -S 127.0.0.1:8000 -t C:\xampp\htdocs\ecogestum
```

Et voilà, le site est disponible sur 127.0.0.1:8000

