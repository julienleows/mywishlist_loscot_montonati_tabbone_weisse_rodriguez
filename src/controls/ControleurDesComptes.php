<?php
/**
 * Fichier: GestionDesCompte
 * description: le controleur gestion des comptes permet de gerer les comptes
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

class ControleurDesComptes {

    /** instance container */
    private $container;

    /** constrcuteur du controleur gestion des comptes */
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /** fct 17 : créer un compte */
    public function creerCompte(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('créer un compte');
        return $rs;
    }

    /** fct 18 : s'authentifie */
    public function authentifier(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('s\'authentifier');
        return $rs;
    }

    /** fct 19 : modifier son compte */
    public function modifierCompte(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('modifier compte');
        return $rs;
    }

    /** fct 25 : créer un compte participant */
    public function creerCompteParticipant(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('creer un compte participant');
        return $rs;
    }

    /** fct 26: afficher la liste des créateurs */
    public function afficherListeCreateurs(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('afficher liste des createurs');
        return $rs;
    }

    /** fct 27: supprimer son compte */
    public function supprumerCompte(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('supprimer compte');
        return $rs;
    }

    /** fct 28: joindre des listes à son compte */
    public function joindreListeAuCompte(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('joindre une liste au compte');
        return $rs;
    }
}