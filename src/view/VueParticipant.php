<?php

namespace mywishlist\view;

use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;

class VueParticipant {

    private $tab; // ? -> quel utilité pour cet attribut ?
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
     * Méthode pour choisir l'affichage désiré
     * @param array $vars // TODO a quoi sert cette attributs ?
     * @param $selecteur
     */
    public function render(array $vars, $selecteur) {
        // TODO render a finir
    }

}