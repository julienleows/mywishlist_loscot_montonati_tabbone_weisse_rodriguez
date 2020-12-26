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
use \mywishlist\controls\ControleurDesListes as ControleurDesListes;
use \mywishlist\controls\ControleurDesComptes as ControleurDesCompteurs;
use \mywishlist\controls\ControleurDesItems as ControleurDesItems;
use \mywishlist\controls\ControleurDesMessages as ControleurDesMessages;
use \mywishlist\controls\ControleurDesImages as ControleurDesImages;
use \mywishlist\controls\ControleurParticipationListe as ControleurParticipationListe;

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
# fct 21 : afficher les listes de souhaits qui sont en publiques
$app->get('/listes[/]', function (Request $rq, Response $rs, array $args) use ($container): Response {
    $ctrl = new ControleurDesListes($container);
    return $ctrl->afficherListePublique($rq, $rs, $args);
}
);

# fct 14 : afficher une liste de souhait qui est en prive (par partage d'url)
$app->get("/listes/{token}[/]", function (Request $rq, Response $rs, array $args) use ($container): Response {
    $ctrl = new ControleurParticipationListe($container);
    // On affiche la liste de souhaits en fonction du token qui est donne
    return $ctrl->afficherListeSouhaits($rq, $rs, $args);
}
);

# fct 6 : afficher le formulaire de création d'une liste
$app->get('/crealiste[/]', function (Request $rq, Response $rs, array $args) use ($container): Response {
    $ctrl = new ControleurDesListes($container);
    return $ctrl->creerListe($rq, $rs, $args);
}
);

# ...

# declenchement du traitement de la requette HTTP courante par le framework Slim
$app->run();
