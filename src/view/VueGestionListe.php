<?php


namespace mywishlist\view;

use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;

class VueGestionListe {

    private $data;
    private $container;

    /**
     * Constructeur de la VueParticipant
     * @param array $d modèle
     */
    public function __construct(array $d, $c) {
        $this->data = $d;
        $this->container = $c;
    }

    /**
     * Affichage du formulaire de la création de liste
     * @param array $list
     */
    private function affichageCreationListe() {
        $html = <<<END
        <div class="py-5 text-center">
              <h2>Creation d'une liste</h2>
              <p class="lead">blablablabla</p>
        </div>

        <div>
            <form action ="#" method="post">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" class="form-control" name="titre" placeholder="" required><br>
                
                <label for="desc" class="form-label">Description</label>
                <input type="text" class="form-control" name="description" placeholder="" required><br>

                <label for="exp" class="form-label">Date limite</label>
                <input type="date" class="form-control" name="expiration" placeholder="" required><br>
                <button type="submit" class="btn btn-danger btn-lg" onclick="window.location.href='#';">
                    Créer la liste
                </button>
            </form>
        </div>
END;
        return $html;
    }

    /**
     * Affichage de la modifications des infos d'une liste
     * @param array $list
     */
    private function affichageModificationsListe(array $list) {

    }

    /**
     * Fct
     * @param $liste
     * @return string
     */
    private function affichage1Liste($liste){
        return <<<END
            <link rel="stylesheet" href="{$this->container->router->pathFor('racine')}/css/csslistesaffichage.css" type="text/css"/>
            <br>
            <div class="boite-liste"'>
                <div class="titre-liste">
                    <h3>${liste['titre']}</h3>
                </div>
                    <p>
                        ${liste['description']}
                        <ul>
                            <li>Expire le ${liste['expiration']}</li>
                        </ul>
                    </p>
                        
                    <br>
                        
                    <button type="button" class="btn btn-danger" onclick="window.location.href='{$this->container->router->pathFor('liste',['token'=>$liste['token']])}';">
                        VOIR LA LISTE
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{$this->container->router->pathFor('rendreListe',['public' => 1,'token' => $liste['token']])}';">
                        RENDRE LISTE PUBLIC
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{$this->container->router->pathFor('rendreListe',['public' => 0, 'token' => $liste['token']])}';">
                        RENDRE LISTE PRIVE
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{$this->container->router->pathFor('rendreListe',['public' => 2,'token' => $liste['token']])}';">
                        RENDRE LISTE NON REPERTORIE
                    </button>
            </div>
            <br><br>                 
END;
    }

    /**
     * Fct 20 : Affichage des listes publiques
     * @param array $list
     */
    private function affichagePublicListe() {
        $html = "";
        foreach ($this->data as $ls) {
            $html .= $this->affichage1Liste($ls);
        }
        return $html;
    }


    /**
     * Méthode pour choisir l'affichage désiré et retourner le resultat de cet affichage
     * @param $selecteur
     */
    public function render($selecteur) {
        // TODO render a finir
        $content = null;
        switch ($selecteur) {
            case 1 :
            { //on veut le formulaire de création d'une listes
                $content = $this->affichageCreationListe();
                break;
            }

            case 2 :
            { // affichage des listes publiques
                $content = $this->affichagePublicListe();
                break;
            }
        }
        $vueRender = new VueRender($this->container);
        return $vueRender->render($content);
    }
}
