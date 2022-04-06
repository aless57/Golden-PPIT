<?php /** @noinspection DuplicatedCode */

namespace goldenppit\views;

class VueEvenement
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
        $url_contact = $this->container->router->pathFor('contact');
        $url_afficherNot = $this->container->router->pathFor('afficherNotifications');


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
            case 0: //page de création d'un événement
            {
                $content .= $this->formulaireEvenement();
                break;
            }
            case 1:
            {
                $content .= $this->pageEvenement();
                break;
            }
            case 2:
            {
                $content .= $this->consulterEvenement();
                break;
            }
            //Calendrier
            case 3:
            {
                $content .= $this->afficherCalendrier();
                break;
            }

        }

        $html = <<<FIN
<html lang="french">

<head>
    <meta charset="utf-8"/>
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

        return $html;
    }

    /**
     * Formulaire de création d'événement
     * @return string
     */
    public function formulaireEvenement(): string
    {
        $url_enregistrerEvenement = $this->container->router->pathFor('enregistrerEvenement');

        $html = <<<FIN
<h1 class="text-center">Créer un événement</h1>
		<div class = "container ">
		
		<form method="post" action="$url_enregistrerEvenement">
			<fieldset >
				<div class="field"> 
				    <label> Nom * :  </label>
				    <input type="text" name="nom" placeholder="Nom de l'événement" pattern="[a-ZA-Z]+" required="required"/>
                </div>
				
				<div class="field"> 
				    <label> Date de début * : </label>
				    <input type="date" name="deb" placeholder="03-03-2022" required="required"/>
				</div>
				
				<div class="field"> 
				    <label> Date d'archivage * : </label>
				    <input type="date" name="archiv" placeholder="24-04-2022" />
				</div>
				
				<div class="field"> 
				    <label> Date de suppression automatique : </label>
				    <input type="date" name="supprauto" placeholder="24-04-2022" />
				</div>
				
				<div class="field"> 
				    <label> Lieu * : </label>
				    <input type="text" name="lieu" placeholder="Lieu de l'évenement" required="required"/>
				</div>
				
				<div class="field"> 
				    <label> Description : </label>
				    <input type="text" class="desc" name="desc" placeholder="Décrivez votre événement en quelques mots !"/>
				</div>
				
				<span class="span text-right"> *  : Champ obligatoire !</span>
			</fieldset>
			
            <div class="clearfix"/>
            
			<input type="submit" value="Créer" name="submit" class="bouton-bleu" />
		</form>

    </div>
FIN;
        return $html;
    }


    public function consulterEvenement(): string
    {

        $evenements = "";
        $html = "";

        $villes = "";
        $tabVilles = [];

        $tabDepartements = [];
        $departements = "";

        //TODO chopper les infos à partir de la bdd
        for ($i = 0; $i < $this->tab[1]->count(); $i++) {
            $test = $this->tab[1][$i]->e_titre;
            $test_2 = $this->tab[1][$i]->e_id;
            $url_event = $this->container->router->pathFor("evenement", ['id_ev' => $test_2]);
            $url_supprimer = $this->container->router->pathFor('supprimerEvenement', ['id_ev' => $this->tab[1][$i]->e_id]);
            $codeVille = $this->tab[1][$i]->e_ville;
            $ville = $this->tab[2][$codeVille]->v_nom;
            if (!in_array($ville, $tabVilles)) {
                $villes .= <<<FIN
                <option class="opt" value="$codeVille">$ville</option>
                
                FIN;
                array_push($tabVilles, $ville);
            }
            $departement = $this->tab[2][$codeVille]->v_dep;
            if (!in_array($departement, $tabDepartements)) {
                $departements .= <<<FIN
                <option class="opt" value="$departement">$departement</option>
                
                FIN;
                array_push($tabDepartements, $departement);
            }


            if ($this->tab[1][$i]->e_proprio == $_SESSION['profile']['mail']) {
                $evenements .= <<<FIN
                
                <div id="$test" class="alignement-centre">
                    <button id="$test_2" name="test" class="liste-ev margin-0" > $test  
                        <img src="images/favourite.png" class="leftBouton" alt="owner"/> 
                        <button onclick="window.location.href='$url_supprimer'" class="transparent"> 
                        <img src="images/exit.png"  alt="delete"/> </button>
                    </button>

                </div>   

               <script>    
                var event = document.getElementById('$test_2');
                
                event.addEventListener('click', function(event) {
                  console.log('$url_event');
                  window.location.href = '$url_event'; 
                  
                }); 
                                   
            </script>
            
            FIN;
            } else {
                $evenements .= <<<FIN
            
                <div id="$test" class="alignement-centre">                    
                    <button id="$test_2" name="test" class="liste-ev margin-0" > $test  
                        <img src="images/black-cat.png" class="leftBouton" alt="NotOwner">
                        
                </div>   
            <script>    
                var event = document.getElementById('$test_2');
                event.addEventListener('click', function(event) {
                    console.log('$url_event')
                    window.location.href = '$url_event'; 
                }); 
                   
            </script>
            
            FIN;

            }
        }


        $html=<<<FIN
            <body>
                    <h1 class="text-center"> LES ÉVÉNEMENTS </h1>
                    
                    <div class="container">
                    <div class = "grid"> 
                   
                        <div class="grid-item">
                            <select id="filtres"  class="filtres" name="filtres">
                                <option class="opt" value="">Choisir un filtre</option>
                                <option class="opt" value="A-Z">A-Z</option>
                                <option class="opt" value="Z-A">Z-A</option>
                                <option class="opt" value="recent">Les plus récents</option>
                                <option class="opt" value="lointain">Les plus lointains</option>
                            </select>
                    </div>

                    <div class="grid-item">
                            <div class="mes-evenements">
                            <label for="proprietaire">Mes événements</label>
                                <input type="checkbox" id="proprietaire" name="proprietaire">
                                
                           </div>  
                    </div>
                    <div class="grid-item">
                        <label for="villes">Par villes :</label>
                        <select id="villes" class="filtres" name="villes">
                            <option class="opt" value="default">Choisir une ville</option>
                            $villes
                        </select>
                        </div>
                    <div class="grid-item">

                        <label for="departements">Par départements :</label>
                        <select id="departements" class="filtres" name="departements">
                            <option class="opt" value="default">Choisir un département</option>
                            $departements
                        </select>
                        </div>
                    <div class="grid-item5">
                        <input type="search" onkeyup="recherche(this.value)" id="recherche" name="recherche" placeholder="Recherche par nom">
                        </div>   
                        
                    </div>
                    
                    </div>
                    
                    <div id="listeEvenements" class = "container">
                        $evenements
                    </div>
                                        </div>

                    <script>
                        var tab = {$this->tab[1]};
                        var tab2 = {$this->tab[2]};
                        tab.forEach(element => {
                            if(element.e_titre.includes('&#39;')) {
                                element.e_titre = element.e_titre.replace('&#39;', "'");
                            }
                        });
                        let sel = document.getElementById("filtres");
                        sel.addEventListener('change', function() {
                            switch(this.value) {
                                case 'A-Z':
                                    tab.sort(function(a,b) {
                                        if(a.e_titre < b.e_titre) { 
                                            return -1;
                                        } else {
                                            return 1;
                                        }
                                    });
                                    var html;
                                    tab.forEach(element => {
                                        html = document.getElementById(element.e_titre).cloneNode(true);
                                        document.getElementById('listeEvenements').removeChild(document.getElementById(element.e_titre));
                                        document.getElementById('listeEvenements').appendChild(html);
                                    }
                                    );
                                break;

                                case 'Z-A':
                                    tab.sort(function(a,b) {
                                        if(a.e_titre < b.e_titre) { 
                                            return 1;
                                        } else {
                                            return -1;
                                        }
                                    });
                                    var html;
                                    tab.forEach(element => {
                                        html = document.getElementById(element.e_titre).cloneNode(true);
                                        document.getElementById('listeEvenements').removeChild(document.getElementById(element.e_titre));
                                        document.getElementById('listeEvenements').appendChild(html);
                                    }
                                    );
                                break;

                                case 'recent':
                                    tab.sort(function(a,b) {
                                        if(a.e_date < b.e_date) { 
                                            return -1;
                                        } else {
                                            return 1;
                                        }
                                    });
                                    var html;
                                    tab.forEach(element => {
                                        html = document.getElementById(element.e_titre).cloneNode(true);
                                        document.getElementById('listeEvenements').removeChild(document.getElementById(element.e_titre));
                                        document.getElementById('listeEvenements').appendChild(html);
                                    }
                                    );
                                break;

                                case 'lointain':
                                    tab.sort(function(a,b) {
                                        if(a.e_date < b.e_date) { 
                                            return 1;
                                        } else {
                                            return -1;
                                        }
                                    });
                                    var html;
                                    tab.forEach(element => {
                                        html = document.getElementById(element.e_titre).cloneNode(true);
                                        document.getElementById('listeEvenements').removeChild(document.getElementById(element.e_titre));
                                        document.getElementById('listeEvenements').appendChild(html);
                                    }
                                    );
                                break;
                                
                                default :
                                    var html;
                                    {$this->tab[1]}.forEach(element => {
                                        html = document.getElementById(element.e_titre).cloneNode(true);
                                        document.getElementById('listeEvenements').removeChild(document.getElementById(element.e_titre));
                                        document.getElementById('listeEvenements').appendChild(html);
                                    })
                                    break;
                                    
                                    
                            }
                        });

                        document.getElementById("proprietaire").addEventListener('change', function() {
                                if(this.checked) {
                                    tab.forEach(element => {
                                        if(element.e_proprio != "{$_SESSION['profile']['mail']}") {
                                            document.getElementById(element.e_titre).style = "display:none";
                                        } 
                                    });
                                } else {
                                    tab.forEach(element => {
                                        document.getElementById(element.e_titre).style = "";
                                    });
                                }
                        });
                        
                        document.getElementById("villes").addEventListener('change', function() {
                            switch(this.value) {
                                case "default":
                                    reset();
                                    document.getElementById('departements').disabled = false;
                                    break;
                                default :
                                    tab.forEach(element => {
                                        if(element.e_ville != this.value) {
                                            document.getElementById(element.e_titre).style = "display:none";
                                        } else {
                                            document.getElementById(element.e_titre).style = "";
                                        }
                                    });
                                    document.getElementById('departements').disabled = true;
                                    break;s
                            }
                            
                        });
                        
                        document.getElementById("departements").addEventListener('change', function() {
                            switch(this.value) {
                                case "default":
                                    reset();
                                    document.getElementById('villes').disabled = false;
                                    break;
                                default :
                                    tab.forEach(element => {
                                        if(tab2[element.e_ville].v_dep != this.value) {
                                            document.getElementById(element.e_titre).style = "display:none";
                                        } else {
                                            document.getElementById(element.e_titre).style = "";
                                        }
                                    });
                                    document.getElementById('villes').disabled = true;
                                    break;
                            }
                        });
                        
                        function recherche(champ) {
                            if(champ == "") {
                               reset() ;
                            } else {
                                tab.forEach(element => {
                                tmp = element.e_titre.toLowerCase();
                                        if(!tmp.includes(champ.toLowerCase(),0)) {
                                            document.getElementById(element.e_titre).style = "display:none";
                                        } else {
                                            document.getElementById(element.e_titre).style = "";
                                        }
                                });
                            }
                            
                        }
                           
                        function reset() {
                            tab.forEach(element => {
                                        html = document.getElementById(element.e_titre).cloneNode(true);
                                        document.getElementById('listeEvenements').removeChild(document.getElementById(element.e_titre));
                                        document.getElementById('listeEvenements').appendChild(html);
                                        document.getElementById(element.e_titre).style = "";
                                    })
                        }
                        
                        
                        
                    </script>
                    
            </body>
            
FIN;
        return $html;
    }

    public function afficherCalendrier(): string
    {

        $html = <<<FIN
<br><br>
<div class="container full-width">
<div id="myCalendar" >
            
</div>

 <script>
        var calendarInstance = new calendarJs( "myCalendar", { 
            exportEventsEnabled: false, 
            showTimesInMainCalendarEvents: false,
            minimumDayHeight: 0,
            manualEditingEnabled: false,
            visibleDays: [ 0, 1, 2, 3, 4, 5, 6 ]
        } );

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
       
        </script>
</div>
FIN;
        foreach ($this->tab as $event) {
            $titre = $event[0]->e_titre;
            $from = $event[0]->e_date;
            $to = $event[0]->e_archive;
            $description = $event[0]->e_desc;
            $location = $event[0]->e_ville;
            $organizerEmailAddress = $event[0]->e_proprio;

            $html .= <<<FIN
<script>

var event = {
            title: '$titre',
            from: new Date('$from'),
            to: new Date('$to'),
            description: '$description',
            location: '$location',
            color : getRandomColor(),
            organizerEmailAddress: '$organizerEmailAddress'
        }
        calendarInstance.addEvent( event );
</script>
FIN;

        }

        return $html;
    }


}