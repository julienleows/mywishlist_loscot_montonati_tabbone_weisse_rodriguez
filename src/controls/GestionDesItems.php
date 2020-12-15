<?php
/**
 * fichier: GestionDesItems
 * description: le controle gestion des items permet de gerer les items
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONTONATI
 */

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class GestionDesItems {

  private $app ;

  /**
  * constructeur vide de la classe GestionDesItems : pour l'instant
  **/
  public function __construct($app) {
      $this->app = $app;
  }

  /**
  * fct 8 : Ajouter un item
  **/
  function ajouterItem(Request $rq,Response $rs,array $args) : Response{
    $rs->getBody()->write('s\'ajouter un item') ;
    return $rs;
  }

  /**
  * fct 9 : Modification d'un item
  **/
  function modifierItem(Request $rq,Response $rs,array $args) : Response {
    $rs->getBody()->write('s\'modifier un item');
    return $rs;
  }

  /**
  * fct 10 : Suppression d'un item
  **/
  function supprimerItem(Request $rq,Response $rs,array $args) : Response {
    $rs->getBody()->write('s\'supprimer un item');
    return $rs;
  }

}
