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
use mywishlist\models\Liste;
use mywishlist\view\VueGestionItem as VueIT;
use mywishlist\view\VueParticipationListe as VuePL;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use mywishlist\models\Item as Item;


class ControleurDesItems {

    /** instance container */
    private $container;

    /** constructeur vide de la classe ControleurDesItems */
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /** fct 8 : créer un item */
    public function creerItem(Request $rq, Response $rs, $args,$tmpPOST) {
        try {
            if (isset($tmpPOST['nom'])) {
                    $it = new Item();
                    $it->nom = filter_var($tmpPOST['nom'],FILTER_SANITIZE_STRING);
                    $it->descr = filter_var($tmpPOST['desc'],FILTER_SANITIZE_STRING);
                    $it->tarif = filter_var($tmpPOST['tarif'],FILTER_SANITIZE_NUMBER_INT);
                    $ls=Liste::query()->where('token','=',$args['token'])
                            ->firstOrFail();
                    $it->liste_id = $ls->no;
                    $it->save();
                    $vue=new VuePL([$it],$this->container);
                    $rs->getBody()->write($vue->render(1, $args['token']));
            } else {
                $it = '';
                $vue=new VueIT([$it],$this->container);
                $rs->getBody()->write($vue->render(1));
            }
        } catch (ModelNotFoundException $m) {
            $rs->getBody()->write("Erreur de liste");
        }
        return $rs;
    }

    /** fct 9 : Modification d'un item **/
    public function modifierItem(Request $rq, Response $rs, $args, $tmpPost) {
        try{
            if(isset($tmpPost['nom'])){
                $this->modifier($args['idItem'], $tmpPost);
                $ls = Liste::query()->where('token','=',$args['token'])->firstOrFail();
                $items = Item::query()->where('liste_id', '=', $ls->no)->get();
                $lsItem=[];
                foreach ($items as $it) {
                    $lsItem[] = $it;
                }
                $vue=new VuePL($lsItem, $this->container);
                $rs->getBody()->write($vue->render(1, $args['token']));
            }
            else{
                $item = Item::query()->where('id', '=', $args['idItem'])->firstOrFail();
                $vue = new VueIT([$item], $this->container);
                $rs->getBody()->write($vue->render(3));
            }
        }  catch (ModelNotFoundException $m) {
            $rs->getBody()->write("Erreur de liste");
        }
        return $rs;
    }

    /**
     * Méthode permettant de modifier un item dans la base de données
     * @param $iditem
     * @param $post
     */
    private function modifier( $iditem, $post){
        $item = Item::query()->where('id', '=', $iditem);
        $item->update(['nom' => filter_var($post['nom'],FILTER_SANITIZE_STRING)]);
        $item->update(['descr'=>filter_var( $post['desc'],FILTER_SANITIZE_STRING)]);
        $item->update(['tarif'=> filter_var( $post['tarif'],FILTER_SANITIZE_STRING)]);
    }

    /** fct 10 : Suppression d'un item **/
    public function supprimerItem(Request $rq, Response $rs,$args): Response {
        $itemDel = Item::query()->where('id','=',$args['idItem'])->FirstOrFail();
        $liste = Liste::query()->where('no', '=', $itemDel['liste_id'])->FirstOrFail();
        Item::query()->where('id','=',$args['idItem'])->delete();
        $items = Item::query()->where('liste_id','=', $itemDel['liste_id'])->get();
        $lsItem=[];
        foreach ($items as $it) {
            $lsItem[] = $it;
        }
        $vue=new VuePL([$itemDel, $lsItem], $this->container);
        $url = $this->container->router->pathFor('liste',['token'=>$liste['token']]);
        return $rs->withRedirect($url);
    }
}
