<?php
/**
 * Fichier: index.php
 * description: ficchier index du projet wishlist
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONTONATI
 */

# autoload
require_once __DIR__ . '/vendor/autoload.php';

# imports
use mywishlist\models\Liste as Liste;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\controls\ControleurDesListes as ControleurDesListes;
use \mywishlist\controls\ControleurDesComptes as ControleurDesCompteurs;
use \mywishlist\controls\ControleurDesItems as ControleurDesItems;
use \mywishlist\controls\ControleurDesMessages as ControleurDesMessages;
use \mywishlist\controls\ControleurDesImages as ControleurDesImages;
use \mywishlist\controls\ControleurParticipationListe as ControleurParticipationListe;
use \mywishlist\models\Reservation as reservation;
use \mywishlist\controls\ControleurAffichageDesPages;


# affichage des erreurs systeme de Slim
$config = ['settings' => ['displayErrorDetails' => true,'dbconf' => '/conf/conf.ini']];

# connection base de donnees MySQL
$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

# creation instance App Slim
$container = new \Slim\Container($config);
$app = new \Slim\App($container);



# ======= ROUTES =======
# route racine
$app->get('/', function (Request $rq, Response $rs, array $args) use ($container): Response {
    $ctrl = new ControleurAffichageDesPages($container);
    return $ctrl->accueil($rq, $rs, $args);
}
)->setName('racine');

# fct 21 : afficher les listes de souhaits qui sont en publiques
$app->get('/listes[/]', function (Request $rq, Response $rs, array $args) use ($container): Response {
    $ctrl = new ControleurDesListes($container);
    return $ctrl->afficherListePublique($rq, $rs, $args);
}
)->setName('listes');

# fct 14 : afficher une liste de souhait qui est en prive (par partage d'url)
$app->get("/liste/{token}[/]", function (Request $rq, Response $rs, array $args) use ($container): Response {
    $ctrl = new ControleurParticipationListe($container);
    // On affiche la liste de souhaits en fonction du token qui est donne
    // $ctrl->partagerListe($rq,$rs,['liste_id' => 1]);
    return $ctrl->afficherListeSouhaits($rq, $rs, $args);
}
)->setName('liste');

# fct 6 : afficher le formulaire de création d'une liste
$app->get('/crealiste[/]', function (Request $rq, Response $rs, array $args) use ($container): Response {
    $ctrl = new ControleurDesListes($container);
    return $ctrl->creerListe($rq, $rs, $args);
}
)->setName('crealiste');


$app->post('/crealiste[/]', function (Request $rq, Response $rs, array $args) use ($container): Response {
    $ctrl = new ControleurDesListes($container);
    return $ctrl->creerListe($rq, $rs, $_POST);
}
)->setName('creaListe');

# fct 3 : Reserver un item
$app->get('/reserver/{id}[/]', function (Request $rq, Response $rs, array $args) use ($db, $container): Response {


    $db::connection()->statement("CREATE TABLE IF NOT EXISTS reservation ( 
    nom varchar(200) NOT NULL, 
    id int(11), 
    message varchar(200), 
    PRIMARY KEY (nom,id), 
    FOREIGN KEY (id) REFERENCES item(id) );");


    if (isset($_GET['nom'])) {
        if (isset($_GET['message'])) {
            $reservation = Reservation::query()->where([['nom','=',$_GET['nom']],['id','=',$args['id']]]);
            if(!$reservation->exists()){
                $db::connection()->insert("INSERT INTO reservation VALUES('" . $_GET['nom'] . "','" . $args['id'] . "','" . $_GET['message'] . "')");
            }
        }
    }

    $ctrl = new ControleurParticipationListe($container);
    return $ctrl->reserverItem($rq, $rs, $args);
}
)->setName('reserver');

# fct 20 : Ajouter une liste en publique
$app->get('/rendrepubliqueliste/{token}[/]', function (Request $rq, Response $rs, array $args) use ($db, $container): Response {

    $ctrl = new ControleurDesListes($container);
    return $ctrl->rendreListePublique($rq, $rs, $args);
}
);

#fct 20.2 : Supprimer une liste de public
$app->get('/SuppressionPubliqueListe/{id}[/]', function (Request $rq, Response $rs, array $args) use ($db, $container): Response {
    $ctrl = new ControleurDesListes($container);
    return $ctrl->suppressionListePublique($rq, $rs, $args);
}
);

#fct 8 : Ajout d'un item à une liste
$app->get('/ajoutitem/{token}[/]', function (Request $rq, Response $rs, array $args) use ($db, $container): Response {
    $ctrl = new ControleurDesItems($container);
    return $ctrl->creerItem($rq, $rs, $args, $args['token']);
})->setName("creaitem");

#fct 8 : Ajout d'un item à une liste
$app->post('/ajoutitem/{token}[/]', function (Request $rq, Response $rs, array $args) use ($db, $container): Response {
    $ctrl = new ControleurDesItems($container);
    return $ctrl->creerItem($rq, $rs, $_POST, $args['token']);
})->setName("creaItem");

#fct 8 : GET Modifier d'un item à une liste
$app->get('/modifitem/{idListe}/{idItem}', function (Request $rq, Response $rs, array $args) use ($db, $container): Response {
    $ctrl = new ControleurDesItems($container);
    return $ctrl->modifierItem($rq, $rs, $args, $args['idListe'], $args['idItem']);
})->setName("modifitem");

#fct 8 : POST Modifier d'un item à une liste
$app->post('/modifitem/{idListe}/{idItem}', function (Request $rq, Response $rs, array $args) use ($db, $container): Response {
    $ctrl = new ControleurDesItems($container);
    return $ctrl->modifierItem($rq, $rs, $_POST, $args['idListe'], $args['idItem']);
})->setName("modifitem");

#fct 8 : Ajout d'un item à une liste
$app->get('/suppitem/{idListe}/{idItem}', function (Request $rq, Response $rs, array $args) use ($db, $container): Response {
    $ctrl = new ControleurDesItems($container);
    return $ctrl->supprimerItem($rq, $rs, $args, $args['idListe'], $args['idItem']);
})->setName("suppitem");

#TEST ROUTE


# ...

# declenchement du traitement de la requette HTTP courante par le framework Slim
$app->run();
