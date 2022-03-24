<?php

namespace goldenppit\views;

class VuePageNotification
{
    private $tab;
    private $container;

    /**
     * VuePageEvenement constructor.
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

        $url_accueil = $this->container->router->pathFor('accueil');
        $url_formInsription = $this->container->router->pathFor('formInscription');
        $url_formConnexion = $this->container->router->pathFor('formConnexion');

        $url_modifierCompte = $this->container->router->pathFor('formModifierCompte');
        $url_deconnexion = $this->container->router->pathFor('deconnexion');

        $content = "";
        if (isset($_SESSION['profile'])) {
            //si l'utilisateur est connecté
            $bandeau .= <<<FIN
            <div class="logo">
                <a href="$url_accueil" title="logo">
                    <img src="../images/logo-white.png" alt="logo-accueil" >
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
            $select = -1;
            $bandeau .= <<<FIN

            <div class="logo">
                <a href="$url_accueil" title="logo">
                    <img src="../images/logo-white.png" alt="logo-accueil" >
                </a>
            </div>
            <div class="menu text-right">
                <ul>
                    <li> <a href="$url_formConnexion"> Se connecter </a></li>
                    <li> <a href="$url_formInsription"> S'inscrire </a> </li>      
                </ul>
            </div>
FIN;
            $content = <<<FIN
        <div class="logo">
                <a href="$url_accueil" title="logo">
                    <img src="../images/logo-white.png" alt="logo-accueil" >
                </a>
            </div>
    <div class ="message-erreur">
        <h1>Vous devez être connecté pour accéder à cette page !</h1>
        <h2> <a href ="$url_accueil" > Connectez vous ici ! </a> </h2>
    </div>

FIN;


        }

        switch ($select) {
            case 0:
                $content = $this->pageNotification();
                break;
        }
        $html = <<<FIN
<html lang="french">

<head>
    <title>GoldenPPIT</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <nav>
    <div class = "container">
    
        $bandeau
            <div class="clearfix"></div>
        </div>
    </nav>
    <div class = "content-wrap">
        $content
    </div>
    
</body>
<footer>
    <div class="clearfix"></div>
        <div class="container text-center">
                <a href="#"> Nous contacter </a>
                <a href="#"> A propos de nous </a>
                <p> © 2022 GoldenPPIT. Tous droits réservés </p>
        </div>    
    
    </footer>
</html>
FIN;

        return $html;
    }

    public function pageNotification(): string
    {
        $id_not = $this->tab[0];
        $objet = $this->tab[1];
        $contenu = $this->tab[2];
        $type = $this->tab[3];
        $expediteur = $this->tab[4];
        $destinateire = $this->tab[5];
        $nom_expediteur = $this->tab[6];
        $prenom_expediteur = $this->tab[7];

        $html = <<<FIN
        <section class="page-evenement">
            <div class="container ">
            <div class=" details-bg">
                    <div class="img-ev">
                        </div>
                        
                        <div class="info">
                    <div class=" labels-details-not"> 
                        <h2> Objet : </h2>
                        <h2 class="details-not" > $objet </h2>
                    </div>
                    <div class=" labels-details-not">
                        <h2> Expéditeur : </h2>
                        <h2 class="details-not"> $prenom_expediteur $nom_expediteur </h2>
                    </div>
                    <div class=" labels-details-not">
                        <h2> Notification de type : </h2>
                        <h2 class="details-not"> $type </h2>
                    </div>
                    
                    <div class=" labels-details-not">
                        <h2> Contenu : </h2>
                        <h2 class="details-not"> $contenu </h2>
                    </div>
                    </div>

            </div>
            </div>
         
              
            </section>   
FIN;
        return $html;
    }


}