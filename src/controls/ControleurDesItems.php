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

use Illuminate\Database\Eloquent\ModelNotFoundException;
use mywishlist\view\VueGestionItem as VueIT;
use mywishlist\view\VueParticipationListe as VuePL;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use mywishlist\models\item as Item;


class ControleurDesItems {

    /** instance container */
    private $container;

    /** constructeur vide de la classe ControleurDesItems : pour l'instant **/
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /** fct 6 : créer une liste */
    public function creerItem(Request $rq, Response $rs, $args, $liste_id) {
        try {
            if (sizeof($args) == 3) {
                if (! $this->verificationItemExistant($args)){
                    $this->creationItemBDD($args, $liste_id);
                    $vue=new VuePL([], $this->container);
                    $rs->getBody()->write($vue->render(1));
                } else {
                    $vue=new VueIT([], $this->container);
                    $rs->getBody()->write($vue->render(2));
                }
            }
            else {
                $vue=new VueIT([], $this->container);
                $rs->getBody()->write($vue->render(1));
            }
        } catch (ModelNotFoundException $m) {
            $rs->getBody()->write("Erreur de liste");
        }
        return $rs;
    }

    private function verificationItemExistant($args){
        try{
            $ls=Item::query()->where(['nom' => $args['nom']])->FirstOrFail();
            return true;
        } catch (ModelNotFoundException $m) {
            return false;
        } // c'est debile, mais on peut pas enlever cette ligne
        return false;
    }

    private function creationItemBDD($args, $liste_id) {
        $ls = new Item();
        $ls->nom = $args['nom'];
        $ls->descr = $args['descr'];
        $ls->liste_id = $liste_id;
        // img / url a voir plus tard
        $ls->tarif = $args['tarif'];
        $ls->save();
    }

    /** fct 9 : Modification d'un item **/
    public function modifierItem(Request $rq, Response $rs, array $args): Response {
        print_r($rs);
        $rs->getBody()->write('s\'modifier un item');
        return $rs;
    }

    /** fct 10 : Suppression d'un item **/
    public function supprimerItem(Request $rq, Response $rs, array $args, $idListe, $idItem): Response {
        $items = Item::query()->where(['liste_id' => $idListe])->get()->toArray();
        Item::query()->where(['liste_id' => $idListe])->where(['id' => $idItem])
           ->delete();
        $vue=new VueIT([], $this->container);
        $rs->getBody()->write($vue->render(3));
        return $rs;
    }
}
