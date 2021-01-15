<?php


namespace mywishlist\view;

use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;

class VueParticipationListe {

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
     * Fct 1 : Affichage de l'ensemble des élements d'une liste
     * @param array $items ensemble des items à afficher
     * @param Liste $ls liste dont on souhaite afficher les items
     * @return string
     */
    private function affichageElementsListe(array $items): string {
        print_r($items);
        $html = <<<END
        <div><ul>
        <button type="button" class="btn btn-danger" onclick="window.location.href='{$this->container->router->pathFor('creaitem', ['token'=>$items[0]['liste_id']])}';">
             AJOUTER ITEM
        </button>
END;
        if (sizeof($items) != 0) {
            foreach ($items as $it) {
                $html.=$this->affichageItem($it);
            }
        }
        else {
            $html ="<h1> LA LISTE N'A PAS D'ITEMS </h1>";
        }
        $html .= "</ul></div>";
        return $html;
    }


    /**
     * Fct 2 : Affichage d'un item
     * @param Item $item item qu'on souhaite afficher
     * @return string
     */
    private function affichageItem(Item $item): string {
        $html = <<<END
        <section class="content">
            <h1> <u>Nom</u> : $item->nom</h1>
            <h3> <u>Desciption </u>: $item->descr</h3>
            <h3> <u>Tarif </u>: $item->tarif</h3>
            <button type="button" class="btn btn-danger" onclick="window.location.href='{$this->container->router->pathFor('modifitem', ['idListe'=>$item['liste_id'], 'idItem'=>$item['id']])}';">
                 MODIFIER ITEM
            </button>
            <button type="button" class="btn btn-danger" onclick="window.location.href='{$this->container->router->pathFor('suppitem', ['idListe'=>$item['liste_id'], 'idItem'=>$item['id']])}';">
                 SUPPRIMER ITEM
            </button>
        </section>
END;
        return $html;
    }


    /**
     * Fct 2 : Affichage de la liste apres suppreson
     * @param Item $item item qu'on souhaite afficher
     * @return string
     */
    private function supprimerItem(array $items): string {
        $html = <<<END
        <section class="content">
        <h3> L'item a été correctement supprimé </h3>
</section>
END;
        print_r($items);
        $html .= $this->affichageElementsListe($items);
        return $html;
    }

    /**
     * Fct 4 : Affichage de la liste apres Modiff
     * @param Item $item item qu'on souhaite afficher
     * @return string
     */
    private function affichagePostModif(array $items): string {
        $html = <<<END
        <section class="content">
        <h3> L'item a été correctement modifié </h3>
</section>
END;
        $html .= $this->affichageElementsListe($items);
        return $html;
    }



    /**
     * Méthode pour choisir l'affichage désiré et retourner le resultat de cet affichage
     * @param $selecteur
     */
    public function render($selecteur): string {
        $content = null;
        switch ($selecteur) {
            case 1 :
            { //on veut l'ensemble des élements d'une liste
                $content = $this->affichageElementsListe($this->data);
                break;
            }
            case 2 :
            { //on veut un item spécifique
                $content = $this->affichageItem($this->data[0]);
                break;
            }
            case 3 :
            { // veut un item spécifique
                $content = $this->supprimerItem($this->data);
                break;
            }
            case 4 :
            { // veut un item spécifique
                $content = $this->affichagePostModif($this->data[0]);
                break;
            }
        }
        $vueRender = new VueRender($this->container);
        return $vueRender->render($content);
    }

}