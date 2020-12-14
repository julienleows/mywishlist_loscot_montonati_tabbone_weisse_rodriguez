<?php
/**
 * Fichier: GestionDesMessages
 * description: Bonjour
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONTONATI
 */

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class GestionDesMessages{

    private $c ;

    /**
     * Constructeur vide de la classe GestionDesItems : pour l'instant
     **/
    public function __construct(\Slim\Container $c) {
        $this->c=$c;
    }

    /*
     * fonction 4 : Ajouter un message avec sa réservation
     * info : Affiche un message et d'une réservation
     */
    function ajouterMessage(Request $rq, Response $rs, $args){
        $rs->getBody()->write("Ajoute un message avec la réservation");
        return $rs;
    }

    /*
     * fonction 4 : Ajouter un message avec sa réservation
     * info : Affiche un message avec les informations d'une liste
     */
    function ajouterMessageListe(Request $rq, Response $rs, $args){
        $rs->getBody()->write("Ajoute un message avec la liste");
        return $rs;
    }

    /*
     * fonction 4 : Ajouter un message avec sa réservation
     * info : Affiche la réservation et messages d'une de ses listes après échéance
     */
    function consulterReservationMessage(Request $rq, Response $rs, $args){
        $rs->getBody()->write("Consulte la réservation et messages d'une de ses listes après échéance");
        return $rs;
    }
}