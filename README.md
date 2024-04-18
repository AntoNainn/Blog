
# Blog 

Guide d'installation 


## information
PHP version : 8.2.10

symfony version : 6.3.4

bdd : MariaDB 10.5.19

Composer est requis pour l'installation.

Un dump de la base de données est fournie dans le git. 
Nom du fichier : sauvegarde_BLOG.sql


## Installation

Une fois le git recupéré, écrire dans la console :

```bash
  composer install
```

et il faut changer la chaine de connection a la base de données dans le fichier .env

Exemple : DATABASE_URL="mysql://antonin:admin@127.0.0.1:3306/Blog?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
