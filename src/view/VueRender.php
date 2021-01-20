<?php
namespace mywishlist\view;



class VueRender {

    private $container;


    /**
     * Constructeur de la Vue Render
     */
    public function __construct($c) {
        $this->container = $c;
    }

    /**
     * Méthode render pour afficher le contenu d'une page
     * @param $content
     * @return string
     */
    public function render($content) {
        return <<<END
        <!DOCTYPE html>
        <html>
            <head>
                <title>My Wish List</title>
                
                <!-- favicon -->
                <link rel="shortcut icon" type="image/x-icon" href="{$this->container->router->pathFor('racine')}/images/favicon/favicon_mywishlist.ico"/>
                 <!-- css boostrap -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
                <!-- viewport -->
                <meta name="viewport" content="width=device-with, initial-scale=1.0"
            </head>
            <body>
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                  <div class="container-fluid">
                        <a class="navbar-brand" href="{$this->container->router->pathFor('racine')}">
                            <img src="{$this->container->router->pathFor('racine')}/images/logos/logo_mywishlist.svg" alt="" width="50" height="38" class="d-inline-block align-top">
                            My Wishlist
                        </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">                             
                       <form method="post" action="{$this->container->router->pathFor('postliste')}" type="search" placeholder="Search" aria-label="Search">
                            <input class="form-control me-2" type="text" name="token" placeholder="clé de partage" required/></label>
                       </form>	
                      <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                      
                      <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="{$this->container->router->pathFor('crealiste')}">Creation liste</a></li>
                        <li class="nav-item"><button type="button" class="btn btn-outline-danger" onclick="window.location.href='{$this->container->router->pathFor('listes')}';">Listes</button></li>
                      </ul>
                     </div>
                  </div>
                </nav>
                
                <!-- page web -->
                <div class="container">
                    $content
                </div>
                
                <!-- js boostrap -->
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
            </body>
        </html> 
END;
    }

    /**
     * Méthode pour afficher la page d'acceuil
     * @return string
     */
    public function accueil() {
        return <<<END
            <link rel="stylesheet" href="{$this->container->router->pathFor('racine')}css/cssaccueil.css" type="text/css"/>
            <br>
            <span class="titre-page-accueil">
                <img src="{$this->container->router->pathFor('racine')}/images/logos/logo_mywishlist.svg">
                <h1>Des merveilleuses listes avec Wishlist</h1>
            </span>

            <br>
            <br>
            <div class="boutons">
                 <button type="button" class="btn btn-danger btn-lg" onclick="window.location.href='{$this->container->router->pathFor('listes')}';">
                    Listes
                 </button>
                 <button type="button" class="btn btn-danger btn-lg" onclick="window.location.href='{$this->container->router->pathFor('crealiste')}';">
                    Création Liste
                 </button>
            </div>
               
            <br>
            <br>
            <br>
               
            <div class="text-page-accueil">
                <p>
                    Bonjour bienvenue sur notre site de gestion de liste.
                    Crée votre liste et accès à vos listes et réserver les items !<br>
                    Où encore modifier vos items de vos listes pour créer des superbes listes.<br>
                    <br>
                    Le site web s'apdapte sur toutes les platformes mobiles, tablette, pc...
                </p>
               
            </div>
            
            
            
            
END;
    }

    /**
     * Méthode pour afficher la page d'erreur
     * @param $erreurmessage
     * @return string
     */
    public function erreur($erreurmessage) {
        return <<<END
            <link rel="stylesheet" href="{$this->container->router->pathFor('racine')}/css/csserreur.css" type="text/css"/>
            <br>   
            <div class="text-page-accueil">
                <p> $erreurmessage </p>
            </div>
            
            <div class="bouton-milieu">
                 <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{$this->container->router->pathFor('racine')}';">
                    page d'accueil
                 </button>
            </div>  
END;
    }

}