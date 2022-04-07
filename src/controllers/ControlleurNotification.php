<?php

namespace goldenppit\controllers;

use goldenppit\models\notification;
use goldenppit\models\participe;
use goldenppit\models\utilisateur;
use goldenppit\models\besoin;
use goldenppit\models\evenement;
use goldenppit\views\VueNotification;
use goldenppit\views\VuePageNotification;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ControlleurNotification
{
    private $container;

    /**
     * ControlleurNotification constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function afficherNotifications(Request $rq, Response $rs): Response
    {
        $nbNotifs = Notification::all()->count();
        $notifs = Notification::all();
        $vue = new VueNotification([$nbNotifs, $notifs], $this->container);
        $rs->getBody()->write($vue->render(0)); //on ouvre la page d'affichage des notifications
        return $rs;
    }

    /**
     * GET
     * Affichage d'une notification
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function consulterNotification(Request $rq, Response $rs, $args): Response
    {
        $id_not = $args['id_not'];

        $objet = Notification::where('n_id', '=', $id_not)->first()->n_objet;
        $contenu = Notification::where('n_id', '=', $id_not)->first()->n_contenu;
        $type = Notification::where('n_id', '=', $id_not)->first()->n_type;
        $mail_expediteur = Notification::where('n_id', '=', $id_not)->first()->n_expediteur;
        $mail_destinataire = Notification::where('n_id', '=', $id_not)->first()->n_destinataire;
        $event_id = Notification::where('n_id', '=', $id_not)->first()->n_event;
        //On veut afficher le nom et le prénom et pas le mail sur la notification.
        $nom_expediteur = Utilisateur::where('u_mail', '=', $mail_expediteur)->first()->u_nom;
        $prenom_expediteur = Utilisateur::where('u_mail', '=', $mail_expediteur)->first()->u_prenom;

        //récupérer les champs ici et les mettre entre les crochets
        $vue = new VuePageNotification([$id_not, $objet, $contenu, $type, $mail_expediteur, $mail_destinataire, $nom_expediteur, $prenom_expediteur, $event_id], $this->container);
        $rs->getBody()->write($vue->render(0)); //on ouvre la page d'une notification
        return $rs;
    }

    /**
     * POST
     * Suppression d'une notification
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function supprimerNotification(Request $rq, Response $rs, $args): Response
    {
        $notif = Notification::find($args['id_not']);
        $notif->delete();
        //TODO : remettre sur la page précedente
        $url_accueil = $this->container->router->pathFor('accueil');
        return $rs->withRedirect($url_accueil);
    }

    public function accepterSuggestionBesoin(Request $rq, Response $rs, $args): Response
    {
        $notif = Notification::find($args['id_not']);
        

        $nom_besoin;
        $desc_besoin;

        $res = explode("<strong>",$notif->n_contenu);
        $res = explode("</strong>", $res[2]);

        $nom_besoin = $res[0];

        $res = explode("</u>", $notif->n_contenu);
        $res = explode(":", $res[1]);
        $desc_besoin = $res[1];

        $besoin = new besoin();

         
        $besoin->b_objet = $nom_besoin;
        $besoin->b_desc = $desc_besoin;
        $besoin->b_event = $notif->n_event;
        $besoin->b_nombre = 1;

        $besoin->save();
        $notif->delete();

        //TODO : remettre sur la page précedente
        $url_accueil = $this->container->router->pathFor('accueil');
        return $rs->withRedirect($url_accueil);
    }

    /**
     * Rejoindre un événement à partir d'un id.
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function rejoindreEvenement(Request $rq, Response $rs, $args): Response
    {

        $id_not = $args['id_not'];

        //Ajout de l'utilisateur dans l'évenement auquel il a été invité
        $id_event = Notification::where('n_id', '=', $id_not)->first()->n_event;
        $type_notif = Notification::where('n_id', '=', $id_not)->first()->n_type;
        $exp_notif =  Notification::where('n_id', '=', $id_not)->first()->n_expediteur;
        if($type_notif == "invitation"){
            $user = Utilisateur::find($_SESSION['profile']['mail']);
        }else if($type_notif=="demande"){
            $user = Utilisateur::find($exp_notif);
        }
        var_dump($user);
        var_dump($type_notif);
        $participant = new participe();
        $participant->p_user = $user->u_mail;
        $participant->p_event = $id_event;
        $participant->save();

        //Suppression de la notification
        $notif = Notification::find($id_not);
        $notif->delete();

        //Redirection de l'utilisateur vers l'accueil
        //TODO Renvoyer vers l'event et non l'accueil
        $url_accueil = $this->container->router->pathFor('accueil');
        return $rs->withRedirect($url_accueil);
    }
}