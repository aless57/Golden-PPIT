<?php

namespace goldenppit\controllers;

use goldenppit\models\utilisateur;
use goldenppit\views\VueNotification;
use goldenppit\models\notification;
use goldenppit\views\VuePageNotification;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ControlleurNotification
{
    private $container;
    private $today;

    /**
     * ControlleurNotification constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function afficherNotifications(Request $rq, Response $rs, $args): Response
    {
        $nbNotifs = Notification::all()->count();
        $notifs = Notification::all();
        $vue = new VueNotification([$nbNotifs, $notifs], $this->container);
        $rs->getBody()->write($vue->render(0)); //on ouvre la page d'affichage des notifications
        return $rs;
    }

    /**
     * GET
     * Affichage d'un evenement
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
        $nom_expediteur = Utilisateur::where('e_id', '=', $mail_expediteur)->first()->u_nom;
        $prenom_expediteur = Utilisateur::where('e_id', '=', $nom_expediteur)->first()->u_prenom;

        //récupérer les champs ici et les mettre entre les crochets
        $vue = new VuePageNotification([$id_not, $objet, $contenu, $type, $mail_expediteur, $mail_destinataire, $nom_expediteur, $prenom_expediteur], $this->container);
        $rs->getBody()->write($vue->render(0)); //on ouvre la page d'une notification
        return $rs;
    }
}