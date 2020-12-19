<?php
/**
 * Fichier: ControleurParticipationListe
 * description: le controleur de gestion de la participation a une liste
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONTONATI
 */

namespace mywishlist\controls;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use mywishlist\view\VueParticipationListe;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;

class ControleurParticipationListe {

    /** instance container */
    private $container;

    /** constructeur de la classe ControleurParticipationListe **/
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /* fct 1 : Afficher les élements d'une liste de souhaits */
    public function afficherListeSouhaits(Request $rq, Response $rs, $args) {
        try {
            $item=Liste::query()->where('id','=',$args['id'])
                    ->FirstOrFail();
            $vue=new VueParticipationListe([$item]);
            $rs->getBody()->write($vue->render(1));
            return $rs;
        } catch (ModelNotFoundException $m) {
            $rs->getBody()->write("item {$item->nom} non trouvé !");
        }
    }

    /* fct 2 : Afficher un item d'une liste de souhaits */
    public function afficherItemListeSouhaits(Request $rq, Response $rs, $args) {
        try {
            $item=Item::query()->where('id','=',$args['id'])
                    ->FirstOrFail();
            $vue=new VueParticipationListe([$item]);
            $rs->getBody()->write($vue->render(2));
            return $rs;
        } catch (ModelNotFoundException $m) {
            $rs->getBody()->write("item {$item->nom} non trouvé !");
        }
    }

    /* fct 3 : Reserver un item */
    public function reserverItem(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("Reserver un item");
        return $rs;
    }

    /* fct 14 : partager une liste */
    public function partagerListe(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("Partager la liste");
        return $rs;
    }

    /* fct 15 : Consulter les réservations d'une de ses listes avant échéance */
    public function consulterReservationListeAvantEcheance(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("Consultation des reservations de la liste avant l'échéance");
        return $rs;
    }

    /* fct 22 : Creer une cagnotte sur un item */
    public function creerCagnotteSurItem(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("creation d'une cagnotte sur un item");
        return $rs;
    }

    /* fct 23 : Participer a une cagnotte */
    public function participerGagnotte(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("participation a la cagnotte d'un item");
        return $rs;
    }
}
