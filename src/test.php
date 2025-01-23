<?php
require_once __DIR__ . '/vendor/autoload.php';

use iutnc\hellokant\Connection\ConnectionFactory;
use iutnc\hellokant\model\Article;
use iutnc\hellokant\model\Categorie;

$conf = parse_ini_file('conf/db.conf.ini');


try {
    ConnectionFactory::makeConnection($conf);
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

try {
    $myPdo = ConnectionFactory::getConnection();
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

$article = new Article();
$article->nom = 'My first article';
$article->descr = 'This is the content of my first article';
$article->tarif = 10;
$article->id_categ=1;
$article->save();

echo "First Article saved !!!\n";
echo "$article->nom\n";
echo "$article->descr\n";
echo "$article->tarif\n";

$articleTwo = new Article();
$articleTwo->nom = "My second article";
$articleTwo->descr = "This is the content of my second article";
$articleTwo->tarif = 20;
$articleTwo->id_categ=2;
$articleTwo->save();


echo "Second Article saved\n";
echo "$articleTwo->nom\n";
echo "$articleTwo->descr\n";
echo "$articleTwo->tarif\n";

$articleTwo->delete();

echo "Second Article deleted !\n";
