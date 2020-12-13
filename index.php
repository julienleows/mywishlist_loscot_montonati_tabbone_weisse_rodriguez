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

# creation instance App Slim
$app = new Slim\App();

# ======= ROUTES =======
# affichage de la liste des listes de souhaits
$app->get('/souhaits[/]', function(Request $rq, Response $rs, array $args): Response {
    $rs->getBody()->Write("<h1>affichage de la liste des listes de souhaits</h1>");
    return $rs;}
);

# affichage de la liste des items d'une liste de souhaits
$app->get('/items[/]', function(Request $rq, Response $rs, array $args): Response {
    $rs->getBody()->Write("<h1>affichage de la liste des items d'une liste de souhaits</h1>");
    return $rs;}
);

# affichage d'un item désignée par son ID
$app->get('/items/{id}[/]', function(Request $rq, Response $rs, array $args): Response {
    $id = $args['id'];
    $rs->getBody()->Write("<h1>affichage d'un item désignée par son ID : $id</h1>");
    return $rs;}
);

# declenchement le traitement de la requette HTTP courante par le framework Slim
$app->run();
