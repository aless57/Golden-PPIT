<?php

namespace goldenppit\controllers;

use goldenppit\views\VueNotification;
use goldenppit\models\notification;
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
}