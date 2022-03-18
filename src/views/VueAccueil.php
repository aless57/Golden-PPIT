<?php

namespace goldenppit\views;

class VueAccueil
{

    private $tab;
    private $container;

    /**
     * VueAccueil constructor.
     * @param $tab
     * @param $container
     */
    public function __construct($tab, $container)
    {
        $this->tab = $tab;
        $this->container = $container;
    }

    /**
     * RENDER
     * @param int $select
     * @return string
     */
    public function render(int $select): string
    {
        $bandeau = "";
        $url_accueil = $this->container->router->pathFor('racine');
        $url_formConnexion = $this->container->router->pathFor('formConnexion');
        $url_formInsription = $this->container->router->pathFor('formInscription');
        $url_modifierCompte = $this->container->router->pathFor('formModifierCompte');
        $url_menu = $this->container->router->pathFor('accueil');
        $url_deconnexion = $this->container->router->pathFor('deconnexion');

        $url_creationEv = $this->container->router->pathFor('creationEvenement');
        $url_enregistrerEv = $this->container->router->pathFor('enregistrerEvenement');
        $url_afficherEv = $this->container->router->pathFor('afficherListe');

        $content = "";
        if (isset($_SESSION['profile'])) {
            //si l'utilisateur est connecté
            $bandeau .= <<<FIN
            <div class="logo">
                <a href="$url_menu" title="logo">
                    <img src="images/logo-white.png"  alt="">
                </a>
            </div>
            <div class="menu text-right">
            
                <ul>  
                       <li> <a href="$url_modifierCompte"> Modifier compte </a> </li> 
                       <li> <a href ="$url_deconnexion"> Se deconnecter</a></li>    
                </ul>
            </div>

FIN;

        } else {
            $bandeau .= <<<FIN
            <div class="logo">
                <a href="$url_accueil" title="logo">
                    <img src="images/logo-white.png" alt="logo-accueil" >
                </a>
            </div>
            <div class="menu text-right">
                <ul>
                    <li> <a href="$url_formConnexion"> Se connecter </a></li>
                    <li> <a href="$url_formInsription"> S'inscrire </a> </li>      
                </ul>
            </div>
FIN;
        }
        switch ($select) {
            case 0:
            {
                if (!isset($_SESSION['profile'])) {
                $content .= <<<FIN
<section>
    <div class="logo-accueil" >            
        <img src="images/logo-accueil.png" class="img-logo" alt="logo-accueil">
    </div>
        <div class="text-center">
            <p class = "p-accueil"> Rejoignez notre communauté et devenez membre de notre association ! </p>
            <button class="bouton-bleu" type="button" onclick="window.location.href='$url_formInsription'">Créer un compte</button>
          
            <p class = "p-accueil2"> Vous avez déjà un compte? <a href="$url_formConnexion"> Connectez-vous!</a> </p>

        <div class="clearfix"></div>
        </div>
        
    </section>
FIN;}
                else{
                    $content .= <<<FIN
            <body>
                    <h1 class="text-center"> MENU </h1>
                    
                    <div class = "container">
                        <button class="bouton-blanc" onclick="window.location.href='$url_creationEv'">Créer un événement</button>
                        <button class="bouton-blanc" onclick="window.location.href='$url_afficherEv'">Consulter la liste des événements</button>
                        <button class="bouton-blanc">Gérer mon événement</button>
                        <button class="bouton-blanc">Voir le calendrier de mes événements</button>
                    </div>
            
            
            </body>
FIN;                }
                break;

            }
            case 1:
            {
                if (isset($_SESSION['profile'])) {
                    //si l'utilisateur est connecté
                    $content .= <<<FIN
            <body>
                    <h1 class="text-center"> MENU </h1>
                    
                    <div class = "container">
                        <button class="bouton-blanc" onclick="window.location.href='$url_creationEv'">Créer un événement</button>
                        <button class="bouton-blanc" onclick="window.location.href='$url_afficherEv'">Consulter la liste des événements</button>
                        <button class="bouton-blanc">Gérer mon événement</button>
                        <button class="bouton-blanc">Voir le calendrier de mes événements</button>
                    </div>
            
            
            </body>
FIN;

                } else {

                    $content = <<<FIN
    <div class ="message-erreur">
        <h1>Vous devez être connecté pour accéder à cette page !</h1>
        <h2> <a href ="$url_accueil" > Connectez vous ici ! </a> </h2>
    </div>

FIN;
                }
                break;
            }
            case 2:
            {
                $content .= "Probleme de connexion";
                break;
            }
        }
        return <<<FIN
<html lang="french">

<head lang="french">
    <title>GoldenPPIT</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav>
        <div class ="container">
            
                $bandeau

            <div class="clearfix"></div>
        </div>
    </nav>
    <div class = "content-wrap">
        $content
    </div>
    
</body>
<footer>
<div class="container">
                <a href="#" class="text-center"> Nous contacter </a>
                <a href="#" class="text-center"> A propos de nous </a>
                <p class="text-center"> © 2022 GoldenPPIT. Tous droits réservés </p>
    </div>
    </footer>
</html>
FIN;
    }
}
