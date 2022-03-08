<?php

namespace goldenppit\controllers;

use goldenppit\views\VueAccueil;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ControlleurAccueil{
    private $container;


    /**
     * ControleurAccueil constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * GET
     * Affichage inscription/connexion
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function connexionInscription(Request $rq, Response $rs, $args) : Response {
        $vue = new VueAccueil(array(), $this->container);
        $rs->getBody()->write($vue->render(0));
        return $rs;
    }

    /**
     * GET
     * Affichage accueil
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function accueil(Request $rq, Response $rs, $args) : Response {
        $vue = new VueAccueil(array(), $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }
}