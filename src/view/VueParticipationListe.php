<?php


namespace mywishlist\view;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;
use mywishlist\models\Reservation as reservation;

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
     * @param $token le token qui permet de retrouver les items et la liste
     * @return string
     */
    private function affichageElementsListe($token): string {
        try {
            $ls=Liste::query()->where('token','=',$token)
                    ->firstOrFail(); // sa doit marcher
            $item = Item::query()->where('liste_id','=',$ls->no)
                    ->get(); // si sa sa marche pas, alors on a une liste d'items vides
            // on transforme maintenant ces items en tableaux d'items
            $items = [];
            foreach ($item as $it) {
              $items[] = $it;
            }
        }
        catch (ModelNotFoundException $m) {
            $items=[];
        }

        $html = <<<END
            <link rel="stylesheet" href="{$this->container->router->pathFor('racine')}css/csslistesaffichage.css" type="text/css"/>
            <br>
          <div class="titre-liste">
                    <h3>{$ls->titre}</h3>
                </div>
                    <p>
                        {$ls->description}
                        <ul>
                            <li>Expire le {$ls->expiration}</li>
                        </ul>
                    </p>

END;

        if (sizeof($items) != 0) {
            foreach ($items as $it) {
                $html .= '<br>';
                $html.=$this->affichageItem($it);
                $html .= '<br>';
            }
        }
        else {
            $html .= "<br><h1> LA LISTE N'A PAS D'ITEMS </h1><br>";
        }
        $html .= "</ul></div>";

        $html .= <<<END
        <br>
        <div><ul>
        <button type="button" class="btn btn-danger" onclick="window.location.href='{$this->container->router->pathFor('creaitem', ['token'=>$token])}';">
             AJOUTER ITEM
        </button>
END;
        return $html;
    }


    /**
     * Fct 2 : Affichage d'un item
     * @param Item $item item qu'on souhaite afficher
     * @return string
     */
    private function affichageItem($item): string {
        $ls = Liste::query()->where('no','=',$item['liste_id'])->firstOrFail();
        $html = <<<END
        <link rel="stylesheet" href="{$this->container->router->pathFor('racine')}css/cssitems.css" type="text/css"/>
        <div class="content boite-liste-item">
            <h1> <u>Nom</u> : $item->nom</h1>
            <h6> <u>Desciption </u>: $item->descr</h6>
            <h6> <u>Tarif </u>: $item->tarif</h6> 
            <button type="button" class="btn btn-danger" onclick="window.location.href='{$this->container->router->pathFor('reserver', ['idListe'=>$item['liste_id'], 'id'=>$item['id']])}';">
                 RESERVER ITEM
            </button>
            <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{$this->container->router->pathFor('modifitem', ['token'=>$ls->token, 'idItem'=>$item['id']])}';">
                 MODIFIER ITEM
            </button>
            <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{$this->container->router->pathFor('suppitem', ['idListe'=>$item['liste_id'], 'idItem'=>$item['id']])}';">
                 SUPPRIMER ITEM
            </button>
           
        </div>
END;
        return $html;
    }

    /**
     * Fct 3 : Méthode pour afficher la reservation d'un item
     */
    private function affichageReservation($item) : string{
        $reservation = Reservation::query()->where('id', '=', $item['id']);

        $rendu = '<!DOCTYPE html>
                 <html lang="fr">
                    <head>
                        <meta charset="UTF-8">
                        <title>ITEM</title>
                      </head>
                   <body>
                    <h1>ITEM PAGE</h1>

                    <br></br>
                    <br></br>

                    <div class="InformationItem">
                        <table>
                            <tr>
                                <td>ID</td>
                                <td>LISTE_ID</td>
                                <td>NOM</td>
                                <td>DESCRIPTION</td>
                                <td>IMG</td>
                                <td>URL</td>
                                <td>TARIF</td>
                            </tr>
                            <tr>
                                <td>' . $item['id'] . '</td>
                                <td>' . $item['liste_id'] . '</td>
                                <td>' . $item['nom'] . '</td>
                                <td>' . $item['descr'] . '</td>
                                <td>' . $item['img'] . '</td>
                                <td>' . $item['url'] . '</td>
                                <td>' . $item['tarif'] . '</td>
                            </tr>
                        </table>
                    </div>';




        $valueCookie = '';
        if(isset($_GET['nom'])){
            $valueCookie = $_GET['nom'];
            $_SESSION['nomReservation'] = $valueCookie;
        }else if(isset($_SESSION['nomReservation'])){
            $valueCookie = $_SESSION['nomReservation'];
        }

        if (!$reservation->exists()) {

            $rendu = $rendu . '<br></br>


                <form action="" method="get">
                <label for="nom" class="form-label">Votre nom</label>
                <input type="text" class="form-control" name="nom" value = ' . $valueCookie . '>
                
                <label for="message" class="form-label">Votre message</label>
                <input type="text" class="form-control" name="message"/>
                <br>
                <button type="submit" class="btn btn-danger btn-lg">
                    Valider la réservation
                </button>
                </form>

                        ';
        }else{

            $nom = str_replace(array('{','"','}','nom',':','[',']'),'',$reservation->get('nom'));
            if ($valueCookie == $nom) {
                $rendu = $rendu . '<br><p> La table fait partie de vos réservations </p>';


            }else{
                $rendu .= '<br><br> <p> La liste est réserver par : ' . $nom . '</p>';
            }
        }



        $rendu = $rendu . '</body>
                </html>';
        return $rendu;
    }

    /**
     * Méthode pour choisir l'affichage désiré et retourner le resultat de cet affichage
     * @param $selecteur
     * @param $other_args peut etre facultatif
     */
    public function render($selecteur, ...$other_args): string {
        if (! isset($other_args[0])){
          $other_args[0] = 'empty';
        }
        $content = null;
        switch ($selecteur) {
            case 1 :
            { //on veut l'ensemble des élements d'une liste
                $content = $this->affichageElementsListe($other_args[0]);
                break;
            }
            case 2 :
            { //on veut un item spécifique
                $content = $this->affichageItem($this->data[0]);
                break;
            }
            case 3 :
                break;
            case 5 :
                { // veut reserver un item
                    $content = $this->affichageReservation($this->data[0]);
                    break;
                }
        }
        $vueRender = new VueRender($this->container);
        return $vueRender->render($content);
    }

}
