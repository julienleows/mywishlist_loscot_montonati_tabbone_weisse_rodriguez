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
        <div>
            <form action ="#" method="post">
                <legend>Formulaire création liste : </legend>
                <label for="titre">Titre : </label>
                <input type="text" name="titre" placeholder="<titre>" required><br>
                <label for="desc">Description : </label>
                <input type="text" name="description" placeholder="<description>"><br>
                <label for="exp">Date limite : </label>
                <input type="date" name="expiration" placeholder="<expiration>"><br>
                <button type="submit"> Envoyer </button>
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
             <br>
            <div style='border:4px solid black; padding: 10px;'>
                    <div style='text-transform: uppercase;'>
                        <h3>${liste['titre']}</h3>
                    </div>
                    <div>
                        <p>
                            ${liste['description']}
                            <ul>
                                <li>Expire le ${liste['expiration']}</li>
                            </ul>
                        </p>
                        
                        <br>
                        <a href='{$this->container->router->pathFor('liste',['token'=>$liste['token']])}' style='background: white; border:4px solid black; padding: 5px; text-decoration: none;'> VOIR LA LISTE</a><br><br>
                    </div>
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
