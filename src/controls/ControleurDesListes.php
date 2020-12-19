<?php
/**
 * fichier: ControleurDesListes
 * description: le controleur gestion des listes permet de gerer les listes de souhaits
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONTONATI
 */

namespace mywishlist\controls;


use mywishlist\view\VueGestionListe;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;
use mywishlist\view\VueParticipant as VueParticipant;

class ControleurDesListes {

    /** instance container */
    private $container;

    /** constrcuteur du controleur gestion des listes */
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /** fct 6 : créer une liste */
    public function creerListe(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('créer liste');
        return $rs;
    }

    /** fct 7 : modifier les informations générales d'une de ses listes */
    public function modifierInformationsListe(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('modifier informationsListe');
        return $rs;
    }

    /** fct 20 : rendre une liste publique */
    public function rendreListePublique(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('rendre liste publique');
        return $rs;
    }

    /** fct 21 : afficher les listes de souhaits qui sont en publiques */
    public function afficherListePublique(Request $rq, Response $rs, $args) {
        // recup les listes (modele eloquant)
        $list = Liste::all(); // TODO doit recuperer les liste de souhait defini comme publique

        // instancier une vue (passage des modeles a la vue)
        $vue = new VueGestionListe($list->toArray(), $this->container);

        // methode render (cf TD13) + cours 14 p5 -> code html
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }
}