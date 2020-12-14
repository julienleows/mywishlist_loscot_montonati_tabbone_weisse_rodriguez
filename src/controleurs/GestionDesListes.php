<?php
/**
 * Fichier: GestionDesListes
 * description: le controleur gestion des listes permet de gerer les listes de souhaits
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONTONATI
 */

namespace mywishlist\controls;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class GestionDesListes {
    private $app;

    /** constrcuteur du controleur gestion des listes */
    public function __contruct($app) {
        $this->app = $app;
    }

    /** fct 6 : créer une liste */
    public function creerListe(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('créer liste') ;
        return $rs;
    }

    /** fct 7 : modifier les informations générales d'une de ses listes */
    public function modifierInformationsListe(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('modifier informationsListe') ;
        return $rs;
    }

    /** fct 20 : rendre une liste publique */
    public function rendreListePublique(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('rendre liste publique') ;
        return $rs;
    }

    /** fct 21 : afficher les listes de souhaits publiques */
    public function afficherListePublique(Request $rq, Response $rs, $args)    {
        $rs->getBody()->write('afficher liste en publique');
        return $rs;
    }
}