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
                $content .= $this->pageEvenement();
                break;
            case 1:

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
                $content = $this->afficherListeParticipant();
                break;
            case 1:
                $content = $this->invitationEvenement();
                break;
            case 2:
                $content = $this->lesBesoins();
                break;
            case 3:
                $content = $this->ajoutBesoin();
                break;
            case 4:
                $content = $this->formulaireModifEvenement();
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
    <div class="clearfix"></div>

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

    public function lesBesoins(): string
    {
        $id_ev = $this->tab[0];
        $nom = $this->tab[1];
        $nb_participants = $this->tab[9];
        $participants = $this->tab[10];
        $url_ajoutBesoin = $this->container->router->pathFor('ajout_besoin', ['id_ev'=> $id_ev]);
        $tab = $this->tabBesoin($nb_participants, $participants, $id_ev);
        $html = <<<FIN
        <h1 class="text-center">Les besoins de $nom</h1>
        <div class="container">
        

            <div class="tabBesoin">
                $tab
            </div>
            <button name="button" class="bouton-blanc" onclick="window.location.href='$url_ajoutBesoin'"> Ajouter un besoin </button>
            <button name="button" class="bouton-blanc" > Associer un besoin </button>
            <button name="button" class="bouton-blanc" > Modifier un besoin </button>
            <button name="button" class="bouton-blanc" > Supprimer un besoin </button>  
</div>
FIN;
        return $html;
    }


    public function ajoutBesoin(): string {
        $url_enregistrerBesoin = $this->container->router->pathFor('enregistrerBesoin', ['id_ev'=> $this->tab[0]]);
        $html = <<<FIN
        <h1 class="text-center">Ajouter un besoin</h1>
        <div class="container">
            <form method="post" action="$url_enregistrerBesoin">
			<fieldset >
				<div class="field"> 
				    <label> Nom * :</label>
				    <input type="text" name="nom" placeholder="Nom du besoin" pattern="[a-ZA-Z]+" required="required"/>
                </div>
				
				<div class="field"> 
				        <label> Nombre * : </label>
                        <div class="quantity buttons_added">
	                    <input type="button" value="-" class="minus" onclick = "dec()">
	                    <input type="number" id = "nb" step="1" min="1" max="" name="nb" value="1" size="4">
	                    <input type="button" value="+" class="plus" onclick="inc()">

                        </div>
  				</div>
				
				<div class="field"> 
				    <label> Description : </label>
				    <input type="text" class="desc" name="desc" placeholder="Description du besoin" />
				</div>
				<span class="span text-right"> * : Champ obligatoire !</span>

			</fieldset>
			
            <div class="clearfix"/>
            
			<input type="submit" value="VALIDER" name="submit" class="bouton-bleu" />
		</form>
</div>
</div>

<script>
function inc() {
  let number = document.getElementById('dec');
  let val = document.getElementById('nb'); 
  val.value = parseInt(val.value) + 1;
}

function dec() {
  let number = document.getElementById('inc');
    let val = document.getElementById('nb'); 
	if (parseInt(val.value) > 0) {
	  val.value = parseInt(val.value) - 1;
  }
}
</script>
FIN;

        return $html;
    }

    public function tabBesoin($nb_participants, $participants, $id_ev): string
    {
        $row = "";
        $besoins_non_associes = Besoin::leftJoin('participe_besoin', function($join) {
            $join->on('besoin.b_id', '=', 'participe_besoin.pb_besoin');
        })
            ->whereNull('participe_besoin.pb_besoin')->get();

        if($besoins_non_associes->count()!=0){
            $column = "";

            for($i=0; $i< $besoins_non_associes->count() ; $i++){
                $nom_besoin = $besoins_non_associes[$i]->b_objet;
                $column .= <<<FIN
                        <td> $nom_besoin </td>
                    FIN;
            }

            $row .= <<<Fin
                    <tr>
                       <td> Besoins non associés: </td>
                       
                      $column
                    </tr>
                Fin;
        }
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

    public function invitationEvenement(): string
    {
        $html = <<<FIN
        <h1>Invitation à un event</h1>

        FIN;
        return $html;
    }

    public function pageEvenement(): string
    {
        $url_quitter = $this->container->router->pathFor('quitterEvenement');
        $id_ev = $this->tab[0];

        $url_supprimer = $this->container->router->pathFor('supprimerEvenement', ['id_ev' => $id_ev]);
        $url_inviter = $this->container->router->pathFor('inviterEvenement', ['id_ev' => $id_ev]);
        $url_besoins = $this->container->router->pathFor('lesBesoins', ['id_ev' => $id_ev]);

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
            $participant_s = "participant";
        }
        if($desc== null){
            $desc = "Le propriétaire n'a pas encore saisi de description pour l'événement !";
        }
        $boutons =
            <<<FIN
                
                <button class="bouton-bleu" onclick="window.location.href='$url_inviter'">Inviter</button>
            FIN;
        if ($proprio == $_SESSION['profile']['mail']) {//si l'utilisateur est propriétaire :
            $listeParticipant = $this->container->router->pathFor('listeParticipant', ['id_ev' => $id_ev]);
            $modifierEvenement = $this->container->router->pathFor('modifierEvenement', ['id_ev' => $id_ev]);
            $boutons .=
                <<<FIN
                    <div class="dropdown">
                      <button class="bouton-bleu">Paramètres</button>
                      <div class="dropdown-content">
                        <span> <a href="$url_besoins">Gérer les besoins</a></span>
                        <span> <a href="$listeParticipant">Gérer les participants</a></span>
                        <span> <a href="$modifierEvenement">Modifier l'événement</a></span>
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
        $tab = $this->tabBesoin($nb_participants, $participants, $id_ev);
        $listeParticipant = $this->container->router->pathFor('listeParticipant', ['id_ev' => $id_ev]);
        //TODO Corriger bug chelou : mb_strpos(): Argument #1 ($haystack) must be of type string, array given
        $html = <<<FIN
        <section class="page-evenement">
            <div class="container ">
                
                
            
            <div class=" details-bg">
                    <div class="img-ev">
                        </div>
                        
                        <div class="info">
                    <div class=" labels-details-ev"> 
                        <h2> Nom de l'événement : </h2>
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
                <p> Il y a $nb_participants $participant_s à cet événement. <a href="$listeParticipant" class="lien-p"> Consulter la liste ici.</a> </div> </p>
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

    public function afficherListeParticipant(): string
    {
        $html = <<<FIN
                <div class = "container">
                
                <h1 class = "text-center"> Liste des participants </h1> 

                    <table class="tabParticipants">
                    <thead>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Adresse mail </th>
                    </thead>
                    <tbody>
             
                    
FIN;
        foreach ($this->tab as $utilisateur){
            $u_nom = utilisateur::where('u_mail','=',"$utilisateur->p_user")->first()->u_nom;
            $u_prenom = utilisateur::where('u_mail','=',"$utilisateur->p_user")->first()->u_prenom;
            $url_exclure = $this->container->router->pathFor('exclureEvenement',['p_user' => $utilisateur->p_user, 'p_event' => $utilisateur->p_event]);
            $html .= <<<FIN
                <tr>
                 <td> $u_nom </td>
                 <td> $u_prenom </td>
                 <td> $utilisateur->p_user</td>
                 <td><button class="bouton-rouge" onclick="window.location.href='$url_exclure'"> Exclure </button> </td>
                </tr>
               
                
            </div>

FIN;
        }

        $html.= "</tbody></table></div>";
        return $html;
    }

    /**
     * Formulaire de modification d'événement
     * @return string
     */
    public function formulaireModifEvenement(): string
    {
        $id_ev = $this->tab[0];
        $url_enregistrerModifEvenement = $this->container->router->pathFor('enregistrerModifEvenement',['id_ev' => $id_ev]);
        $id_ev = $this->tab[0];
        $nom = $this->tab[1];
        $date_deb = $this->tab[2];
        $date_supp = $this->tab[3];
        $date_arch = $this->tab[4];
        $ville = $this->tab[5];
        $desc = $this->tab[6];
        $html = <<<FIN
<h1 class="text-center">Modifier un événement</h1>
		<div class = "container ">
		
		<form method="post" action="$url_enregistrerModifEvenement">
			<fieldset >
				<div class="field"> 
				    <label> Nom * :  </label>
				    <input type="text" name="nom" value = "$nom" pattern="[a-ZA-Z]+" required="required"/>
                </div>
				
				<div class="field"> 
				    <label> Date de début * : </label>
				    <input type="date" name="deb" value = "$date_deb" required="required"/>
				</div>
				
				<div class="field"> 
				    <label> Date d'archivage * : </label>
				    <input type="date" name="archiv" value = "$date_arch"/>
				</div>
				
				<div class="field"> 
				    <label> Date de suppression automatique : </label>
				    <input type="date" name="supprauto" value = "$date_supp" />
				</div>
				
				<div class="field"> 
				    <label> Lieu * : </label>
				    <input type="text" name="lieu" value = "$ville" required="required"/>
				</div>
				
				<div class="field"> 
				    <label> Description : </label>
				    <input type="text" class="desc" name="desc" value = "$desc"/>
				</div>
				
				<span class="span text-right"> *  : Champ obligatoire !</span>
			</fieldset>
			
            <div class="clearfix"/>
            
			<input type="submit" value="Modifier" name="submit" class="bouton-bleu" />
		</form>

    </div>
FIN;
        return $html;
    }
}