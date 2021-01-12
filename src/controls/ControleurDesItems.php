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
    public function creerItem(Request $rq, Response $rs, $args) {
        try {
            if (sizeof($args) == 3) {
                if (! $this->verificationItemExistante($args)){
                    $this->creationItemBDD($args);
                    $rs->getBody()->write("envoie réussie");
                } else {
                    $rs->getBody()->write("Cet Item existe deja!");
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

    private function verificationItemExistante($args){
        try{
            $ls=Item::query()->where(['nom','=',$args['nom']])
                ->FirstOrFail();
            return true;
        } catch (ModelNotFoundException $m) {
            return false;
        } // c'est debile, mais on peut pas enlever cette ligne
        return false;
    }

    private function creationItemBDD($args) {
        $ls = new Item();
        $ls->titre = $args['nom'];
        $ls->descr = $args['descr'];
        $ls->liste_id = $args['listeID'];
        // img / url a voir plus tard
        $ls->tarif = $args['tarif'];
        $ls->save();
    }
















    /** fct 8 : Ajouter un item **/
    public function ajouterItem(Request $rq, Response $rs, array $args): Response {
        $it=new Item();
        $it->nom=$args['nom'];
        $it->descr=$args['descr'];
        $it->prix=$args['prix'];
        $vue=new VueGestionItem($it);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }

    /** fct 9 : Modification d'un item **/
    public function modifierItem(Request $rq, Response $rs, array $args): Response {
        $rs->getBody()->write('s\'modifier un item');
        return $rs;
    }

    /** fct 10 : Suppression d'un item **/
    public function supprimerItem(Request $rq, Response $rs, array $args): Response {
        $rs->getBody()->write('s\'supprimer un item');
        return $rs;
    }
}
