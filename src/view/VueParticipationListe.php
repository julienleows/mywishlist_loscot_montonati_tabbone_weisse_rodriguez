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
     * @param array $items ensemble des items à afficher
     * @param Liste $ls liste dont on souhaite afficher les items
     * @return string
     */
    private function affichageElementsListe(array $items): string {
        try {
            $ls=Liste::query()->where('no','=',$items[0]->liste_id)
                    ->firstOrFail();
        }
        catch (ModelNotFoundException $m) {
            $ls="";
        }
        $html = <<<END
        <div><ul>
        <button type="button" class="btn btn-danger" onclick="window.location.href='{$this->container->router->pathFor('creaitem', ['token'=>$ls->token])}';">
             AJOUTER ITEM
        </button>
END;
        if (sizeof($items) != 0) {
            foreach ($items as $it) {
                $html.=$this->affichageItem($it);
            }
        }
        else {
            $html .= "<h1> LA LISTE N'A PAS D'ITEMS </h1>";
        }
        $html .= "</ul></div>";
        return $html;
    }


    /**
     * Fct 2 : Affichage d'un item
     * @param Item $item item qu'on souhaite afficher
     * @return string
     */
    private function affichageItem($item): string {
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
            <button type="button" class="btn btn-danger" onclick="window.location.href='{$this->container->router->pathFor('reserver', ['idListe'=>$item['liste_id'], 'id'=>$item['id']])}';">
                 RESERVER ITEM
            </button>
        </section>
END;
        return $html;
    }

    /**
     * Fct 3 :
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
        }else if(isset($_COOKIE['nomReservation'])){
            $valueCookie = $_COOKIE['nomReservation'];
        }



        if (!$reservation->exists()) {

            $rendu = $rendu . '<br></br>


                      <form action="" method="get">
                 <p>Votre nom : <input type="text" name="nom" value = ' . $valueCookie . '></p>
                 <p>Votre message : <input type="text" name="message" /></p>
                 <p><input type="submit" value="Compléter la réservation"></p>
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

        /* CSS
          <style>
                            h1{ text-align: center; }
                            table, th, td {
                              border: 1px solid black;
                              border-collapse: collapse;
                            }
                            table{
                            margin: 0 auto;
                            }
                            td{
                             text-align: center;
                            }';


            $rendu = $rendu . 'form {
                          margin: 0 auto;
                          width: 400px;
                          padding: 1em;
                          border: 1px solid #CCC;
                          border-radius: 1em;
                        }

                        form div + div {
                          margin-top: 1em;
                        }

                        label {
                          width: 90px;
                          text-align: right;
                        }

                        input, textarea {
                          font: 1em sans-serif;
                          width: 300px;
                          box-sizing: border-box;
                          border: 1px solid #999;
                        }

                        input:focus, textarea:focus {
                          border-color: #000;
                        }

                        textarea {
                          vertical-align: top;
                          height: 5em;
                        }

                        .button {
                          padding-left: 90px;
                        }

                        button {
                          margin-left: .5em;
                        }';


        */
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
                break;
            case 4 :
            { // veut un item spécifique
                $content = $this->affichagePostModif($this->data);
                break;
            }
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