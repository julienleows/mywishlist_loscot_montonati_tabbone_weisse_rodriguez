<?php

/** Permet de verifier l'instalation de eloquante */
require_once __DIR__ . "/vendor/autoload.php";
use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\models\Item as Item;

print("eloquent est installé ! \n");

# permet de tester les requetes
$db = new DB();
$config = parse_ini_file(__DIR__.'/src/conf/conf.ini');
if ($config) $db->addConnection($config);

$db->setAsGlobal();
$db->bootEloquent();

$q1 = Item::all();
print ("Liste des items : " . "\n");
foreach ($q1 as $item){
    print($item->nom);
    print ("\n");
}