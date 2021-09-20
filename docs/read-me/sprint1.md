# Sprint 1 

## 20/09/21

### Création d'un dossier 'docs'

- MCD
- Dico de données --DOING

### Création d'un projet Symfony Website/skeleton

- `composer create-project symfony/website-skeleton high-riders` - [Voir la doc](https://symfony.com/doc/current/setup.html#creating-symfony-applications)

### Configuration de la base de données

Reprendre les étapes faites en cours
- Configuration du fichier d'environnement
    -  Créez un fichier `.env.local`
    -  Configurez le fichier avec les informations de connexion à la BDD : `DATABASE_URL=mysql://votreDBUser:votreDBPassword@127.0.0.1:3306/high-riders_dev?serverVersion=5.7.31`
        -  Pensez à Modifier la version de MySQL en fonction de ce que vous avez (commande `mysql --version`)
- Création d'une BDD _high-riders_dev_ via la ligne de commandes
    - Lancez la commande `php bin/console doctrine:database:create`

### Entité
- avec la commande `php bin/console make:entity` :
- Création de  l'entité _Spot_ .
- Création de  l'entité _Event_ .
- Création de  l'entité _User_ .
- Création de  l'entité _Participation_ .
- Création de  l'entité _Departement_ .
- Création de  l'entité _Discipline_ .
- Création de  l'entité _Comment_ .
- Création de  l'entité _Contact_ . 



- Mettre à jour la BDD : `php bin/console doctrine:schema:update --force`

### Controleur 

- Création du controller _Spot_ .
- Création du controller _Event_ .
- Création du controller _User_ .
- Création du controller _Participation_ .
- Création du controller _Departement_ .
- Création du controller _Discipline_ .
- Création du controller _Comment_ .
- Création du controller _Contact_ . --DOING
- 
-  Créer les routes suivantes permettant de :
   - Lire tous les données - [Fetching Objects from the Database](https://symfony.com/doc/current/doctrine.html#fetching-objects-from-the-database)

