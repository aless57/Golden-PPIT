<?php

namespace goldenppit\views;

class VueNotification
{
    private $tab;
    private $container;

    /**
     * VueEvenement constructor.
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
        $url_menu = $this->container->router->pathFor('accueil');
        $url_deconnexion = $this->container->router->pathFor('deconnexion');
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
            $select = -1;
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
            $content = <<<FIN
    <div class ="message-erreur">
        <h1>Vous devez être connecté pour accéder à cette page !</h1>
        <h2> <a href ="$url_accueil" > Connectez vous ici ! </a> </h2>
    </div>

FIN;


        }
        $bandeau = "";
        if (isset($_SESSION['profile'])) {
            //Si l'utilisateur est connecté
            $bandeau .= <<<FIN
            <div class="menu text-right">
                <div class="logo">
                <a href="$url_menu" title="logo">
                    <img src="images/logo-white.png"  alt="">
                </a>
            </div>
                <ul>  
                <li> <a href="$url_modifierCompte"> Modifier compte </a> </li>  
                <li> <a href ="$url_deconnexion"> Se deconnecter</a></li>     
                </ul>
            </div>

            FIN;

        } else {
            //si 'l'utilisateur n'est pas connecté
            $bandeau .= <<<FIN
            <div class="menu text-right">
               <div class="logo">
                <a href="$url_accueil" title="logo">
                    <img src="images/logo-white.png" alt="logo-accueil" >
                </a>
            </div>
                <ul>
                    <li> <a href="$url_formConnexion"> Se connecter </a></li>
                    <li> <a href="$url_formInsription"> S'inscrire </a> </li>      
                </ul>
            </div>
            FIN;

        }
        switch ($select) {
            case 0: //page d'affichage des notifications
            {
                $content .= $this->afficherNotifications();
                break;
            }
            /*case 1:
            {
                $content .= $this->ConsulterNotification();
                break;
            }*/
        }

        $html = <<<FIN
<html lang="french">

<head>
    <title>GoldenPPIT</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="src/calendar/calendarjs.css" />
    <script src="src/calendar/calendarjs.js"></script>
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

    public function afficherNotifications(): string
    {

        $notifications = "";
        $test = "";
        //var_dump($this->tab[1]);



        for ($i = 0; $i < $this->tab[1]->count(); $i++) {
            $test = $this->tab[1][$i]->n_objet;
            $test_2 = $this->tab[1][$i]->n_id;
            $url_notifs = $this->container->router->pathFor('accueil');//$this->container->router->pathFor("consulterNotification/", ['id_not' => $test_2]);
            $notifications .= <<<FIN
            
            <div id="$test_2" class="alignement">
                <button id="$test_2" name="test" class="bouton-blanc" >$test</button>
            </div>   
            
           <script>    
            var notif = document.getElementById('$test_2');
            
            notif.addEventListener('click', function(notif) {
              console.log('$url_notifs');
              window.location.href = '$url_notifs'; 
              
            });        
            </script>
            
FIN;

        }

        $html = <<<FIN
            <body>
                    <h1 class="text-center"> LES NOTIFICATIONS </h1>
                    
                    <div id="listeEvenements" class = "container">
                        $notifications
                    </div>
                    
                    <script>
                        var tab = {$this->tab[1]};
                        console.log(tab);
                    </script>
            </body>
FIN;
        return $html;
    }

}