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

# affichage des erreurs systeme de Slim et connection database
$config = ['settings' => [
        'displayErrorDetails' => true,
        'dbconf' => '/conf/conf.ini',
]];

# creation instance App Slim
$container = new \Slim\Container($config);
$app = new \Slim\App($container);

# ======= ROUTES =======
# fct 21 : afficher les listes de souhaits qui sont en publiques
$app->get('/listes[/]', function (Request $rq, Response $rs, array $args) use ($container): Response {
    $ctrl = new controleurListe($container);
    return $ctrl->afficherListePublique($rq, $rs, $args);
}
);

# fct 6 : afficher le formulaire de création d'une liste
$app->get('/crealiste[/]', function (Request $rq, Response $rs, array $args) use ($container): Response {
    $ctrl = new controleurListe($container);
    return $ctrl->creerListe($rq, $rs, $args);
}
);


# ...

# declenchement du traitement de la requette HTTP courante par le framework Slim
$app->run();
