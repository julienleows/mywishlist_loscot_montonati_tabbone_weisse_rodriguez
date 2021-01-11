<?php
/**
 * Fichier: AffichageDesPages
 * description: le controleur Affichage De Pages permet de gerer l'affichage des pages
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONTONATI
 */

namespace mywishlist\controls;

use mywishlist\view\VueRender;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;

class ControleurAffichageDesPages{

    /** instance container */
    private $container;

    /** constrcuteur du controleur affichage des pages */
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /** contsrcution page d accueil(home) */
    public function accueil(Request $rq, Response $rs, $args) {
        $vueRender = new VueRender($this->container);
        $rs->getBody()->write($vueRender->render($vueRender->accueil()));
        return $rs;
    }
}