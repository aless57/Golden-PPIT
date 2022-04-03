<?php /** @noinspection PhpUndefinedClassInspection */
declare(strict_types=1);

session_start();

require 'vendor/autoload.php';

use goldenppit\controllers\ControlleurAccueil;
use goldenppit\controllers\ControlleurCompte;
use goldenppit\controllers\ControlleurEvenement;
use goldenppit\controllers\ControlleurModifierCompte;
use goldenppit\controllers\ControlleurNotification;
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
$app->get('/supprimerCompte', ControlleurCompte::class . ':supprimerCompte')->setName('supprimerCompte');

$app->get('/motDePasseOublie', ControlleurCompte::class . ':motDePasseOublie')->setName('formMotDePasseOublie');
$app->post('/motDePasseOublie', ControlleurCompte::class . ':sendMail')->setName('envoyerLien');
$app->get('/reinitialiserMDP', ControlleurCompte::class . ':reinitialiserMDP')->setName('formResetMDP');
$app->post('/reinitialiserMDP', ControlleurCompte::class . ':resetPW')->setName('resetMDP');

//Chemin evenement
$app->get('/creationEvenement', ControlleurEvenement::class . ':creationEvenement')->setName('creationEvenement');
$app->get('/evenement/{id_ev}', ControlleurEvenement::class . ':evenement')->setName('evenement');
$app->get('/quitterEvenement/{id_ev}', ControlleurEvenement::class . ':quitterEvenement')->setName('quitterEvenement');
$app->get('/consulterEvenement', ControlleurEvenement::class . ':consulterEv')->setName('afficherListe');
$app->post('/enregistrerEvenement', ControlleurEvenement::class . ':enregistrerEvenement')->setName('enregistrerEvenement');
$app->get('/exclureEvenement/{p_user}/{p_event}', ControlleurEvenement::class . ':exclureEvenement')->setName('exclureEvenement');
$app->get('/invitEvent/{id_event}/{expediteur}/{destinataire}', ControlleurEvenement::class . ':invitEvent')->setName('invitEvent');
$app->get('/evenement', ControlleurEvenement::class . ':redirection')->setName('redirection');
$app->get('/supprimerEvenement/{id_ev}', ControlleurEvenement::class . ':supprimerEvenement')->setName('supprimerEvenement');
$app->get('/inviterEvenement/{id_ev}', ControlleurEvenement::class . ':inviterEvenement')->setName('inviterEvenement');
$app->get('/calendrier', ControlleurEvenement::class . ':afficherCalendrier')->setName('calendar');

$app->get('/listeParticipant/{id_ev}', ControlleurEvenement::class . ':listeParticipant')->setName('listeParticipant');
$app->get('/modifierEvenement/{id_ev}', ControlleurEvenement::class . ':modifierEvenement')->setName('modifierEvenement');
$app->post('/enregistrerModifEvenement/{id_ev}', ControlleurEvenement::class . ':enregistrerModifEvenement')->setName('enregistrerModifEvenement');
$app->get('/besoins_evenements/{id_ev}', ControlleurEvenement::class . ':pageBesoins')->setName('lesBesoins');
$app->post('/enregistrerBesoin/{id_ev}', ControlleurEvenement::class . ':enregistrerBesoin')->setName('enregistrerBesoin');
$app->get('/ajout_besoin/{id_ev}', ControlleurEvenement::class . ':ajoutBesoin')->setName('ajout_besoin');
$app->post('/enregistrerAssocierBesoin/{id_ev}', ControlleurEvenement::class . ':enregistrerAssocierBesoin')->setName('enregistrerAssocierBesoin');
$app->get('/associerBesoin/{id_ev}', ControlleurEvenement::class . ':associerBesoin')->setName('associerBesoin');
$app->post('/enregistrerModifierBesoin/{id_ev}', ControlleurEvenement::class . ':enregistrerModifierBesoin')->setName('enregistrerModifierBesoin');
$app->get('/modifierBesoin/{id_ev}', ControlleurEvenement::class . ':modifierBesoin')->setName('modifierBesoin');
$app->get('/demanderRejoindre/{id_ev}/{participant}', ControlleurEvenement::class . ':demanderRejoindre')->setName('demanderRejoindre');
$app->post('/enregistrerSupprimerBesoin/{id_ev}', ControlleurEvenement::class . ':enregistrerSupprimerBesoin')->setName('enregistrerSupprimerBesoin');
$app->get('/supprimerBesoin/{id_ev}', ControlleurEvenement::class . ':supprimerBesoin')->setName('supprimerBesoin');
$app->get('/proposerUnBesoin/{id_ev}', ControlleurEvenement::class . ':proposerUnBesoin')->setName('proposerUnBesoin');
$app->post('/EnregistrerproposerUnBesoin/{id_ev}/{participant}', ControlleurEvenement::class . ':EnregistrerproposerUnBesoin')->setName('EnregistrerproposerUnBesoin');


$app->get('/nousContacter', ControlleurEvenement::class . ':nousContacter')->setName('nousContacter');


//Chemin notification
$app->get('/afficherNotifications', ControlleurNotification::class . ':afficherNotifications')->setName('afficherNotifications');
$app->get('/consulterNotification/{id_not}', ControlleurNotification::class . ':consulterNotification')->setName('consulterNotification');
$app->get('/supprimerNotification/{id_not}', ControlleurNotification::class . ':supprimerNotification')->setName('supprimerNotification');
$app->get('/rejoindreEvenement/{id_not}', ControlleurNotification::class . ':rejoindreEvenement')->setName('rejoindreEvenement');

try {
    $app->run();
} catch (Throwable $e) {
}