<?php

namespace goldenppit\controllers;

use goldenppit\models\besoin;
use goldenppit\models\evenement;
use goldenppit\models\participe;
use goldenppit\models\participe_besoin;
use goldenppit\models\utilisateur;
use goldenppit\models\ville;
use goldenppit\models\souhaite;
use goldenppit\models\notification;
use goldenppit\views\VueAccueil;
use goldenppit\views\VueEvenement;
use goldenppit\views\VuePageEvenement;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

define("ENCOURS", "En cours");


class ControlleurEvenement
{
    private $container;

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
        $villesEvent = Ville::all();
        $vue = new VueEvenement([$nbEvent, $nomsEvent, $villesEvent], $this->container);
        $rs->getBody()->write($vue->render(2)); //on ouvre la page d'un événement
        return $rs;
    }


    public static function createBesoins($nom, $desc, $nombre, $event): bool
    {

        $b = new Besoin();

        if ($desc != null) {
            $b->b_desc = $desc;
        }

        $b->b_objet = $nom;
        $b->b_nombre = $nombre;
        $b->b_event = $event;

        $b->save();

        return true;
    }

    public function enregistrerBesoin(Request $rq, Response $rs, $args): Response
    {
        $post = $rq->getParsedBody();
        $get = $args['id_ev'];

        $nom = filter_var($post['nom'], FILTER_SANITIZE_STRING);
        $nb = filter_var($post['nb'], FILTER_SANITIZE_STRING);
        $desc = filter_var($post['desc'], FILTER_SANITIZE_STRING);

        //avant l'exécution

        $this->createBesoins($nom, $desc, $nb, $get);//si tout est bon, on affiche la page de l'évenement
        $url_accueil = $this->container->router->pathFor("evenement", ['id_ev' => $args['id_ev']]);

        return $rs->withRedirect($url_accueil);

    }

    public function enregistrerAssocierBesoin(Request $rq, Response $rs, $args): Response
    {
        $post = $rq->getParsedBody();

        $besoin = filter_var($post['besoin_sele'], FILTER_SANITIZE_STRING);
        $id_besoin = Besoin::where('b_objet', '=', $besoin)->first()->b_id;

        $participant = filter_var($post['participe_sele'], FILTER_SANITIZE_STRING);
        //avant l'exécution

        $participant_besoin = new participe_besoin();
        $participant_besoin->pb_user = $participant;
        $participant_besoin->pb_besoin = $id_besoin;
        $participant_besoin->save();
        $url_accueil = $this->container->router->pathFor("evenement", ['id_ev' => $args['id_ev']]);

        return $rs->withRedirect($url_accueil);

    }


    public function enregistrerModifierBesoin(Request $rq, Response $rs, $args): Response
    {
        $post = $rq->getParsedBody();

        $besoin = filter_var($post['besoin_sele'], FILTER_SANITIZE_STRING);
        $nom = filter_var($post['nom'], FILTER_SANITIZE_STRING);
        $nombre = filter_var($post['nb'], FILTER_SANITIZE_STRING);
        $desc = filter_var($post['desc'], FILTER_SANITIZE_STRING);
        $id_besoin = Besoin::where('b_objet', '=', $besoin)->first()->b_id;

        $this->modifBesoin($id_besoin, $nom, $desc, $nombre);
        $url_accueil = $this->container->router->pathFor("evenement", ['id_ev' => $args['id_ev']]);

        return $rs->withRedirect($url_accueil);

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

    public function ajoutBesoin(Request $rq, Response $rs, $args): Response
    {
        $id_ev = $args['id_ev'];
        $vue = new VuePageEvenement([$id_ev], $this->container);
        $rs->getBody()->write($vue->render(3));

        return $rs;

    }

    public function modifBesoin($id_besoin, $nom, $desc, $nombre): bool
    {
        $b = Besoin::where('b_id', '=', $id_besoin)->first();


        if ($desc != null) {
            $b->b_desc = $desc;
        }

        $b->b_objet = $nom;
        $b->b_nombre = $nombre;

        $b->save();

        return true;

    }

    public function modifierBesoin(Request $rq, Response $rs, $args): Response
    {
        $id_ev = $args['id_ev'];
        $besoins = Besoin::where('b_event', '=', $id_ev)->get()->all();
        $nb_besoins = Besoin::where('b_event', '=', $id_ev)->get()->count();
        $vue = new VuePageEvenement([$id_ev, $besoins, $nb_besoins], $this->container);
        $rs->getBody()->write($vue->render(6));

        return $rs;

    }


    public function associerBesoin(Request $rq, Response $rs, $args): Response
    {
        $id_ev = $args['id_ev'];
        $participants = participe::where('p_event', '=', $id_ev)->get()->all();
        $nb_participants = participe::where('p_event', '=', $id_ev)->get()->count();
        $vue = new VuePageEvenement([$id_ev, $participants, $nb_participants], $this->container);
        $rs->getBody()->write($vue->render(7));

        return $rs;

    }


    public function supprimerBesoin(Request $rq, Response $rs, $args): Response
    {
        $id_ev = $args['id_ev'];


        //Récupéerer les données des participants et des besoins
        $besoins = Besoin::where('b_event', '=', $id_ev)->get();
        $nbBesoins = $besoins->count();
        $vue = new VuePageEvenement([$id_ev, $besoins, $nbBesoins], $this->container);
        $rs->getBody()->write($vue->render(5));

        return $rs;

    }

    public function enregistrerSupprimerBesoin(Request $rq, Response $rs, $args): Response
    {
        $post = $rq->getParsedBody();

        $besoin = filter_var($post['nomB'], FILTER_SANITIZE_STRING);
        $id_besoin = Besoin::where('b_objet', '=', $besoin)->first();

        //avant l'exécution

        $id_besoin->delete();
        $url_accueil = $this->container->router->pathFor("evenement", ['id_ev' => $args['id_ev']]);

        return $rs->withRedirect($url_accueil);

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
     * @return bool
     */
    public static function createEvent($nom, $debut, $archiv, $supprAuto, $lieu, $desc): bool
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
     * POST
     * Proposition d'un nouveau besoin
     * @param Request $rq
     * @param Response $rs
     * @param $args [id_ev, participant]
     * @return Response
     */
    public function proposerUnBesoin(Request $rq, Response $rs, $args): Response
    {
        $vue = new VuePageEvenement([$args['id_ev']], $this->container);
        $rs->getBody()->write($vue->render(9));
        return $rs;
    }


    /**
     * POST
     * Enregistre la proposition d'un nouveau besoin
     * @param Request $rq
     * @param Response $rs
     * @param $args [id_ev, participant]
     * @return Response  
     *
     */
    public function EnregistrerproposerUnBesoin(Request $rq, Response $rs, $args): Response
    {
        
        $id_ev = $args['id_ev'];
        $id_proprio = Evenement::where('e_id', '=', $id_ev)->first()->e_proprio;
        $user_on_session_email = $_SESSION['profile']['mail'];


        $notification = new Notification();
        $notification->n_objet = "Suggestion d'un besoin";
        $notification->n_contenu = "L'utilisateur " . $args['participant'] . " propose l'ajout d' un nouveau besoin pour l'évènement " . $args['id_ev'] .
                                    "La description du besoin : ";
        $notification->n_statut = "nonLue";
        $notification->n_type = "suggestion besoin";
        $notification->n_expediteur = $user_on_session_email;

        $notification->n_destinataire = $id_proprio;
        $notification->n_event = $id_ev;
        $notification->save();

        $url_accueil = $this->container->router->pathFor("evenement", ['id_ev' => $id_ev]);
        return $rs->withRedirect($url_accueil);
                
    }

    /**
     * POST
     * Modification de l'evenement dans la BDD
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function enregistrerModifEvenement(Request $rq, Response $rs, $args): Response
    {
        $id_ev = $args['id_ev'];

        $post = $rq->getParsedBody();

        $nom = filter_var($post['nom'], FILTER_SANITIZE_STRING);
        $debut = filter_var($post['deb'], FILTER_SANITIZE_STRING);
        $archiv = filter_var($post['archiv'], FILTER_SANITIZE_STRING);
        $supprAuto = filter_var($post['supprauto'], FILTER_SANITIZE_STRING);
        $lieu = filter_var($post['lieu'], FILTER_SANITIZE_STRING);
        $desc = filter_var($post['desc'], FILTER_SANITIZE_STRING);

        $vue = new VueAccueil([], $this->container);

        if ($this->modifEvent($id_ev, $nom, $debut, $archiv, $supprAuto, $lieu, $desc)) { //si tout est bon, on affiche la page de l'évenement
            $url_accueil = $this->container->router->pathFor("evenement", ['id_ev' => $id_ev]);
            return $rs->withRedirect($url_accueil);
        } else {
            $rs->getBody()->write($vue->render(2));
        }
        return $rs;
    }

    public function modifEvent($id_ev, $nom, $debut, $archiv, $supprAuto, $lieu, $desc): bool
    {
        $e = Evenement::where('e_id', '=', $id_ev)->first();

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

        $e->e_ville = Ville::where('v_nom', '=', $lieu)->first()->v_id;

        $e->save();

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
        //récupérer les champs ici et les mettre entre les crochets
        $vue = new VuePageEvenement([$id_ev, $nom_ev, $date_deb, $date_fin, $id_proprio, $proprio_nom, $proprio_prenom, $ville, $desc, $nb_participants, $participants], $this->container);
        $rs->getBody()->write($vue->render(0)); //on ouvre la page d'un événement
        return $rs;
    }

    public function pageBesoins(Request $rq, Response $rs, $args): Response
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

        $vue = new VuePageEvenement([$id_ev, $nom_ev, $date_deb, $date_fin, $id_proprio, $proprio_nom, $proprio_prenom, $ville, $desc, $nb_participants, $participants, $nb_besoins, $besoins], $this->container);
        $rs->getBody()->write($vue->render(2));
        return $rs;
    }


    /**
     * POST
     * Suppression de l'évenement
     * @param Request $rq
     * @param Response $rs
     * @param $args
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

    public function inviterEvenement(Request $rq, Response $rs, $args): Response
    {
        $vue = new VuePageEvenement([$args['id_ev']], $this->container);
        $rs->getBody()->write($vue->render(8));
        return $rs;
    }


    /**
     * POST
     * Utilisateur exclue d'un evenement
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function exclureEvenement(Request $rq, Response $rs, $args): Response
    {
        $participe = participe::where([['p_user', '=', $args['p_user']], ['p_event', '=', $args['p_event']]]);
        $participe->delete();
        $url_accueil = $this->container->router->pathFor("listeParticipant", ['id_ev' => $args['p_event']]);
        return $rs->withRedirect($url_accueil);
    }

    public function invitEvent(Request $rq, Response $rs, $args): Response
    {
        $nom_event = evenement::where('e_id', '=', $args['id_event'])->first()->e_titre;
        $n = new Notification();
        $n->n_objet = "Invitation à un évènement";
        $n->n_contenu = "Vous avez reçu une invitation pour l'évènement : " . $nom_event;
        $n->n_statut = "non lue";
        $n->n_type = "invitation";
        $n->n_expediteur = $args['expediteur'];
        $n->n_destinataire = $args['destinataire'];
        $n->n_event = $args['id_event'];
        $n->save();
        $url_accueil = $this->container->router->pathFor("accueil");
        return $rs->withRedirect($url_accueil);
    }

    public function afficherCalendrier(Request $rq, Response $rs, $args): Response
    {

        $user_email = $_SESSION['profile']['mail'];
        $listeNoEvenement = participe::where('p_user', '=', "$user_email")->get();
        $listeEvenement = [];
        foreach ($listeNoEvenement as $num) {
            $listeEvenement[] = evenement::where('e_id', '=', "$num->p_event")->get();
        }
        $vue = new VueEvenement($listeEvenement, $this->container);

        $rs->getBody()->write($vue->render(3));
        return $rs;
    }

    /**
     * GET
     * Affichage du formulaire pour création d'événement
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function modifierEvenement(Request $rq, Response $rs, $args): Response
    {
        $id_ev = $args['id_ev'];

        $nom_ev = Evenement::where('e_id', '=', $id_ev)->first()->e_titre;
        $date_deb = Evenement::where('e_id', '=', $id_ev)->first()->e_date;

        $date_supp = Evenement::where('e_id', '=', $id_ev)->first()->e_supp_date;
        $date_arch = Evenement::where('e_id', '=', $id_ev)->first()->e_archive;

        $id_ville = Evenement::where('e_id', '=', $id_ev)->first()->e_ville;
        $ville = Ville::where('v_id', "=", $id_ville)->first()->v_nom;
        $desc = Evenement::where('e_id', '=', $id_ev)->first()->e_desc;
        $vue = new VuePageEvenement([$id_ev, $nom_ev, $date_deb, $date_supp, $date_arch, $ville, $desc], $this->container);
        $rs->getBody()->write($vue->render(4));
        return $rs;
    }

    public function listeParticipant(Request $rq, Response $rs, $args): Response
    {
        $event = participe::where("p_event", "=", $args['id_ev'])->get();
        $vue = new VuePageEvenement($event, $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }



    /**
     * GET
     * Utilisateur quitte un evenement
     * @param Request $rq
     * @param Response $rs
     * @param $args [id_ev]
     * @return Response
     */
    public function quitterEvenement(Request $rq, Response $rs, $args): Response
    {
        $user_email = $_SESSION['profile']['mail'];
        echo $user_email;
        $id_ev = $args['id_ev'];
        echo $id_ev;

        $participe = participe::where([['p_user', '=', $user_email], ['p_event', '=', $id_ev ]]);
        $participe->delete();
        $url_accueil = $this->container->router->pathFor("evenement", ['id_ev' => $args['id_ev']]);
        return $rs->withRedirect($url_accueil);
    }


    public function demanderRejoindre(Request $rq, Response $rs, $args): Response
    {
        $notification = new Notification();
        $notification->n_objet = "Demande à rejoindre";
        $notification->n_contenu = "L'utilisateur " . $args['participant'] . " veut rejoindre l'événement " . $args['id_ev'];
        $notification->n_statut = "non lue";
        $notification->n_type = "invitation";
        $notification->n_expediteur = $_SESSION['profile']['mail'];
        $notification->n_destinataire = evenement::where('e_id', '=', $args['id_ev'])->first()->e_proprio;
        $notification->n_event = $args['id_ev'];
        $notification->save();
        $url_accueil = $this->container->router->pathFor("evenement", ['id_ev' => $args['id_ev']]);
        return $rs->withRedirect($url_accueil);
    }



    public function nousContacter(Request $rq, Response $rs, $args): Response
    {

        $vue = new VueEvenement([], $this->container);
        $rs->getBody()->write($vue->render(4));
        return $rs;
    }



}
