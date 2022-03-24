<?php

namespace goldenppit\controllers;

use Exception;
use goldenppit\models\besoin;
use goldenppit\models\evenement;
use goldenppit\models\participe;
use goldenppit\models\utilisateur;
use goldenppit\models\ville;
use goldenppit\views\VueAccueil;
use goldenppit\views\VueEvenement;
use goldenppit\views\VuePageEvenement;
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

    public function consulterEv(Request $rq, Response $rs, $args): Response
    {
        $nbEvent = Evenement::all()->count();
        $nomsEvent = Evenement::all();
        $vue = new VueEvenement([$nbEvent, $nomsEvent], $this->container);
        $rs->getBody()->write($vue->render(2)); //on ouvre la page d'un événement
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
        //avant l'exécution
        $vue = new VueAccueil([], $this->container);

        if ($this->createEvent($nom, $debut, $archiv, $supprAuto, $lieu, $desc)) { //si tout est bon, on affiche la page de l'évenement
            $id_ev = Evenement::where('e_titre', '=', $nom)->first()->e_id;
            $url_accueil = $this->container->router->pathFor("evenement", ['id_ev' => $id_ev]);

            return $rs->withRedirect($url_accueil);
        } else {
            $rs->getBody()->write($vue->render(2));
        }
        return $rs;
    }

    /**
     * POST
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

        if ($supprAuto != null) {
            $e->e_supp_date = $supprAuto;
        }

        if ($desc != null) {
            $e->e_desc = $desc;
        }

        $e->e_titre = $nom;
        $e->e_date = $debut;
        $e->e_archive = $archiv;
        $e->e_statut = ENCOURS;
        $e->e_proprio = $_SESSION['profile']['mail']; //La récup du mail dans la variable de session ne fonctionne pas.

        $e->e_ville = Ville::where('v_nom', '=', $lieu)->first()->v_id;

        $e->save();

        $participant = new participe();
        $participant->p_user = $e->e_proprio;
        $participant->p_event = $e->e_id;

        $participant->save();


        return true;
    }



    /**
     * GET
     * Affichage d'un evenement
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function evenement(Request $rq, Response $rs, $args): Response
    {
        $id_ev = $args['id_ev'];

        $nom_ev = Evenement::where('e_id', '=', $id_ev)->first()->e_titre;
        $date_deb = Evenement::where('e_id', '=', $id_ev)->first()->e_date;
        $date_fin = Evenement::where('e_id', '=', $id_ev)->first()->e_archive;
        $id_proprio = Evenement::where('e_id', '=', $id_ev)->first()->e_proprio;
        $proprio_nom = Utilisateur::where('u_mail', '=', $id_proprio)->first()->u_nom;
        $proprio_prenom = Utilisateur::where('u_mail', '=', $id_proprio)->first()->u_prenom;


        $id_ville = Evenement::where('e_id', '=', $id_ev)->first()->e_ville;
        $ville = Ville::where('v_id', "=", $id_ville)->first()->v_nom;
        $desc = Evenement::where('e_id', '=', $id_ev)->first()->e_desc;

        //Récupéerer les données des participants et des besoins
        $nb_participants = participe::where('p_event', '=', $id_ev)->get()->count();
        $participants = participe::where('p_event', '=', $id_ev)->get()->all();

        $nb_besoins = Besoin::where('b_event', '=', $id_ev)->get()->count();
        $besoins = Besoin::where('b_event', '=', $id_ev)->get()->all();
        //récupérer les champs ici et les mettre entre les crochets
        $vue = new VuePageEvenement([$id_ev, $nom_ev, $date_deb, $date_fin, $id_proprio, $proprio_nom, $proprio_prenom, $ville, $desc, $nb_participants, $participants], $this->container);
        $rs->getBody()->write($vue->render(0)); //on ouvre la page d'un événement
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
    public function supprimerEvenement(Request $rq, Response $rs, $args): Response
    {
        $event = Evenement::find($args['id_ev']);
        $event->delete();
        //TODO : remettre sur la page précedente
        $url_accueil = $this->container->router->pathFor('accueil');
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
        $user_email = $_SESSION['profile']['mail'];
        $participe = participe::find([$user_email, $event_id]);
        $participe->delete();

        $url_accueil = $this->container->router->pathFor('accueil');
        return $rs->withRedirect($url_accueil);
    }

    public function afficherCalendrier(Request $rq, Response $rs, $event_id): Response
    {

        $user_email = $_SESSION['profile']['mail'];
        $listeNoEvenement = participe::where('p_user', '=', "$user_email")->get();
        $listeEvenement = [];
        foreach ($listeNoEvenement as $num){
            array_push($listeEvenement, evenement::where('e_id', '=',"$num->p_event")->get());
        }
        $vue = new VueEvenement($listeEvenement, $this->container);

        $rs->getBody()->write($vue->render(3));
        return $rs;
    }

}