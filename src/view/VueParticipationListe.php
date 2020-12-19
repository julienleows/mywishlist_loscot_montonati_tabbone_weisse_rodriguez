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
     * Affichage de l'ensemble des élements d'une liste
     * @param array $items ensemble des items à afficher
     * @param Liste $ls liste dont on souhaite afficher les items
     * @return string
     */
    private function affichageElementsListe(array $items): string {
        $html = "<div><ul>";
        foreach ($items as $it) {
            $html .= "<li>" . $it->nom . "</li>";
        }
        $html .= "</ul></div>";
        return $html;
    }

    /**
     * Affichage d'un item
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
        switch ($selecteur) {
            case 1 :
            { //on veut l'ensemble des élements d'une liste
                $content = $this->affichageElementsListe($this->data[0]);
                break;
            }
            case 2 :
            { //on veut un item spécifique
                $content = $this->affichageItem($this->data[0]);
                break;
            }
        }
        $html = <<<END
<!DOCTYPE html>
<html>
  <head>
    <title>Exemple</title>
  </head>
  <body>
		<h1>Wish List</h1>
    $content
  </body>
</html>
END;
        return $html;
    }

}