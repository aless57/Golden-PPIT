# Golden-PPIT
## Projet PPIT - LICENCE 3 Informatique 

### Mise en place :

* Installer composer : https://getcomposer.org/
* Exécuter **composer install**, qui va se servir de **composer.json** pour créer le dossier Vendor.
* Créer un user dans la BDD et éditer le fichier **config/config.ini** pour paramétrer la connexion à sa BDD sous le format suivant :
```ini
driver=mysql
username=root
password=
host=localhost
database=goldenppit
charset=utf8
collation=utf8_unicode_ci
```
* Générer la BDD, dans son phpMyAdmin, avec le fichier **goldenppit.sql**, il faudra créer une table "goldenppit" avant d'importer la BDD.

