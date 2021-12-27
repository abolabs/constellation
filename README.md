<div id="top"></div>
<!--
*** Thanks for checking out the Best-README-Template. If you have a suggestion
*** that would make this better, please fork the repo and create a pull request
*** or simply open an issue with the tag "enhancement".
*** Don't forget to give the project a star!
*** Thanks again! Now go create something AMAZING! :D
-->



<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->
[![Pipeline Status](https://gitlab.com/abolabs/constellation/badges/master/pipeline.svg)](https://gitlab.com/abolabs/constellation/commits/master)
[![Stars](https://badgen.net//gitlab/stars/abolabs/constellation/)](https://gitlab.com/abolabs/constellation/commits/master)
[![GitLab issues open](https://badgen.net/gitlab/open-issues/abolabs/constellation)](https://gitlab.com/gitlab-org/gitlab-runner)
[![GitLab issues closed](https://badgen.net/gitlab/closed-issues/abolabs/constellation)](https://gitlab.com/abolabs/constellation)
 [![License: AGPL v3](https://img.shields.io/badge/License-AGPL_v3-blue.svg)](https://www.gnu.org/licenses/agpl-3.0)


<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://gitlab.com/abolabs/constellation">
    <img src="doc/images/logo.png" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">Constellation</h3>

  <p align="center">
    Interface de cartographie applicative
    <br />
    <a href="README-en.md"><strong>English version »</strong></a>
    <br />
    <br />        
    <a href="https://gitlab.com/abolabs/constellation/-/issues">Rapporter un Bug</a>
    ·
    <a href="https://gitlab.com/abolabs/constellation/-/issues">Partager une idée d'évolution</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table des matières</summary>
  <ol>
    <li>
      <a href="#a-propos-du-projet">A propos du project</a>
      <ul>
        <li><a href="#librairies-et-frameworks">Librairies et Frameworks</a></li>
      </ul>
    </li>
    <li>
      <a href="#commencer">Commencer</a>
      <ul>
        <li><a href="#prérequis">Prérequis</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>    
    <li><a href="#contribuer">Contribuer</a></li>
    <li><a href="#licence">Licence</a></li>
    <li><a href="#contact">Contact</a></li>    
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## A propos du projet

Constellation est une interface de cartographie applicative permettant à toute structure IT de visualiser et contrôler ses dépendances par service. 

### Fontionnalités

* Modélisation des applications et services applicatifs
* Gestion des versions par service
* Déclaration des dépendances de service selon 3 niveaux :
    * **Faible** 
    En cas d'indisponibilité : impact sur fonctionnalité(s) mineure(s) ou majeure(s) avec solution de contournement
    * **Majeur** 
    En cas d'indisponibilité : impact sur fonctionnalité(s) majeure(s) sans solution de contournement mais sans indisponibilité générale
    * **Critique** 
    En cas d'indisponibilité : impact de fonctionnalité(s) majeure(s) sans solution de contournement entrainant une indisponibilité générale de l'application

<img src="doc/images/Screenshot.png" alt="Screenshot" height="350px">

* **3 types de visualisations possibles** 
    * Dépendances entre les applications
    * Dépendances des services par application    
    * Dépendances des services par solutions d'hébergement


<p align="right">(<a href="#top">revenir en haut</a>)</p>



### Librairies et Frameworks

La solution a été volontaire implémentée avec des solutions faciles d'accès, permettant au plus grand nombre de s'approprier le projet.
Cette section liste les librairies et frameworks principaux utilisés durant l'élaboration de la solution :

* [Laravel](https://laravel.com)
* [Bootstrap](https://getbootstrap.com)
* [CoreUI](https://coreui.io/)
* [InfyOm](https://infyom.com/open-source)
* [Cytoscape](https://js.cytoscape.org/)

<p align="right">(<a href="#top">revenir en haut</a>)</p>

<!-- GETTING STARTED -->
## Commencer

Les instructions ci-dessous décrivent les différentes étapes pour initialiser l'application via Docker.

### Prérequis

L'application a été développée en utilisant les versions ci-dessous :

* Docker version 20.10.9, build c2ea9bc
* docker-compose version 1.29.2, build 5becea4c

Les versions de services utilisés sont déclarés dans le fichier `./install/dev/docker-compose.yml`. 
### Installation
Les instructions ci-dessous décrivent comment monter un environnement de production.
Si vous souhaitez monter un environnement de développement, merci de voir le [wiki](https://gitlab.com/abolabs/constellation/-/wikis/Setup-Dev-environnement)

#### 1. Initialiser le fichier d'environnement du docker-compose

```sh
cp ./install/prod/.env.example .env
``` 

#### 2. Editer le fichier d'environnement de la stack Docker

* `MYUSER` Nom de l'utilisateur dans le conteneur fpm. 
* `DATA_VOLUME` Répertoire de partage pour le stockage des données des services (Mariadb, Nginx, Redis).
* Mariadb - Les informations ci-dessous devront correspondre à celles du `.env` Laravel, à la racine du projet).
    * `MARIADB_ROOT_PASSWORD` Mot de passe root
    * `MARIADB_USER` Nom utilisateur Mariadb.
    * `MARIADB_PASSWORD` Mot de passe.
    * `MARIADB_PORT` Port Mariadb partagé avec le host Docker.
    * `MARIADB_DATABASE` Nom de la base de données initialisée par défaut.
* MailDev - Service de debug pour l'envoi de mail.
_(Voir https://hub.docker.com/r/maildev/maildev)_
    * `SMTP` Port partagé avec le host pour l'écoute des messages à capturer.
    * `WEBUI` Port partagé avec le host pour accéder à l'interface de visualisation des emails

#### 3. Monter la stack    

```sh
docker-compose up -d
```
Tous les services devraient monter, vous permettant de passer à l'initialisation de l'application.
Si ce n'est pas le cas, vérifiez les informations saisies dans le fichier `./install/dev/.env`.
Si des ports sont déjà utilisés par d'autres services, modifiez la configuration.

#### 4. Initialisation de l'application

* Initialisez le fichier d'environnement Laravel
    ```sh
    cp .env.example .env
    ```
* Editez le fichier d'environnement Laravel
  * Générer une nouvelle clé applicative (il est déconseillé d'utiliser celle utilisée pour la construction de l'image Docker).
  `docker-compose exec fpm php artisan key:generate`
  * Editer les variables commençant `DB_` pour correspondre à ce qui a été défini dans le fichier `./install/dev/.env`.
  `docker-compose exec fpm nano .env`
  Vous pouvez également modifier les autres variables en fonction de votre environnement (voir https://laravel.com/docs/8.x/configuration).

* Initialisez la base de données    
    * Editez l'administrateur.     
    Modifier le fichier `./database/seeders/CreateAdminUserSeeder.php`.
    `docker-compose exec fpm nano database/seeders/CreateAdminUserSeeder.php`
    Editez le nom, l'email et mot de passe à votre convenance 
    ```php
    'name' => 'Super Admin',
    'email' => 'admin@localhost',
    'password' => bcrypt('super_secured_password')
    ```
    * Initialisation des tables
    ```sh
    docker-compose exec fpm php artisan migrate --seed
    ```
    * (Optionnel) Chargez des applications d'exemple
    ```sh
    docker-compose exec fpm php artisan db:seed --class=AppExampleSeeder
    ```
#### 5. Finalisation

Bravo vous venez de terminer l'installation de la solution.
Il ne vous reste plus qu'à vous connecter.
Avec la configuration par défaut, l'application sera accessible en local depuis l'url suivante : http://localhost:8080

<p align="right">(<a href="#top">revenir en haut</a>)</p>



<!-- USAGE EXAMPLES -->
## Usage

Exemples d'usages
### Visualisation des dépendances applicatives

<img src="doc/images/Screenshot_2.png" alt="Visualisation dépendances applicatives" height="450px">

### Visualisation des dépendances de service par application

<img src="doc/images/Screenshot.png" alt="Visualisation dépendances de service par application" height="450px">

### Visualisation des dépendances de service par solution d'hébergement

<img src="doc/images/Screenshot.png" alt="Visualisation dépendances de service par solution d'hébergement" height="450px">

<p align="right">(<a href="#top">revenir en haut</a>)</p>



<!-- CONTRIBUTING -->
## Contribuer

Les contributions sont ce qui fait de la communauté open source un endroit incroyable pour apprendre, s'inspirer et créer. Toutes les contributions que vous apportez sont **très appréciées**.

Si vous avez une suggestion pour améliorer la solution, veuillez créer un repo et créer une merge request. Vous pouvez aussi simplement ouvrir un ticket avec le tag « enhancement ».
N'oubliez pas de donner une étoile au projet ! Merci à vous !

1. Faire un fork du projet
2. Créez votre branche (`git checkout -b feature/AmazingFeature`)
3. Validez vos modifications (`git commit -m 'Add some AmazingFeature'`)
4. Poussez votre branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une merge request

<p align="right">(<a href="#top">revenir en haut</a>)</p>



<!-- LICENSE -->
## Licence

Distribué sous licence  GNU AFFERO GENERAL PUBLIC LICENSE. Voir [LICENSE](LICENSE) pour plus d'informations.

<p align="right">(<a href="#top">revenir en haut</a>)</p>



<!-- CONTACT -->
## Contact

### Contributeur(s)

(Créateur) Alexandre Bordin - [@Linkedin](https://www.linkedin.com/in/alexandre-bordin/)


Lien vers le projet : [https://gitlab.com/abolabs/constellation](https://gitlab.com/abolabs/constellation)

<p align="right">(<a href="#top">revenir en haut</a>)</p>

