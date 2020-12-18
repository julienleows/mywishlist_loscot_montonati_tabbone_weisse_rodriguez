<?php

namespace mywishlist\view;

use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;

class VueParticipant {

    private $tab;
    private $container;

    /**
     * Constructeur de la VueParticipant
     * @param array $t modèle
     */
    public function __construct(array $t, \Slim\Container $container) {
        $this->tab = $t;
        $this->container = $container;
    }

    /**
     * Afficha de la liste des listes publiques
     * @param array $list
     */
    private function affichageListe(array $list) {

    }

    /**
     * Affichage de l'ensemble des élements d'une liste
     * @param array $items ensemble des items à afficher
     * @param Liste $ls liste dont on souhaite afficher les items
     * @return string
     */
    private function affichageElementsListe(array $items, Liste $ls): string {
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
     * Méthode pour choisir l'affichage désiré
     * @param array $vars // TODO a quoi sert cette attributs ?
     * @param $selecteur
     */
    public function render(array $vars, $selecteur) {
        // TODO render a finir
    }

}