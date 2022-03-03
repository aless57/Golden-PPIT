<?php

namespace goldenppit\controllers;

use goldenppit\models\evenement;
use goldenppit\views\VueAccueil;
use goldenppit\views\VueEvenement;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

define("ENCOURS","En cours");

class ControlleurEvenement
{
    private $container;
    private $today;

    /**
     * ControlleurEvenement constructor.
     * @param $container
     */
    public function __construct($container) {
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
    public function creationEvenement(Request $rq, Response $rs, $args) : Response {
        $vue = new VueEvenement( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render(0)) ;
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
    public function enregistrerEvenement(Request $rq, Response $rs, $args) : Response {
        $post = $rq->getParsedBody();

        $nom = filter_var($post['nom'], FILTER_SANITIZE_STRING);
        $debut = filter_var($post['deb'], FILTER_SANITIZE_STRING);
        $archiv = filter_var($post['archiv'] , FILTER_SANITIZE_STRING) ;
        $supprAuto = filter_var($post['supprAuto'] , FILTER_SANITIZE_STRING) ;
        $lieu = filter_var($post['lieu'] , FILTER_SANITIZE_STRING) ;
        $desc = filter_var($post['desc'] , FILTER_SANITIZE_STRING) ;

        //TODO : remplacer avec un appel vers la page de consultation d'événement
        $vue = new VueAccueil([], $this->container ) ;

        if ($this->createEvent($nom, $debut, $archiv, $supprAuto, $lieu, $desc)){
            $url_accueil = $this->container->router->pathFor("accueil");
            return $rs->withRedirect($url_accueil);
        }else{
            $rs->getBody()->write( $vue->render(2));
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
     * @throws \Exception
     */
    public static function createEvent($nom, $debut, $archiv, $supprAuto, $lieu, $desc) {
        $e = new Evenement();
        $e->e_titre = $nom ;
        $e->e_date = $debut ;
        $e->e_archive = $archiv ;
        $e->e_supp_date = $supprAuto ;
        $e->e_desc = $desc ;
        $e->e_statut = ENCOURS ;
        $e->e_proprio = $_SESSION['profile']['mail'];

        // TODO : A modif
        //$e->e_ville = Ville::where('v_nom','LIKE',$ville)->first()->v_id;
        $e->e_ville = $lieu ;

        $e->save();
        return true;
    }
}