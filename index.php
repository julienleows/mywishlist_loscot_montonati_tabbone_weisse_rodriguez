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
use \mywishlist\controls\GestionDesListes;
use \mywishlist\controls\GestionDesComptes;
use \mywishlist\controls\GestionDesItems;
use \mywishlist\controls\GestionDesMessages;

# affichage des erreurs systeme de Slim
$config = ['settings' => ['displayErrorDetails' => true,]];

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
    $ctrl = new GestionDesListes($container);
    return $ctrl->afficherListePublique($rq, $rs, $args);
}
);

# affichage de la liste des items d'une liste de souhaits
$app->get('/items[/]', function (Request $rq, Response $rs, array $args): Response {
    $rs->getBody()->Write("<h1>affichage de la liste des items d'une liste de souhaits</h1>");
    return $rs;
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
