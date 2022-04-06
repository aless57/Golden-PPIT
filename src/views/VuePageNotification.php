<?php

namespace goldenppit\views;

class VuePageNotification
{
    private $tab;
    private $container;

    /**
     * VuePageNotification constructor.
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
        $url_contact = $this->container->router->pathFor('contact');
        $url_afficherNot = $this->container->router->pathFor('afficherNotifications');

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
                       <li> <a href="$url_afficherNot"> Notifications </a> </li> 
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

        if ($select == 0) {
            $content = $this->pageNotification();
        }
        return <<<FIN
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
                <a href="$url_contact"> Nous contacter </a>
                <a href="#"> A propos de nous </a>
                <p> © 2022 GoldenPPIT. Tous droits réservés </p>
        </div>    
    
    </footer>
</html>
FIN;
    }

    public function pageNotification(): string
    {
        $id_not = $this->tab[0];
        $objet = $this->tab[1];
        $contenu = $this->tab[2];
        $type = $this->tab[3];
        $nom_expediteur = $this->tab[6];
        $prenom_expediteur = $this->tab[7];
        $id_event = $this->tab[8];

            
        
        $url_supprimer = $this->container->router->pathFor('supprimerNotification', ['id_not' => $id_not]);
        $url_rejoindre = $this->container->router->pathFor('rejoindreEvenement', ['id_not' => $id_not]);




        $content = "";
        if ($type == "invitation") {
            $content .= "<button class=\"btn-supp-not\" onclick=\"window.location.href='$url_rejoindre'\"/>Rejoindre</button>";
        }
        if ($type == "Suggestion"){


            preg_match('/(La description du besoin)/', $contenu, $match, PREG_OFFSET_CAPTURE);
            $b_desc = substr($contenu,$match[0][1] + strlen('La description du besoin</u> :'));

            
            preg_match('/(\()/', $objet, $match, PREG_OFFSET_CAPTURE);
            $b_objet = substr($objet,$match[0][1] +1, -1); // + 1 - 1 Les deux parenthèses

            $url_accepterBesoin = $this->container->router->pathFor('accepterSuggestionBesoin', [ 'id_not' => $id_not, 'b_event' => $id_event, 'b_objet' => $b_objet, 'b_desc' => $b_desc ]);
            $content .= "<button class=\"btn-supp-not\" onclick=\"window.location.href='$url_accepterBesoin'\"/>Ajouter</button>";
        }

        if($type == "demande"){
            $content .= "<button class=\"btn-supp-not\" onclick=\"window.location.href='$url_rejoindre'\"/>Accepter</button>";
        }

        return <<<FIN
        <section class="page-evenement">
            <div class="container ">
            <div class=" details-bg">
                   
                    <div class="info">
                    <div class=" labels-details-ev">
                        <h2> Notification de type : </h2>
                        <h2 class="details-ev"> $type </h2>
                    </div>
                    <div class=" labels-details-ev">
                        <h2> Expéditeur : </h2>
                        <h2 class="details-ev"> $prenom_expediteur $nom_expediteur </h2>
                    </div>

                    <div class="labels-details-ev"> 
                        <h2> Objet : </h2>
                        <h2 class="details-ev" > $objet </h2>
                    </div>
                     <div class="labels-details-ev"> 
                    <button class="btn-supp-not" onclick="window.location.href='$url_supprimer'"/>Supprimer</button>
                    $content
                    </div>
                     <?php 
                    
                    </div>

            </div>
            </div>
                <div class="description">
                     <h3>Contenu du message: </h3>

                    <h2 class="content-not"> $contenu </h2>

                </div>
              
              
            </section>   
FIN;
    }


}