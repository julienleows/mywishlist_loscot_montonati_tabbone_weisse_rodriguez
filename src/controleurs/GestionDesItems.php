<?php
/**
 * Fichier: ....
 * description: ....
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONTONATI
 */

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class GestionDesItems {

  private $c ;

  /**
  * Constructeur vide de la classe GestionDesItems : pour l'instant 
  **/
  public function __construct(\Slim\Container $c) {
      $this->c=$c;
  }

  /**
  *Fct 8 : Ajouter un item
  **/
  function ajouterItem(Request $rq,Response $rs,array $args) : Response{

  }

  /**
  *Fct 9 : Modification d'un item
  **/
  function modifierItem(Request $rq,Response $rs,array $args) : Response {

  }

  /**
  *Fct 9 : Suppression d'un item
  **/
  function supprimerItem(Request $rq,Response $rs,array $args) : Response {

  }

}
