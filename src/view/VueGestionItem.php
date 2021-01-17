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
     * Fct 8 : Affichage du formulaire de la création d'un item
     */
    private function affichageCreationItem() {
        $html = <<<END
        <div class="py-5 text-center">
            <h2>Formulaire création d'un item</h2>
        </div>
        <div>
            <form action ="#" method="post">
                <label for="nom" class="form-label">Nom : </label>
                <input type="text" class="form-control" name="nom" placeholder="" required><br>
                <label for="desc" class="form-label">Description : </label>
                <input type="text" class="form-control" name="desc" placeholder=""><br>
                <label for="tarif" class="form-label">Prix : </label>
                <input type="number" class="form-control" name="tarif" placeholder="" value="0"><br>
                <button type="submit" class="btn btn-danger btn-lg">
                    Ajouter
                </button>
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
                        ${item['descr']}
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
        <div class="py-5 text-center">
            <h2>Modifier votre item ${item['nom']}</h2>
        </div>
        <div>
            <form action ="#" method="post">
                <label for="nom" class="form-label">Nom : </label>
                <input type="text" class="form-control" value="${item['nom']}" name="nom" placeholder="" required><br>
                <label for="desc" class="form-label">Description : </label>
                <input type="text" class="form-control"  value="${item['descr']}" name="desc" placeholder=""><br>
                <label for="tarif" class="form-label">Prix : </label>
                <input type="number" class="form-control" value="${item['tarif']}" name="tarif" placeholder="" value="0"><br>
                <button type="submit" class="btn btn-danger btn-lg">
                    Modifier
                </button>
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
            { //Fct 8 : formulaire de création d'un item
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
