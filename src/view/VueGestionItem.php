<?php


namespace mywishlist\view;

use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;

class VueGestionItem {

    private $data;

    /**
     * Constructeur de la VueParticipant
     * @param array $d modèle
     */
    public function __construct(array $d) {
        $this->data = $d;
    }

    private function ajouterItem() {
        $html = <<<END
        <div>
            <form action ="#" method="post">
                <legend>Formulaire création d'un item : </legend>
                <label for="nom">Nom : </label>
                <input type="text" name="nom" placeholder="<nom>" required><br>
                <label for="desc">Description : </label>
                <input type="text" name="description" placeholder="<description>"><br>
                <label for="desc">Prix : </label>
                <input type="prix" name="prix" placeholder="<prix>"><br>
                <button type="submit"> Envoyer </button>
            </form>
        </div>
END;
        return $html;
    }
    /**
     * Méthode pour choisir l'affichage désiré et retourner le resultat de cet affichage
     * @param $selecteur
     */
    public function render($selecteur) {
        $content = null;
        switch ($selecteur) {
            case 1 :
            { //on veut le formulaire decréation d'un item pour l'ajouter à une liste
                $content = $this->ajouterItem();
                break;
            }
            case 2 :
            {
            }
        }
        $vueRender = new VueRender();
        return $vueRender->render($content);
    }

}