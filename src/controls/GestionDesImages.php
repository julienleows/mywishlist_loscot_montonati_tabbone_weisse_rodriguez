<?php
/**
 * Fichier: GestionDesImages
 * description: le controleur de gestion de toutes les images
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONTONATI
 */

 namespace mywishlist\controls;

 use \Psr\Http\Message\ServerRequestInterface as Request;
 use \Psr\Http\Message\ResponseInterface as Response;

 class GestionDesImages {

   private $app;

   /**
    * constructeur de la classe GestionDesImages
    **/
   public function __construct($app) {
       $this->app = $app;
   }

   /* fct 11 : ajouter/rajouter une image a un item */
   function ajouterImage(Request $rq, Response $rs, $args){
       $rs->getBody()->write("Ajouter une image a un item");
       return $rs;
   }

   /* fct 12 : modifier une image d'un item */
   function modifierImage(Request $rq, Response $rs, $args){
       $rs->getBody()->write("Modifier une image d'un item");
       return $rs;
   }

   /* fct 13 : supprimer une image d'un item */
   function supprimerImage(Request $rq, Response $rs, $args){
       $rs->getBody()->write("Supprimer l'image d'un item");
       return $rs;
   }

   /* fct 24 : uploader une image */
   function UploaderImage(Request $rq, Response $rs, $args){
       $rs->getBody()->write("Mettre en ligne une nouvelle image");
       return $rs;
   }
}
