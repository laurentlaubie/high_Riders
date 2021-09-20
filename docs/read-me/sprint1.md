# Challenge Doctrine O'blog

## Objectifs
- Refaire les manips vues ce jour (depuis un projet Symfony vierge)
- Introduire la relation OneToMany / ManyToOne
    - [Recap du cours](recap.md) si besoin
    - [Documentation Symfony Doctrine](https://symfony.com/doc/current/doctrine.html)
    - [Fiche récap' (succinte)](https://github.com/O-clock-Alumnis/fiches-recap/blob/master/symfony/themes/S2J1-Doctrine.md)


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

### Entité `Spot`
- Créetion de  l'entité _Spot_ avec la commande `php bin/console make:entity` :
- Mettre à jour la BDD : `php bin/console doctrine:schema:update --force`

### Controleur `src/Controller/PostController`
-  Créer les routes suivantes permettant de :
   - Lire tous les Posts - [Fetching Objects from the Database](https://symfony.com/doc/current/doctrine.html#fetching-objects-from-the-database)
   - Lire un Post via son id - [Fetching Objects from the Database](https://symfony.com/doc/current/doctrine.html#fetching-objects-from-the-database)

Reprendre les étapes précédentes et appliquez aux autres entité : `Author`, `Comment` et `Category`.

### Bonus Entité `Post`
- Bonus : Créer un Post depuis le contrôleur - [_Persisting Objects to the Database_](https://symfony.com/doc/current/doctrine.html#persisting-objects-to-the-database)
- Bonus : Mettre à jour (mettez à jour la propriété `updatedAt`) - [Updating an Object](https://symfony.com/doc/current/doctrine.html#updating-an-object)
- Bonus : Supprimer - [Deleting an Object](https://symfony.com/doc/current/doctrine.html#deleting-an-object)
  
=> N'oubliez pas les redirections si besoin (`$this->redirecToRoute('nomdelaroute')`) :wink:

### Bonus Entité `Author`

On (votre client...A.K.A NOUS 😜) fait le choix suivant (discutable évidemment, mais la vie est faite de choix 😗) : 
>> 1 (One) Auteur peut écrire plusieurs (Many) Articles. Mais un article ne peut avoir qu'un seul Auteur ✍️.

A partir de cette affirmation (#dictatureBienveillante)
- Créez la relation Doctrine entre les entités `Author` et `Post`.

### Bonus (facultatif :nerd_face:)

- Mettez en place la modification d'un article 
    - (via un formulaire très simple si vous le faites, ne gérez pas forcément les erreurs, nous verrons comment intégrer cela avec Symfony de manière automatique).
- Ajouter une navigation pratique et les messages flash qui vont bien.
- Parsemez le site de composants Bootstrap (nav, badge, ...) histoire que ce soit un minimum joli :wink:

### Bonus _lectures_

- [Conversion de paramètre automatique](https://symfony.com/doc/current/doctrine.html#automatically-fetching-objects-paramconverter)
- [Créer de fausses données (fixtures) **spoiler** pour la suite](https://symfony.com/doc/current/doctrine.html#dummy-data-fixtures)
