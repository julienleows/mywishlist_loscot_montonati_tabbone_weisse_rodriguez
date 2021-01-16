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
use mywishlist\models\Item as Item;


class ControleurDesItems {

    /** instance container */
    private $container;

    /** constructeur vide de la classe ControleurDesItems : pour l'instant **/
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /** fct 8 : créer un item */
    public function creerItem(Request $rq, Response $rs, $args) {
        try {
            if (sizeof($args) == 3) {
                if (! $this->verificationItemExistant($args)){
                    $it = new Item();
                    $it->nom = $args['nom'];
                    $it->descr = $args['descr'];
                    $it->tarif = $args['tarif'];
                    // img / url a voir plus tard
                    //$ls->tarif = $args['tarif'];
                    $it->save();
                    $vue=new VueIT([$it],$this->container);
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

    /**
     * Méthode permettant de vérifier si un item est présent dans une liste
     * @param $args
     * @return bool true sur l'item est présent et false sinon
     */
    private function verificationItemExistant($args){
        try{
            $item=Item::query()->where(['id' => $args['id']])
                    ->FirstOrFail();
            return true;
        } catch (ModelNotFoundException $m) {
            return false;
        } // c'est debile, mais on peut pas enlever cette ligne
        return false;
    }

    private function creationItemBDD($args, $liste_id) {

    }

    /** fct 9 : Modification d'un item **/
    public function modifierItem(Request $rq, Response $rs, array $args, $iditem): Response {
        $item = Item::where('id', $iditem)->FirstOrFail();
        try{
            if(sizeof($args) == 3){
                $this->modifier($item['id'], $args);
                $items = Item::query()->where('liste_id', $item['liste_id'])->get();
                $lsItem=[];
                foreach ($items as $it) {
                    $lsItem[] = $it;
                }
                $vue=new VuePL($lsItem, $this->container);
                $rs->getBody()->write($vue->render(4));
            }
            else{
                $vue = new VueIT([$item], $this->container);
                $rs->getBody()->write($vue->render(3));
            }
        }  catch (ModelNotFoundException $m) {
            $rs->getBody()->write("Erreur de liste");
        }
        return $rs;
    }

    private function modifier( $iditem, $args){
        Item::query()->where('id', $iditem)
            ->update(['nom' => $args['nom']], ['descr'=>$args['desc']], ['tarif'=>$args['tarif']]);
    }

    /** fct 10 : Suppression d'un item **/
    public function supprimerItem(Request $rq, Response $rs, array $args, $idItem): Response {
        $itemDel = Item::query()->where('id', $idItem)->FirstOrFail();
        Item::query()->where(['id' => $idItem])->delete();
        $items = Item::query()->where('liste_id', $itemDel['liste_id'])->get();
        $lsItem=[];
        foreach ($items as $it) {
            $lsItem[] = $it;
        }
        $vue=new VuePL([$itemDel, $lsItem], $this->container);
        $rs->getBody()->write($vue->render(3));
        return $rs;
    }
}
