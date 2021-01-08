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
use mywishlist\models\item as Item;
use mywishlist\models\liste as Liste;
use mywishlist\models\urlliste as UrlListe;
use \mywishlist\models\Reservation as reservation;

class ControleurParticipationListe {

    /** instance container */
    private $container;

    /** constructeur de la classe ControleurParticipationListe **/
    public function __construct(\Slim\Container $container) {
        $this->container = $container;
    }

    /* fct 1 : Afficher les élements d'une liste de souhaits */
    public function afficherListeSouhaits(Request $rq, Response $rs, $args) {
        (isset($args['id'])) ? $id = $args['id'] : $id = '';
        (isset($args['token'])) ? $token = $args['token'] : $token = '';
        try {
            $item=Liste::query()->where('no','=',$id)
                    ->FirstOrFail();
            $vue=new VueParticipationListe([$item]);
            $rs->getBody()->write($vue->render(1));
        } catch (ModelNotFoundException $e){
          // c'est tres moche, mais pour l'instant ça marche
          // a modifier si possible
          try {
            $rest = substr($token, 0, 6);
            if ($rest == "secure") {
                $rs->getBody()->write("Erreur : cette liste n'est pas publique");
                return $rs;
            } else
            $item=Liste::query()->where('token','=',$token)
                    ->FirstOrFail();
            $vue=new VueParticipationListe([$item]);
            $rs->getBody()->write($vue->render(1));
          } catch (ModelNotFoundException $m) {
              $rs->getBody()->write("item {$item->nom} non trouvé !");
          }
        }
        return $rs;
    }

    /* fct 2 : Afficher un item d'une liste de souhaits */
    public function afficherItemListeSouhaits(Request $rq, Response $rs, $args) {
        try {
            $item=Item::query()->where('id','=',$args['id'])
                    ->FirstOrFail();
            $vue=new VueParticipationListe([$item]);
            $rs->getBody()->write($vue->render(2));
            return $rs;
        } catch (ModelNotFoundException $m) {
            $rs->getBody()->write("item {$item->nom} non trouvé !");
        }
    }

    /* fct 3 : Reserver un item */
    public function reserverItem(Request $rq, Response $rs, $args)
    {
        /*
         * VERSION 1
         */
        try {
            $args = Item::query()->where('id', '=', $args['id'])->FirstOrFail();
            $reservation = Reservation::query()->where('id', '=', $args['id']);
            $id = $args['id'];
            $liste_id = $args['liste_id'];
            $nom = $args['nom'];
            $descr = $args['descr'];
            $img = $args['img'];
            $url = $args['url'];
            $tarif = $args['tarif'];
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
                                <td>' . $id . '</td>
                                <td>' . $liste_id . '</td>
                                <td>' . $nom . '</td>
                                <td>' . $descr . '</td>
                                <td>' . $img . '</td>
                                <td>' . $url . '</td>
                                <td>' . $tarif . '</td>
                            </tr>
                        </table>
                    </div>';


            $valueCookie = '';
            if(isset($_COOKIE['nomReservation'])){
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
            }

            if (isset($_GET['nom'])) {
                if (isset($_GET['message'])) {
                    $rendu = $rendu . '<br></br><p> La table fait partie de vos réservations </p>';
                    setcookie('nomReservation', $_GET['nom'],time()+ 60*60*60);
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

    /* fct 14 : partager une liste */
    public function partagerListe(Request $rq, Response $rs, $args) {
      $liste_id = $args['liste_id'];
      try{
          $ls=Liste::query()->where('no','=',$liste_id)
              ->FirstOrFail();
          $newtoken = hash('md5', openssl_random_pseudo_bytes(255) . "secure" . $ls->no); // hash('md5',"(255_bytes_random)secure1")
          $ls->token = $newtoken; // on encrypte le token, et on le place dans la bdd
          $ls->save();
          $rs->getBody()->write("nouvelle url : " . "nomsiteweb/listes/" . $newtoken); // on affiche le lien
      } catch (Exception $exception){
          $rs = getBody()->write($exception);
      }
      return $rs;
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
