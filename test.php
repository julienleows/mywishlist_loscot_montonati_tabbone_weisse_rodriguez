<?php

/** Permet de verifier l'instalation de eloquante */
require_once __DIR__ . "/../vendor/autoload.php";
use Illuminate\Database\Capsule\Manager as DB;
print("eloquent est installé ! \n");

# permet de tester les requetes
$db = new DB();
$config = parse_ini_file(__DIR__.'/.../conf/db.conf.ini');
if ($config) $db->addConnection($config);

$db->setAsGlobal();
$db->bootEloquent();

