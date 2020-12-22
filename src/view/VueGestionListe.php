<?php


namespace mywishlist\view;

use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;

class VueGestionListe {

    private $data;

    /**
     * Constructeur de la VueParticipant
     * @param array $d modèle
     */
    public function __construct(array $d) {
        $this->data = $d;
    }

    /**
     * Affichage du formulaire de la création de liste
     * @param array $list
     */
    private function affichageCreationListe() {
        $html = <<<END
        <div>
        // Remplire contenu du champ action
        <form action ="" method="POST"> 
        <legend>Formulaire création liste : </legend>
        <label for="titre">Titre : </label>
        <input type="text" name="titre" placeholder="<titre>" required><br>
        <label for="desc">Description : </label>
        <input type="text" name="description" placeholder="<description>"><br>
        <label for="exp">Date limite : </label>
        <input type="date" name="expiration" placeholder="<expiration>"><br>       
</form>
</div>
END;
        return $html;
    }

    /**
     * Affichage de la modifications des infos d'une liste
     * @param array $list
     */
    private function affichageModificationsListe(array $list) {

    }

    /**
     * Affichage de la mise en public d'une liste
     * @param array $list
     */
    private function affichagePublicListe(array $list) {

    }

    /**
     * Affichage de la liste des listes publiques
     * @param array $list
     */
    private function affichageListe(array $list) {

    }


    /**
     * Méthode pour choisir l'affichage désiré et retourner le resultat de cet affichage
     * @param $selecteur
     */
    public function render($selecteur) {
        // TODO render a finir
        switch ($selecteur) {
            case 1 :
            { //on veut le formulaire de création d'une listes
                $content = $this->affichageCreationListe();
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