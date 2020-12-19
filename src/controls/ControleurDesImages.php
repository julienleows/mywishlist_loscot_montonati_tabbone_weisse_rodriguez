<?php
/**
 * Fichier: ControleurDesImages
 * description: le controleur de gestion de toutes les images
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

class ControleurDesImages {

    /** instance container */
    private $container;

    /** constructeur de la classe ControleurDesImages **/
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /* fct 11 : ajouter/rajouter une image a un item */
    public function ajouterImage(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("Ajouter une image a un item");
        return $rs;
    }

    /* fct 12 : modifier une image d'un item */
    public function modifierImage(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("Modifier une image d'un item");
        return $rs;
    }

    /* fct 13 : supprimer une image d'un item */
    public function supprimerImage(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("Supprimer l'image d'un item");
        return $rs;
    }

    /* fct 24 : uploader une image */
    public function UploaderImage(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("Mettre en ligne une nouvelle image");
        return $rs;
    }
}
