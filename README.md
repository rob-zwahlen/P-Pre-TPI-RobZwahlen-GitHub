# Surnom des enseignants
Dépôt de l'application des surnoms des enseignants de l'école des métiers de Lausanne.
## Installation
### Pré-requis
L'environnement doit pouvoir utiliser Symfony CLI et une base de données MySQL.
> Il est essentiel que votre environnement puisse utiliser Composer et npmJS.
### GitHub
Copiez dans votre environnement de développement le répertoire GitHub avec la commande `git clone https://github.com/rob-zwahlen/SurnomsEnseignants.git` 
### Features
Installez les fonctionnalités de Symfony en utilisant la commande `composer install` puis ensuite `npm install`
> Exécutez les commandes `composer update` et `npm update` afin de mettre à jour l'environnement.

Démarrez Webpack Encore avec la commande `npm run watch`. Une fois que le terminal affiche "webpack compiled successfully" cliquez sur `Ctrl+C` et stoppez l'exécution.
### Doctrine
Une fois que vous avez cloné votre projet et que votre hôte virtuel est configuré, créez la base de données et effectuez les migrations. Votre terminal doit pointer vers la racine du projet.
- `php bin/console doctrine:database:create`
- `php bin/console make:migration`
- `php bin/console doctrine:migrations:migrate`
### Fixtures
Lorsque votre base de données est migrée, il est maintenant temps d'ajouter des données fictives grâce aux fixtures.
- `php bin/console doctrine:fixtures:load`
> Les fixtures doivent être exclusivement utilisées dans un environnement de développement.