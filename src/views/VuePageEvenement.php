<?php


namespace goldenppit\views;


use goldenppit\models\besoin;
use goldenppit\models\participe_besoin;
use goldenppit\models\utilisateur;

class VuePageEvenement
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
        $url_menu = $this->container->router->pathFor('accueil');
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
                $content = $this->pageEvenement();
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

    public function tabBesoin($nb_participants, $participants): string
    {
        $row = "";

        for ($i = 0; $i < $nb_participants; $i++) {
            $column = "";

            $p_mail = $participants[$i]->p_user;
            $participant_nom = Utilisateur::where('u_mail', '=', $p_mail)->first()->u_nom;
            $participant_prenom = Utilisateur::where('u_mail', '=', $p_mail)->first()->u_prenom;

            $participe_au_besoin = Participe_Besoin::where('pb_user', '=', $p_mail);

            if ($participe_au_besoin->get()->count() != 0) {
                for ($j = 0; $j < $participe_au_besoin->get()->count(); $j++) {
                    $id_b = $participe_au_besoin->get()[$j]->pb_besoin;
                    $nom_b = Besoin::where('b_id', '=', $id_b)->get()->first()->b_objet;
                    $column .= <<<FIN
                        <td> $nom_b </td>
                    FIN;
                }

            } else {
                $column .= <<<FIN
                        <td> Aucun besoin n'est associé.</td>
                    FIN;
            }
            $row .= <<<Fin
                    <tr>
                       <td> $participant_prenom $participant_nom</td>
                       
                      $column
                    </tr>
                Fin;


        }
        $html = <<<FIN
        
                <table class = "tabBesoin" id = "tableBesoin">
                <caption class="caption">Voici la répartition des besoins pour l'événement.</caption>
                        $row
                </table>
        <script>
            let table  = document.getElementById("tableBesoin"); 
             
            //parcourir les lignes
            for(let i = 0; i < table.rows.length; i++){
                //parcourir les cellules de la table
                for(let j = 1; j< table.rows[i].cells.length; j++){ //on commence à 1 car on ne peut pas selectionner le nom d'un participe dans la liste
                    table.rows[i].cells[j].onclick = function(){
                        this.classList.toggle("selected");  //activer la classe de style
                    };
                }
            }
        </script>
        FIN;

        return $html;
    }


    public function pageEvenement(): string
    {
        $url_quitter = $this->container->router->pathFor('quitterEvenement');
        $id_ev = $this->tab[0];

        $url_supprimer = $this->container->router->pathFor('supprimerEvenement', ['id_ev' => $id_ev]);

        $nom = $this->tab[1];
        $date_deb = $this->tab[2];
        $date_fin = $this->tab[3];
        $proprio = $this->tab[4];
        $proprio_nom = $this->tab[5];
        $proprio_prenom = $this->tab[6];
        $ville = $this->tab[7];
        $desc = $this->tab[8];
        $nb_participants = $this->tab[9];
        $participants = $this->tab[10];
        $participant_s = "";
        if ($nb_participants > 1) {
            $participant_s = "participants";
        } else {
            $participant_s = "participe";
        }
        $boutons =
            <<<FIN
                
                <button class="bouton-bleu">Inviter</button>
            FIN;
        if ($proprio == $_SESSION['profile']['mail']) {//si l'utilisateur est propriétaire :
            $boutons .=
                <<<FIN
                    <div class="dropdown">
                      <button class="bouton-bleu">Paramètres</button>
                      <div class="dropdown-content">
                        <span> <a href="#">Gérer les besoins</a></span>
                        <span> <a href="#">Gérer les participants</a></span>
                        <span> <a href="#">Léguer l'événement</a></span>
                        <span> <a href="$url_supprimer" class="supp">Supprimer l'événement</a></span>
                      </div>
                    </div>
            FIN;
        } else {
            $boutons .= <<<FIN
                <button class="bouton-bleu" onclick="window.location.href='#'">Suggérer un besoin</button>
                <button class="bouton-bleu">Suggérer une modification</button>
            FIN;

        }
        $boutons .= <<<FIN
                <button class="bouton-rouge" onclick="window.location.href='$url_quitter'">Quitter l'événement</button>

            FIN;
        $tab = $this->tabBesoin($nb_participants, $participants);

        //TODO Corriger bug chelou : mb_strpos(): Argument #1 ($haystack) must be of type string, array given
        $html = <<<FIN
        <section class="page-evenement">
            <div class="container ">
                
                
            
            <div class=" details-bg">
                    <div class="img-ev">
                        </div>
                        
                        <div class="info">
                    <div class=" labels-details-ev"> 
                        <h2> Nom de l'évènement : </h2>
                        <h2 class="details-ev" > $nom </h2>
                    </div>
                    <div class=" labels-details-ev">
                        <h2> Date de début : </h2>
                        <h2 class="details-ev"> $date_deb</h2>
                    </div>
                    <div class=" labels-details-ev">
                        <h2> Date de fin : </h2>
                        <h2 class="details-ev"> $date_fin </h2>
                    </div>
                    
                    <div class=" labels-details-ev">
                        <h2> Propriétaire: </h2>
                        <h2 class="details-ev"> $proprio_prenom $proprio_nom </h2>
                    </div>
                    
                    <div class=" labels-details-ev">
                        <h2> Lieu : </h2>
                        <h2 class="details-ev"> $ville </h2>
                    </div>
                    </div>

            </div>
            </div>
         
              
            </section>
            <section class=" desc">
            <div class="container"> 
                <h3>Description: </h3>

                <div class="evenement"> 
                    <p> $desc </p> 
                </div>
            </div>
            
            </section>
       
            <div class="container lien-liste">
                <p> Il y a $nb_participants $participant_s à cet événement. <a href="#" class="lien-p"> Consulter la liste ici.</a> </div> </p>
            </div>                
        </section>
        <section >

         <div class = "container ">
             <div class = "tab-param">
                <div class="clearfix"></div>
    
                <div class="tabBesoin-div">
                    $tab
                </div>
               
                <div class="param-buttons">
                    $boutons
                </div>
                <div class="clearfix"/>

            </div>
            <div class="clearfix"/>
        </div>
        </section>
            
FIN;
        return $html;
    }


}