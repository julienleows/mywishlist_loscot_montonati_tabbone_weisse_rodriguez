<?php
/**
 * Fichier: ControleurParticipationListe
 * description: le controleur de gestion de la participation a une liste
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONTONATI
 */

namespace mywishlist\controls;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use mywishlist\view\VueParticipationListe;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use mywishlist\models\Item as Item;
use mywishlist\models\Liste as Liste;
use \mywishlist\models\Reservation as reservation;

class ControleurParticipationListe {

    /** instance container */
    private $container;

    /** constructeur de la classe ControleurParticipationListe **/
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /* fct 1 : Afficher une liste de souhait si elle est publique */
    public function afficherListeSouhaits(Request $rq, Response $rs, $args) {
        (isset($args['token'])) ? $token = $args['token'] : $token = '';
        try {
          $liste=Liste::query()->where('token','=',$token)
                  ->FirstOrFail();
                if ($liste->public == 0) {
              $rs->getBody()->write("Erreur : cette liste n'est pas publique");
              return $rs;
          } else {
            $items=Item::query()->where('liste_id','=',$liste->no)->get();
            $lsItem=[];
            foreach ($items as $it) {
                $lsItem[] = $it;
            }
            $vue=new VueParticipationListe($lsItem,$this->container);
            $rs->getBody()->write($vue->render(1));
          }
        } catch (ModelNotFoundException $m) {
            $rs->getBody()->write("Liste non trouvé !");
        }
        return $rs;
    }

    /* fct 2 : Afficher un item d'une liste de souhaits */
    public function afficherItemListeSouhaits(Request $rq, Response $rs, $args) {
        try {
            $item=Item::query()->where('id','=',$args['id'])
                    ->FirstOrFail();
            $vue=new VueParticipationListe([$item], $this->container);
            $rs->getBody()->write($vue->render(2));
            return $rs;
        } catch (ModelNotFoundException $m) {
            $rs->getBody()->write("item {$item->nom} non trouvé !");
        }
    }

    /* fct 3 : Reserver un item */
    public function reserverItem(Request $rq, Response $rs, $args)
    {
        try {

            $args = Item::query()->where('id', '=', $args['id'])->FirstOrFail();
            $reservation = Reservation::query()->where('id', '=', $args['id']);
            $rendu = '<!DOCTYPE html>
                 <html lang="fr">
                    <head>
                        <meta charset="UTF-8">
                        <title>ITEM</title>
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

            if (!$reservation->exists()) {
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
            }

            $rendu = $rendu . '</style>
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
                                <td>' . $args['id'] . '</td>
                                <td>' . $args['liste_id'] . '</td>
                                <td>' . $args['nom'] . '</td>
                                <td>' . $args['descr'] . '</td>
                                <td>' . $args['img'] . '</td>
                                <td>' . $args['url'] . '</td>
                                <td>' . $args['tarif'] . '</td>
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
            $rs->getBody()->Write($rendu);
            return $rs;
        } catch (Exception $exception) {
            $rs->getBody()->Write($exception);
            return $rs;
        }

    }

    /* fct 15 : Consulter les réservations d'une de ses listes avant échéance */
    public function consulterReservationListeAvantEcheance(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("Consultation des reservations de la liste avant l'échéance");
        return $rs;
    }

    /* fct 22 : Creer une cagnotte sur un item */
    public function creerCagnotteSurItem(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("creation d'une cagnotte sur un item");
        return $rs;
    }

    /* fct 23 : Participer a une cagnotte */
    public function participerGagnotte(Request $rq, Response $rs, $args) {
        $rs->getBody()->write("participation a la cagnotte d'un item");
        return $rs;
    }
}
