<?php

namespace goldenppit\controllers;

use goldenppit\views\VueConnexion;
use goldenppit\views\VueInscription;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \goldenppit\models\Utilisateur;
use \goldenppit\models\Ville;

class ControlleurCompte
{
    private $container;
    private $today;

    /**
     * ControlleurCompte constructor.
     * @param $container
     */
    public function __construct($container) {
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
    public function inscription(Request $rq, Response $rs, $args) : Response {
        $vue = new VueInscription( [] , $this->container ) ;
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
    public function enregistrerInscription(Request $rq, Response $rs, $args) : Response {
        $post = $rq->getParsedBody();
        $pass = filter_var($post['pass'] , FILTER_SANITIZE_STRING) ;
        $nom = filter_var($post['nom'], FILTER_SANITIZE_STRING);
        $prenom = filter_var($post['prenom'], FILTER_SANITIZE_STRING);
        $sexe = filter_var($post['sexe'], FILTER_SANITIZE_STRING);
        $mail = filter_var($post['mail'], FILTER_SANITIZE_EMAIL);
        $naissance = filter_var($post['naissance'], FILTER_SANITIZE_STRING);
        $ville = filter_var($post['id_ville'], FILTER_SANITIZE_STRING);
        $notif_mail = filter_var($post['notif_mail'], FILTER_SANITIZE_NUMBER_INT);
        $tel = filter_var($post['tel'], FILTER_SANITIZE_STRING);
        $vue = new VueCompte( [ 'mail' => $mail ] , $this->container ) ;
        $notif = 0;
        if($notif_mail){
            $notif = 1;
        }
        if (Authentification::createUser($nom, $prenom, $pass, $sexe, $mail, $naissance, $ville, $tel, $notif, $ville)){
            Authentification::authenticate($mail, $pass);
            $_SESSION['inscriptionOK'] = true;
            $url_accueil = $this->container->router->pathFor("afficherCompte");
            return $rs->withRedirect($url_accueil);
        }else{
            $rs->getBody()->write( $vue->render(2));
        }
        return $rs;
    }

    /**
     * GET
     * Affichage du formulaire de connexion
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function connexion(Request $rq, Response $rs, $args) : Response {
        if (isset($_SESSION['connexionOK'])){
            if(!$_SESSION['connexionOK']){
                session_destroy();
                $_SESSION = [];
                $vue = new VueConnexion([] , $this->container) ;
                $rs->getBody()->write( $vue->render(1));
                return $rs;
            }{
                $vue = new VueConnexion([], $this->container);
                $rs->getBody()->write( $vue->render(0));
                return $rs;
            }
            //autre cas (avec les inscriptions)
        }else{
            $vue = new VueConnexion([], $this->container);
            $rs->getBody()->write( $vue->render(0));
            return $rs;
        }
    }

    /**
     * POST
     * Test de la connexion
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function testConnexion(Request $rq, Response $rs, $args) : Response {
        $post = $rq->getParsedBody() ;
        $login = filter_var($post['mail']       , FILTER_SANITIZE_STRING) ;
        $pass = filter_var($post['pass'] , FILTER_SANITIZE_STRING) ;
        $connexionOK = Authentification::authenticate($login, $pass);
        var_dump($connexionOK);
        if ($connexionOK){
            $url_compte = $this->container->router->pathFor("racine");
            //$_SESSION['profile'] = $mail;
            return $rs->withRedirect($url_compte);
        }else{
            $_SESSION['connexionOK']=false;
            $url_connexion = $this->container->router->pathFor("connexion");
            return $rs->withRedirect($url_connexion);
        }
    }

    /**
     * GET
     * Affichage du compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function afficherCompte(Request $rq, Response $rs, $args) : Response {
        $infosUser = Utilisateur::where('mail','=',$_SESSION['profile']['mail'])->first();
        $vue = new VueCompte($infosUser->toArray(), $this->container );
        if (isset($_SESSION['inscriptionOK'])) {
            if ($_SESSION['inscriptionOK']) {
                // on vient de s'inscrire
                $rs->getBody()->write( $vue->render(4));
                $info = $_SESSION['profile'];
                $_SESSION = [];
                $_SESSION['profile'] = $info;
                return $rs;
            }else {
                $rs->getBody()->write( $vue->render(5));
                return $rs;
            }
        }else if (isset($_SESSION['passwordOK'])) {
            if ($_SESSION['passwordOK']) {
                $info = $_SESSION['profile'];
                $_SESSION = [];
                $_SESSION['profile'] = $info;
                $vue = new VueCompte($infosUser->toArray(), $this->container);
                $rs->getBody()->write($vue->render(7));
                return $rs;
            } else {
                $info = $_SESSION['profile'];
                $_SESSION = [];
                $_SESSION['profile'] = $info;
                $vue = new VueCompte($infosUser->toArray(), $this->container);
                $rs->getBody()->write($vue->render(5));
                return $rs;
            }
        }else{
            $rs->getBody()->write($vue->render(5));
            return $rs;
        }
    }

    /**
     * POST
     * Enregistrement du nouveau mot de passe
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function enregistrerMotDePasse(Request $rq, Response $rs, $args) : Response {
        $infosUser = Utilisateur::where('mail','=',$_SESSION['profile']['mail'])->first();
        $post = $rq->getParsedBody();
        $ancienMDP = filter_var($post['ancienMDP'], FILTER_SANITIZE_STRING);
        $nouveauMDP = filter_var($post['nouveauMDP'], FILTER_SANITIZE_STRING);
        $confirmerMDP = filter_var($post['confirmerMDP'], FILTER_SANITIZE_STRING);
        $mdpOK = Authentification::authenticate($_SESSION['profile']['username'], $ancienMDP);

        if (!$mdpOK) {
            $vue = new VueCompte( $infosUser->toArray() , $this->container ) ;
            $rs->getBody()->write($vue->render(11)) ;
            return $rs;
        }else {
            if ($nouveauMDP != $confirmerMDP) {
                $vue = new VueCompte( $infosUser->toArray() , $this->container ) ;
                $rs->getBody()->write($vue->render(12)) ;
                return $rs;
            }else {
                $infosUser->mdp = password_hash($nouveauMDP, PASSWORD_DEFAULT);
                $infosUser->save();
                $_SESSION['passwordOK'] = true;
                $url_enregisterModif = $this->container->router->pathFor('enregistrerModif');
                return $rs->withRedirect($url_enregisterModif);
            }
        }

    }

    /**
     * POST
     * Enregistrement des nouvelles informations sur le compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function enregistrerModif(Request $rq, Response $rs, $args) : Response {
        $infoUser = Utilisateur::where("mail","=",$_SESSION['profile']['mail'])->first();
        $post = $rq->getParsedBody();
        $nouveauMail = filter_var($post['mail']);
        $nbNouveauMail = Utilisateur::where("mail","=",$nouveauMail)->count();
        if ($nbNouveauMail > 0 && $nouveauMail != $infoUser->email) {
            $vue = new VueCompte($infoUser->toArray(), $this->container);
            $rs->getBody()->write($vue->render(9));
            return $rs;
        }else {
            $infoUser->u_nom = filter_var($post['nom'], FILTER_SANITIZE_STRING);
            $infoUser->u_prenom = filter_var($post['prenom'], FILTER_SANITIZE_STRING);
            $infoUser->u_login = filter_var($post['login'], FILTER_SANITIZE_STRING);
            $infoUser->u_mail = filter_var($post['mail'], FILTER_SANITIZE_STRING);
            $infoUser->u_sexe = filter_var($post['sexe'], FILTER_SANITIZE_STRING);
            $infoUser->u_naissance = filter_var($post['naissance'], FILTER_SANITIZE_STRING);
            $infoUser->u_tel = filter_var($post['tel'], FILTER_SANITIZE_STRING);
            $infoUser->save();
            $vue = new VueCompte( $infoUser->toArray(), $this->container ) ;
            $_SESSION['profile']['mail'] = $nouveauMail;
            $rs->getBody()->write( $vue->render(7));
            return $rs;
        }
    }

    /**
     * GET
     * Affichage du formulaire de modification des informations du compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function modifierCompte(Request $rq, Response $rs, $args) : Response  {
        $infosUser = Utilisateur::where('mail','=',$_SESSION['profile']['mail'])->first();
        $vue = new VueCompte( $infosUser->toArray() , $this->container ) ;
        $rs->getBody()->write( $vue->render(6)) ;
        return $rs;
    }

    /**
     * GET
     * Affichage du formulaire de modification de mot de passe
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function changerMotDePasse (Request $rq, Response $rs, $args) : Response  {
        $infosUser = Utilisateur::where('mail','=',$_SESSION['profile']['mail'])->first();
        $vue = new VueCompte( $infosUser->toArray() , $this->container ) ;
        $rs->getBody()->write($vue->render(10));
        return $rs;
    }



    /**
     * GET
     * Deconnexion du compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function deconnexion(Request $rq, Response $rs, $args) : Response {
        session_destroy();
        $_SESSION = [];
        $url_accueil = $this->container->router->pathFor('connexion');
        return $rs->withRedirect($url_accueil);
    }

    /**
     * POST
     * Suppression du compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function supprimerCompte(Request $rq, Response $rs, $args) : Response {
        session_destroy();
        $user = Utilisateur::find($_SESSION['profile']['mail']);
        $user->delete();
        setcookie("mail", '-1', time() + 60*60*24*30, "/" );
        session_destroy();
        $_SESSION = [];
        $url_accueil = $this->container->router->pathFor('racine');
        return $rs->withRedirect($url_accueil);
    }
}