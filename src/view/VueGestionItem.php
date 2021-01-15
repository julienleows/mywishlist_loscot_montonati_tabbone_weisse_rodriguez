<?php


namespace mywishlist\view;

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
                <label for="nom">Nom : </label>
                <input type="text" name="nom" placeholder="<nom>" required><br>
                <label for="desc">Description : </label>
                <input type="text" name="desc" placeholder="<desc>"><br>
                <label for="tarif">Prix : </label>
                <input type="number" name="tarif" placeholder="<tarif>" value="0"><br>
                <button type="submit"> Ajouter </button>
            </form>
        </div>
END;
        return $html;
    }

    private function affichageItemErreur(): string {
        $html = <<<END
        <section class="content">
        <h3> L'item existe deja! Changer le nom de l'item...</h3>
END;
        $html .= $this->affichageCreationItem();
    return $html;
    }

    /**
     * Fct
     * @param $item
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
                    <button type="button" class="btn btn-danger">
                        VOIR LA LISTE
                    </button>
            </div>
            <br><br>                 
END;

    }

    private function affichageModif($item) {
        $html = <<<END
        <div>
            <form action ="#" method="post">
                <legend>Modifier votre item ${item['nom']} : </legend>
                <label for="nom" >Nom : </label>
                <input type="text" name="nom" value="${item['nom']}" placeholder="<nom>" required><br>
                <label for="desc">Description : </label>
                <input type="text" name="desc" value="${item['desc']}" placeholder="<desc>"><br>
                <label for="tarif">Prix : </label>
                <input type="number" name="tarif" value="${item['tarif']}" placeholder="<tarif>" value="0"><br>
                <button type="submit"> Modifier </button>
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
        // TODO render a finir
        $content = null;
        switch ($selecteur) {
            case 1 :
            { //on veut le formulaire de création d'une listes
                $content = $this->affichageCreationItem();
                break;
            }
            case 2:
            {
                $content = $this->affichageItemErreur();
                break;
            }
            case 3:
            {
                $content = $this->affichageModif($this->data[0]);
                break;
            }

        }
        $vueRender = new VueRender($this->container);
        return $vueRender->render($content);
    }

//$content = $this->affichageCreationItem();
//break;

}