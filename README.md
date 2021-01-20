
<p align="center">
  <img width="230" height="150" src="https://github.com/julienleows/mywishlist_loscot_montonati_tabbone_weisse_rodriguez/blob/main/images/logos/logo_mywishlist.svg">
</p>

# PROJET PHP MY WISH LIST
Projet PHP- IUT Nancy Charlemagne 2020-2021  
Sujet : My Whish List


## Introduction
Ce dépôt github regroupe tous les documents et sources du projet MyWishList

> **L'objectif est de réaliser est réaliser un site web avec le patron MVC.
	Le site permet de réaliser des listes contenant des items qui sont réservables.**

* Membres :
	* Julien Weisse [@JulienLeoWS](https://github.com/JulienLeoWS)
	* Lucas Tabbone [@lucas2301](https://github.com/lucas2301)
	* Clément Loscot [@krabumb](https://github.com/krabumb)
	* Godefroy Montonati [@Godefrox](https://github.com/Godefrox)
	* Irene Rodriguez [@irenerodriguez14](https://github.com/irenerodriguez14)


## Technologies
* PHP ([php.net](https://www.php.net))
* Eloquent ([laravel.com/eloquent](https://laravel.com/docs/8.x/eloquent))
* Slim ([slimframework.com](https://www.slimframework.com/))
* Bootstrap ([getbootstrap.com](https://getbootstrap.com/))


## Fonctionnalités (tableau de bord)
fini? | Numéro Fct | Nom Fct | Auteur
:-: |:-: | :- |:-
oui | 1  | Afficher une liste de souhaits | Lucas/Clement
oui | 2  | Afficher un item d'une liste   | Lucas
oui | 3  | Réserver un item               | Godefroy / Lucas
oui | 4  | Ajouter un message avec sa réservation | Godefrox
non | 5  | Ajouter un message sur une liste |
oui | 6  | Créer une liste | Lucas/Clément
oui | 7  | Modifier les informations générales d'une de ses listes | Julien
oui | 8  | Ajouter des items | Irene / Clément
oui | 9  | Modifier un item | Irene / Clément
oui | 10 | Supprimer un item | Irene / Clément
non | 11 | Rajouter une image à un item |
non | 12 | Modifier une image d'un item |
non | 13 | Supprimer une image d'un item |
oui | 14 | Partager une liste | Clément/ Julien
non | 15 | Consulter les réservations d'une de ses listes avant échéance |
non | 16 | Consulter les réservations et messages d'une de ses listes après échéance |
non | 17 | Créer un compte |
non | 18 | S'authentifier |
non | 19 | Modifier son compte |
oui | 20 | Rendre une liste publique | Godefroy
oui | 21 | Afficher les listes de souhaits publiques | Julien / Lucas
non | 21 | Créer une cagnotte sur un item |
non | 23 | Participer à une cagnotte |
non | 24 | Uploader une image |
non | 25 | Créer un compte participant |
non | 26 | Afficher la liste des créateurs |
non | 27 | Supprimer son compte |
non | 28 | Joindre des listes à son compte |

autres : 
- [x] logo du site web(svg,favicon) | Julien
- [x] mise en place de bootstrap | Julien
- [x] correction bug (avec les $rs->withRedirect(...) | Julien / Clément
- [x] mise en page accueil et navbar | Julien

## disponible sur webetu :

[https://webetu.iutnc.univ-lorraine.fr/www/weisse53u/mywishlist](https://webetu.iutnc.univ-lorraine.fr/www/weisse53u/mywishlist)


## Instalation

* installer l'utilitaire XAMP ([xamp.com](https://www.apachefriends.org/fr/index.html))
* mettre notre projet dans le fichier htdocs/[votrenom] de xamp avec la commande git clone de votre terminal :
`git clone https://github.com/julienleows/mywishlist_loscot_montonati_tabbone_weisse_rodriguez`

* lancer XAMP : démarrer les services Apache et MySQL.
* Créer une base de données nommée : `mywishlist` depuis l'interface phpMyAdmin.
* Télécharger notre fichier [mywishlist_sql.txt](https://github.com/julienleows/mywishlist_loscot_montonati_tabbone_weisse_rodriguez/blob/main/mywishlist_sql.txt)
puis executer le code sql dans votre base de données.

* configuerer le fichier `src/conf/conf.ini` avec les information de votre base de données, par exemple : 

 | | 
:-: 
driver=mysql |
username=[IDENTIFIANT DE VOTRE BASE] |
password= [MDP UTILISATEUR DE LA BASE] |
host=localhost |
database=wishlist |
charset=utf8 |
collation=utf8_unicode_ci |

* Installer composer [getcomposer.org](https://getcomposer.org/)
* Avec un terminal dans la racine de notre projet faire :
`composer install`
* maintenant le projet correctement installé, rdv sur votre page de localhost/[votrenom]/mywishlist_loscot_montonati_tabbone_weisse_rodriguez/


## Visualiser les commits
commande : `gitk` avec un terminal dans la racine du projet.

<p align="center">
  <img width="920" height="600" src="https://github.com/julienleows/mywishlist_loscot_montonati_tabbone_weisse_rodriguez/blob/main/images/illustrations/mobile-image.svg">
</p>

