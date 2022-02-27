<?php

namespace goldenppit\controllers;

use goldenppit\views\VueModifierCompte;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ControlleurModifierCompte{
    private $container;


    /**
     * ControleurModidierCompte constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }
    /**
     * GET
     * Affichage du formulaire pour création de compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function modifierCompte(Request $rq, Response $rs, $args) : Response {
        $vue = new VueModifierCompte( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render(0)) ;
        return $rs;
    }
}