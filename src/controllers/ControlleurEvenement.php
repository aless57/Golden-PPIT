<?php

namespace goldenppit\controllers;

use Exception;
use goldenppit\models\evenement;
use goldenppit\models\participant;
use goldenppit\views\VueAccueil;
use goldenppit\views\VueEvenement;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

define("ENCOURS", "En cours");

class ControlleurEvenement
{
    private $container;
    private $today;

    /**
     * ControlleurEvenement constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * GET
     * Affichage du formulaire pour création d'événement
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function creationEvenement(Request $rq, Response $rs, $args): Response
    {
        $vue = new VueEvenement([], $this->container);
        $rs->getBody()->write($vue->render(0));
        return $rs;
    }

    /**
     * POST
     * Enregistrement des informations du nouveau compte dans la base de données
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function enregistrerEvenement(Request $rq, Response $rs, $args): Response
    {
        $post = $rq->getParsedBody();

        $nom = filter_var($post['nom'], FILTER_SANITIZE_STRING);
        $debut = filter_var($post['deb'], FILTER_SANITIZE_STRING);
        $archiv = filter_var($post['archiv'], FILTER_SANITIZE_STRING);
        $supprAuto = filter_var($post['supprauto'], FILTER_SANITIZE_STRING);
        $lieu = filter_var($post['lieu'], FILTER_SANITIZE_STRING);
        $desc = filter_var($post['desc'], FILTER_SANITIZE_STRING);

        //TODO : remplacer avec un appel vers la page de consultation d'événement
        $vue = new VueAccueil([], $this->container);

        if ($this->createEvent($nom, $debut, $archiv, $supprAuto, $lieu, $desc)) {
            $url_accueil = $this->container->router->pathFor("accueil");
            return $rs->withRedirect($url_accueil);
        } else {
            $rs->getBody()->write($vue->render(2));
        }
        return $rs;
    }

    /**
     * Fonction de création de event
     * @param $nom
     * @param $debut
     * @param $archiv
     * @param $supprAuto
     * @param $lieu
     * @param $desc
     * @throws Exception
     */
    public static function createEvent($nom, $debut, $archiv, $supprAuto, $lieu, $desc)
    {
        $e = new Evenement();
        $e->e_titre = $nom;
        $e->e_date = $debut;
        $e->e_archive = $archiv;
        $e->e_supp_date = $supprAuto;
        $e->e_desc = $desc;
        $e->e_statut = ENCOURS;
        $e->e_proprio = "moi@gmail.fr";
        //TODO $e->e_proprio = $_SESSION['profile']['mail']; La récup du mail dans la variable de session ne fonctionne pas.

        // TODO : A modif
        //$e->e_ville = Ville::where('v_nom','LIKE',$ville)->first()->v_id;
        $e->e_ville = $lieu;

        $e->save();
        return true;
    }

    public function evenement(Request $rq, Response $rs, $args): Response{
        $vue = new VueEvenement( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render(1)) ; //on ouvre la page d'un événement
        return $rs;
    }

    /**
     * POST
     * Suppression de l'évenement
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @param Id de l'event à supprimer $event_id
     * @return Response
     */
    public function supprimerEvenement(Request $rq, Response $rs, $args, $event_id): Response
    {
        $event = Evenement::find($event_id);
        $event->delete();
        //TODO : remettre sur la page précedente
        $url_accueil = $this->container->router->pathFor('racine');
        return $rs->withRedirect($url_accueil);
    }


    /**
     * POST
     * Utilisateur quitte un evenement
     * @param Request $rq
     * @param Response $rs
     * @param $event_id l'ID de l'utilisateur
     * @return Response
     */
    public function quitterEvenement(Request $rq, Response $rs, $event_id): Response
    {
        $post = $rq->getParsedBody(); #method to parse the HTTP request body into a native PHP format

        #retire participation et besoins
        $user_email = $_SESSION['profile']['mail'];
        $participe = participant::find([$user_email, $event_id]);
        $participe->delete();

        //TODO : remettre sur la page précedente
        $url_accueil = $this->container->router->pathFor('racine');
        return $rs->withRedirect($url_accueil);
    }
}