<?php

namespace goldenppit\views;

class VueNotification
{
    private $tab;
    private $container;

    /**
     * VueNotification constructor.
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

        $url_accueil = $this->container->router->pathFor('accueil');
        $url_formInsription = $this->container->router->pathFor('formInscription');
        $url_formConnexion = $this->container->router->pathFor('formConnexion');

        $url_modifierCompte = $this->container->router->pathFor('formModifierCompte');
        $url_menu = $this->container->router->pathFor('accueil');
        $url_deconnexion = $this->container->router->pathFor('deconnexion');
        $url_contact = $this->container->router->pathFor('contact');

        $url_afficherNot = $this->container->router->pathFor('afficherNotifications');
        $content = "";
        if (!isset($_SESSION['profile'])) {
            $select = -1;
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
                <li> <a href="$url_afficherNot"> Notifications </a> </li> 
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

        return <<<FIN
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
                <a href="$url_contact"> Nous contacter </a>
                <a href="#"> A propos de nous </a>
                <p> © 2022 GoldenPPIT. Tous droits réservés </p>
        </div>    
    
    </footer>
</html>
FIN;
    }

    /**
     * Affichage d'une notification
     * @return string
     */
    public function afficherNotifications(): string
    {

        $notifications = "";
        //var_dump($this->tab[1]);


        for ($i = 0; $i < $this->tab[0]; $i++) { //pour chaque notif
            $test = $this->tab[1][$i]->n_objet;
            $test_2 = $this->tab[1][$i]->n_id;
            $test_3 = $this->tab[1][$i]->n_expediteur;
            $test_4 = $this->tab[1][$i]->n_destinataire;
            $url_notifs = $this->container->router->pathFor("consulterNotification", ['id_not' => $test_2]);
            $url_supprimer = $this->container->router->pathFor('supprimerNotification', ['id_not' => $this->tab[1][$i]->n_id]);
            $user_email = $_SESSION['profile']['mail'];
            if ($test_4 == $user_email) {
                $notifications .= <<<FIN
            <div class="alignement-notif">
         

            <div id="$test_2" >
                <button id="$test_2" name="test" class="notif" > <h4>$test</h4></br> envoyé par $test_3</button>
            </div>   
              <button class="bouton-rouge-2" onclick="window.location.href='$url_supprimer'" > Supprimer </button>
              </div>
           <script>    
              document.getElementById('$test_2').addEventListener('click', function() {
              console.log('$url_notifs');
              window.location.href = '$url_notifs'; 
              
            });        
            </script>
            
FIN;
            }

        }

        return <<<FIN
            <body>
                    <h1 class="text-center"> LES NOTIFICATIONS </h1>
                    
                    <div id="listeNotifications" class = "container">
                        $notifications
                    </div>
                    
                    <script>
                        let tab =; {$this->tab[1]};
                    </script>
            </body>
FIN;
    }

}