<?php


namespace mywishlist\view;

use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;

class VueParticipationListe {

    private $data;

    /**
     * Constructeur de la VueParticipant
     * @param array $d modèle
     */
    public function __construct(array $d) {
        $this->data = $d;
    }

    /**
     * Fct 1 : Affichage de l'ensemble des élements d'une liste
     * @param array $items ensemble des items à afficher
     * @param Liste $ls liste dont on souhaite afficher les items
     * @return string
     */
    private function affichageElementsListe(array $items): string {
        $html = "<div><ul>";
        foreach ($items as $it) {
            $html .= "<li>" . $it->no . "</li>";
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
        <h1>Nom : ($item->nom)</h1>
        <p> Desciption : ($item->descr)</p>
        <h3>Tarif : ($item->tarif)</h3>
</section>
END;
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
        }
        $vueRender = new VueRender();
        return $vueRender->render($content);
    }

}
