<?php /** @noinspection PhpUndefinedClassInspection */
declare(strict_types=1);

session_start();

require 'vendor/autoload.php';

use goldenppit\tests\ControlleurAccueil;
use goldenppit\tests\ControlleurCompte;
use goldenppit\tests\ControlleurEvenement;
use goldenppit\tests\ControlleurModifierCompte;
use Illuminate\Database\Capsule\Manager;
use Slim\App;
use Slim\Container;


$config = ['settings' => [
    'displayErrorDetails' => true,
]];

$db = new Manager();
$db->addConnection(parse_ini_file('config/config.ini'));
$db->setAsGlobal();
$db->bootEloquent();

$container = new Container($config);
$app = new App($container);

//Chemin Accueil
$app->get('/', ControlleurAccueil::class . ':connexionInscription')->setName('racine');
$app->get('/accueil', ControlleurAccueil::class . ':accueil')->setName('accueil');

//Chemin Compte
$app->get('/connexion', ControlleurCompte::class . ':connexion')->setName('formConnexion');
$app->post('/connexion', ControlleurCompte::class . ':testConnexion')->setName('enregisterConnexion');
$app->get('/deconnexion', ControlleurCompte::class . ':deconnexion')->setName('deconnexion');

$app->get('/inscription', ControlleurCompte::class . ':inscription')->setName('formInscription');
$app->post('/inscription', ControlleurCompte::class . ':enregistrerInscription')->setName('enregistrerInscription');
$app->get('/modifierCompte', ControlleurCompte::class . ':modifierCompte')->setName('formModifierCompte');
$app->post('/modifierCompte', ControlleurCompte::class . ':enregistrerModif')->setName('enregistrerModifierCompte');
$app->get('/motDePasseOublie', ControlleurCompte::class . ':motDePasseOublie')->setName('formMotDePasseOublie');
$app->post('/motDePasseOublie', ControlleurCompte::class . ':envoyerLien')->setName('envoyerLien');
$app->get('/reinitialiserMDP', ControlleurCompte::class . ':reinitialiserMDP')->setName('formResetMDP');
$app->post('/reinitialiserMDP', ControlleurCompte::class . ':resetMDP')->setName('resetMDP');
$app->get('/creationEvenement', ControlleurEvenement::class . ':creationEvenement')->setName('creationEvenement');
$app->post('/enregistrerEvenement', ControlleurEvenement::class . ':enregistrerEvenement')->setName('enregistrerEvenement');

try {
    $app->run();
} catch (Throwable $e) {
}