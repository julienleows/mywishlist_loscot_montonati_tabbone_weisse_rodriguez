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
use mywishlist\view\VueGestionListe as VueGestionLs;
use mywishlist\view\VueParticipationListe;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use mywishlist\models\Item as Item;
use mywishlist\models\Liste as Liste;

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
          $vue=new VueGestionLs([], $this->container);
            if (sizeof($args) == 3) {
                if (! $this->verificationListeExistante($args)){
                  $this->creationListeBDD($args);
                    $rs = $rs ->withRedirect($this->container->router->pathFor('listes'));
                }
            } else {
                $rs->getBody()->write($vue->render(1));
            }
        } catch (ModelNotFoundException $m) {
            $rs->getBody()->write("Erreur de liste");
        }
        return $rs;
    }

    /**
     * Méthode permettant de vérifier si une liste est déjà existante
     * @param $args
     * @return bool
     */
    private function verificationListeExistante($args){
      try{
        $ls=Liste::query()->where([['titre','=',$args['titre']],
                          ['description', '=', $args['description']],
                          ['expiration', '=', $args['expiration']]])
                          ->FirstOrFail();
        return true;
      } catch (ModelNotFoundException $m) {
        return false;
      }
      return false;
    }

    /**
     * Méthode permettant de créer une liste dans la base de données
     * @param $args
     */
    private function creationListeBDD($args) {
        $ls = new Liste();
        $ls->titre =filter_var($args['titre'],FILTER_SANITIZE_STRING);
        $ls->description = filter_var($args['description'],FILTER_SANITIZE_STRING);
        $ls->expiration =$args['expiration'];
        $ls->token = hash('md5', openssl_random_pseudo_bytes(255) . "secure" . $ls->no);
        $ls->public = 1;
        $ls->save();
    }

    /**
     * Méthode permettant de modifier une liste dans la base de données
     * @param $token
     * @param $post
     */
    private function modifier( $token, $post){
        $liste = Liste::query()->where('token', '=', $token);
        $liste->update(['titre' => $post['titre']]);
        $liste->update(['description'=>$post['description']]);
        $liste->update(['expiration'=>$post['expiration']]);
    }

    /** fct 20 : rendre une liste publique */
    public function rendreListe(Request $rq, Response $rs, $args) {
            $var = ControleurDesListes::ajoutListeEtat($args['token'],$args['public']);
            $rs->getBody()->write($var);
            return $rs->withRedirect($this->container->router->pathFor('listes'));
    }

    /** fct 21 : afficher les listes de souhaits qui sont en publiques */
    public function afficherListePublique(Request $rq, Response $rs, $args) {
        // recup les listes (modele eloquant)
        $lists = Liste::query()->where('public', '=', true)->get();

        //var_dump($lists);
        // instancier une vue (passage des modeles a la vue)
        $vue = new VueGestionListe($lists->toArray(), $this->container);

        // methode render (cf TD13) + cours 14 p5 -> code html
        $rs->getBody()->write($vue->render(2));
        return $rs;
    }

    /** fct de traitement : Rend un booléen indiquant la présence de l'id parmis la liste selectioner */
    public function rendEtatListe($id,$public){
        $var = str_replace(array('{','}','"','public',':'),'',Liste::query()->select("public")->where('no','=',$id)->first());
        if($var == $public){
            return true;
        }else{
            return false;
        }

    }

    /** Ajoute une liste parmis les listes publiques */
    public function ajoutListeEtat($token,$public): string
    {

        if(!ControleurDesListes::rendEtatListe($token,$public)){
            Liste::query()->where('token','=',$token)->update(['public' => $public]);
            return "SUCCES_AJOUT_UNE_INTERFACE_CLAIR_ET_DES_VRAIS_RETOUR";
        }else{
            return "Liste déjà présente";
        }

    }

    /** fct 7 : Modification d'une liste **/
    public function modifierListe(Request $rq, Response $rs, $args, $tmpPost) {
        try {
            if (isset($tmpPost['titre'])) {
                $this->modifier($args['token'], $tmpPost);
                $ls=Liste::query()->where('public','=',1)->get();
                $arrayls = [];
                foreach ($ls as $l) {
                    $arrayls[] = $l;
                }
                $vue=new VueGestionListe($arrayls,$this->container);
                //rs->getBody()->write($vue->render(2));
                $rs = $rs ->withRedirect($this->container->router->pathFor('listes'));
            } else {
                $ls = Liste::query()->where('token','=',$args['token'])->firstOrFail();
                $vue=new VueGestionListe([$ls],$this->container);
                $rs->getBody()->write($vue->render(3));
            }
        } catch (ModelNotFoundException $m) {
            $rs->getBody()->write("Erreur de liste");
        }
        return $rs;
    }

    /**
     * Méthode permettant de supprimer une liste
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function supprimerListe(Request $rq, Response $rs, $args){
        $liste = Liste::query()->where('token', '=', $args['token'])->FirstOrFail();
        $liste->delete();

        $ls = Liste::query()->where('public','=',1)->get();

        $arrayls=[];
        foreach ($ls as $l) {
            $arrayls[] = $l;
        }

        $vue=new VueGestionListe($arrayls,$this->container);
        $rs->getBody()->write($vue->render(2));
        return $rs;
    }
}
