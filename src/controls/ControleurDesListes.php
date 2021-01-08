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
            if (sizeof($args) == 3) {
                if (! $this->verificationListeExistante($args)){
                  $this->creationListeBDD($args);
                  $rs->getBody()->write("envoie réussie");
                } else {
                  $rs->getBody()->write("cette liste existe deja !");
                }
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

    private function verificationListeExistante($args){
      try{
        $ls=Liste::query()->where([['titre','=',$args['titre']],
                          ['description', '=', $args['description']],
                          ['expiration', '=', $args['expiration']]])
                          ->FirstOrFail();
        return true;
      } catch (ModelNotFoundException $m) {
        return false;
      } // c'est debile, mais on peut pas enlever cette ligne
      return false;
    }

    private function creationListeBDD($args) {
        $ls = new Liste();
        $ls->titre = $args['titre'];
        $ls->description = $args['description'];
        // userid a voir plus tard
        $ls->expiration = $args['expiration'];
        $ls->token = 'secure';
        // $ls->public = false;
        $ls->save();
    }

    /** fct 7 : modifier les informations générales d'une de ses listes */
    public function modifierInformationsListe(Request $rq, Response $rs, $args) {
        $rs->getBody()->write('modifier informationsListe');
        return $rs;
    }

    /** fct 20 : rendre une liste publique */
    public function rendreListePublique(Request $rq, Response $rs, $args) {
            $var = ControleurDesListes::ajoutListePublique($args['id']);
            $rs->getBody()->write($var . ' TOTO : ' . str_replace(array('{','}','"','public',':'),'',Liste::query()->select("public")->where('user_id','=',$args['id'])->first()));
            return $rs;
    }

    public function suppressionListePublique(Request $rq, Response $rs, $args) {
        $var = ControleurDesListes::suppresionListePublique($args['id']);
        $rs->getBody()->write($var . ' TOTO');
        return $rs;
    }

    /** fct 21 : afficher les listes de souhaits qui sont en publiques */
    public function afficherListePublique(Request $rq, Response $rs, $args) {
        // recup les listes (modele eloquant)
        $lists = Liste::query()->where('public', '=', true)->get();

        //var_dump($lists);
        // instancier une vue (passage des modeles a la vue)
        $vue = new VueGestionListe($lists->toArray());

        // methode render (cf TD13) + cours 14 p5 -> code html
        $rs->getBody()->write($vue->render(2));
        return $rs;
    }

    /** fct de traitement : Rend la description de la liste publique */
/*
    public function rendIdListeSouhait($no){
        $var = Liste::query()->select("user_id")->where('user_id','=',$no)->first();
        $varT = str_replace(array('user_id','{','}','"',':'),'',$var);
        return $varT;
    }
*/

    /** fct de traitement : Rend la description de la liste publique */
    /*
    public function rendDescription(){
        $var = Liste::query()->select("description")->where('user_id','=',0)->first();
        $varT = str_replace(array('description','{','}','"',':'),'',$var);
        return $varT;
    }
*/
    /** fct de traitement : Rend un booléen indiquant la présence de l'id parmis la liste publiques au sein de la description */
    public function rendPublicListe($id){
        $var = str_replace(array('{','}','"','public',':'),'',Liste::query()->select("public")->where('user_id','=',$id)->first());
        if($var == '1'){
            return true;
        }else{
            return false;
        }

    }

    public function ajoutListePublique($id): string
    {

        if(!ControleurDesListes::rendPublicListe($id)){
            Liste::query()->where('user_id','=',$id)->update(['public' => '1']);
            return "SUCCES_AJOUT_UNE_INTERFACE_CLAIR_ET_DES_VRAIS_RETOUR";
        }else{
            return "Liste déjà présente";
        }

    }

    public function suppresionListePublique($id){

        if(ControleurDesListes::rendPublicListe($id)){
            Liste::query()->where('user_id','=',$id)->update(['public' => '0']);
             return "SUCCES_SUPRESS_UNE_INTERFACE_CLAIR_LA_ET_DES_VRAIS_RETOUR";
        }else{
            return "Liste pas présente";
        }

    }
}
