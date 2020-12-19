<?php
/**
 * fichier: ControleurDesMessages
 * description: le controleur gestion des messages permet de gerer les messages
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

class ControleurDesMessages {

    /** instance container */
    private $container;

    /** constructeur vide de la classe ControleurDesItems : pour l'instant **/
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /* fct 4 : Ajouter un message avec sa réservation */
    public function ajouterMessage(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("Ajoute un message avec la réservation");
        return $rs;
    }

    /* fct 5 : Ajouter un message avec sa réservation */
    public function ajouterMessageListe(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("Ajoute un message avec la liste");
        return $rs;
    }

    /* fct 16 : Ajouter un message avec sa réservation */
    public function consulterReservationMessage(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("Consulte la réservation et messages d'une de ses listes après échéance");
        return $rs;
    }
}