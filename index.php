<?php
/**
 * Fichier: index.php
 * description: ficchier index du projet wishlist
 * @author: Julien WEISSE
 * @author: Lucas TABBONE
 * @author: Clement LOSCOT
 * @author: Godefroy MONATONI
 */

# autoload
require_once __DIR__ . '/vendor/autoload.php';

# imports
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

# creation instance App Slim
$app = new \Slim\App();

# routes
$app->get('/hell/{name}[/]', function(Request $rq, Response $rs, array $args): Response {
    $name = $args['name'];
    $rs->getBody()->Write("<h1>Hello World, $name</h1>");
    return $rs;
});
