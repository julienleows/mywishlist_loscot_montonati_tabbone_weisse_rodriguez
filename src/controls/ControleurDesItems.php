<?php
/**
 * fichier: ControleurDesItems
 * description: le controle gestion des items permet de gerer les items
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONTONATI
 */

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;

class ControleurDesItems {

    /** instance container */
    private $container;

    /** constructeur vide de la classe ControleurDesItems : pour l'instant **/
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /** fct 8 : Ajouter un item **/
    public function ajouterItem(Request $rq, Response $rs, array $args): Response {
        $rs->getBody()->write('s\'ajouter un item');
        return $rs;
    }

    /** fct 9 : Modification d'un item **/
    public function modifierItem(Request $rq, Response $rs, array $args): Response {
        $rs->getBody()->write('s\'modifier un item');
        return $rs;
    }

    /** fct 10 : Suppression d'un item **/
    public function supprimerItem(Request $rq, Response $rs, array $args): Response {
        $rs->getBody()->write('s\'supprimer un item');
        return $rs;
    }
}
