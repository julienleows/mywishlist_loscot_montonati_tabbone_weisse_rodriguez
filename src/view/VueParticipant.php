<?php


namespace mywishlist\view;

use mywishlist\models\item as item;
use mywishlist\models\liste as liste;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class VueParticipant
{
    private $tab;

    public function __construct(array $t) {
        $this->tab=$t;
    }

    private function affichageListe(array $list) {

    }

    private function affichageElementsListe(array $items,liste $ls) : string {

    }

    private function affichageItem(item $item) : string {
        $html=<<<END
        <section class="content">
        <h1>Nom : ($item->nom)</h1>
        <p> Desciption : ($item->descr)</p>
        <h3>Tarif : ($item->tarif)</h3>
</section>  
END;
    return $html;
    }

    public function render(array $vars) {

    }

}