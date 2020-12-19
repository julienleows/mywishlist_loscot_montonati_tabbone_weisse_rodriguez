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
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \mywishlist\controls\ControleurDesListes as controleurListe;
use \mywishlist\controls\ControleurDesComptes as controleurCompteur;
use \mywishlist\controls\ControleurDesItems as controleurItem;
use \mywishlist\controls\ControleurDesMessages as controleurMessage;
use \mywishlist\controls\ControleurDesImages as controleurImage;
use \mywishlist\controls\ControleurParticipationListe as controleurParticipation;

# affichage des erreurs systeme de Slim
$config = ['settings' => ['displayErrorDetails' => true]];

# connection base de donnees MySQL
$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

# creation instance App Slim
$container = new \Slim\Container($config);
$app = new \Slim\App($container);

# ======= ROUTES =======
# affichage de la liste des listes de souhaits
$app->get('/listes[/]', function (Request $rq, Response $rs, array $args) use ($container): Response {
    $ctrl = new ControleurDesListes($container);
    return $ctrl->afficherListePublique($rq, $rs, $args);
}
);

# affichage de la liste des items d'une liste de souhaits
$app->get('/items/{id}[/]', function (Request $rq, Response $rs, array $args): Response {
    $c= new controleurParticipation($this);
    return $c->afficherListeSouhaits($rq,$rs,$args);
}
);

# affichage d'un item désignée par son ID
$app->get('/item/{id}[/]', function (Request $rq, Response $rs, array $args): Response {
    $id = $args['id'];
    $rs->getBody()->Write("<h1>affichage d'un item désignée par son ID : $id</h1>");
    return $rs;
}
);

# declenchement du traitement de la requette HTTP courante par le framework Slim
$app->run();
