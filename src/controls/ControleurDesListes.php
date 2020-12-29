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


use Illuminate\Database\Eloquent\ModelNotFoundException;
use mywishlist\view\VueGestionListe;
use mywishlist\view\VueParticipationListe;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use mywishlist\models\Item as Item;
use mywishlist\models\Liste as Liste;
use mywishlist\view\VueGestionListe as VueGestionLs;

class ControleurDesListes {

    /** instance container */
    private $container;

    /** constrcuteur du controleur gestion des listes */
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /** fct 6 : créer une liste */
    public function creerListe(Request $rq, Response $rs, $args) {
        try {
            $rs->getBody()->write(sizeof($args));
            if (sizeof($args) == 3) {
                $this->creationListeBDD($args);
                $rs->getBody()->write("envoie réussie");
            }
            else {
                $vue=new VueGestionLs([]);
                $rs->getBody()->write($vue->render(1));
            }
        } catch (ModelNotFoundException $m) {
            $rs->getBody()->write("Erreur de liste");
        }
        return $rs;
    }

    private function creationListeBDD($args) {
        $ls = new Liste();
        $ls->titre = $args['titre'];
        $ls->description = $args['description'];
        $ls->expiration =  date_create_from_format('j-m-Y',($args['expiration']));
        $ls->save();
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
        $lists = Liste::all(); // TODO doit recuperer les liste de souhait defini comme publique

        $array = [];
        foreach ($lists as $list) {
          $array[] = $list;
        }
      //  var_dump($array);
        // instancier une vue (passage des modeles a la vue)
        $vue = new VueGestionListe($array);

        // methode render (cf TD13) + cours 14 p5 -> code html
        $rs->getBody()->write($vue->render(2));
        return $rs;
    }
}
