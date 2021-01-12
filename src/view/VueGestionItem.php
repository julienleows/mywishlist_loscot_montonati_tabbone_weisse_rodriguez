<?php


namespace mywishlist\view;

use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;

class VueGestionItem {

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
     * Affichage du formulaire de la création d'un item
     */
    private function affichageCreationItem() {
        $html = <<<END
        <div>
            <form action ="#" method="post">
                <legend>Formulaire création d'un item : </legend>
                <label for="titre">Nom : </label>
                <input type="text" name="titre" placeholder="<titre>" required><br>
                <label for="desc">Description : </label>
                <input type="text" name="description" placeholder="<description>"><br>
                <label for="exp">Prix : </label>
                <input type="date" name="expiration" placeholder="<expiration>"><br>
                <button type="submit"> Ajouter </button>
            </form>
        </div>
END;
        return $html;
    }

    /**
     * Fct
     * @param $liste
     * @return string
     */
    private function affichage1Item($item){
        return <<<END
            <link rel="stylesheet" href="{$this->container->router->pathFor('racine')}/css/cssitems.css" type="text/css"/>
            <br>
            <div class="boite-liste"'>
                <div class="titre-liste">
                    <h3>${item['nom']}</h3>
                </div>
                    <p>
                        ${item['desc']}
                        <ul>
                            <li>Expire le ${item['tarif']}</li>
                        </ul>
                    </p>
                        
                    <br>
                        
                    <button type="button" class="btn btn-danger" onclick="window.location.href='{$this->container->router->pathFor('liste',['token'=>$liste['token']])}';">
                        VOIR LA LISTE
                    </button>
            </div>
            <br><br>                 
END;

    }

    /**
     * Fct 20 : Affichage des items
     */
    private function affichageItems() {
        $html = "";
        foreach ($this->data as $it) {
            $html .= $this->affichage1Item($it);
        }
        return $html;
    }


    /**
     * Méthode pour choisir l'affichage désiré et retourner le resultat de cet affichage
     * @param $selecteur
     */
    public function render($selecteur) {
        // TODO render a finir
        $content = $this->affichageItems();
        $vueRender = new VueRender($this->container);
        return $vueRender->render($content);
    }

//$content = $this->affichageCreationItem();
//break;

}