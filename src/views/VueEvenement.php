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
                $content .=$this->consulterEvenement();
            }
        }

        $html = <<<FIN
<html lang="french">

<head>
    <title>GoldenPPIT</title>
    <link rel="stylesheet" href="css/style.css">
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
    <footer>
    <div class="clearfix"></div>
        <div class="container text-center">
                <a href="#"> Nous contacter </a>
                <a href="#"> A propos de nous </a>
                <p> © 2022 GoldenPPIT. Tous droits réservés </p>
        </div>    
    
    </footer>
</body>
</html>
FIN;

        return $html;
    }

    public function formulaireEvenement(): string
    {
        $url_enregistrerEvenement = $this->container->router->pathFor('enregistrerEvenement' );

        $html = <<<FIN
<h1 class="text-center">Créer un événement</h1>
		<div class = "container ">
		
		<form method="post" action="$url_enregistrerEvenement">
			<fieldset >
				<div class="field"> 
				    <label> Nom * :  </label>
				    <input type="text" name="nom" placeholder="Nom de l'événement" pattern="[a-ZA-Z]+" maxlength="30" required="required"/>
                </div>
				
				<div class="field"> 
				    <label> Date de début * : </label>
				    <input type="date" name="deb" placeholder="03-03-2022" required="required" />
				</div>
				
				<div class="field"> 
				    <label> Date d'archivage * : </label>
				    <input type="date" name="archiv" placeholder="24-04-2022" required="required"/>
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
    
</body>
FIN;
        return $html;
    }


    public function consulterEvenement(): string
    {

        $evenements = "";
        $test = "";
        //TODO chopper les infos à partir de la bdd
        for($i = 0; $i<$this->tab[1]->count(); $i++){
            $test = $this->tab[1][$i]->e_titre;
            $evenements .= <<<FIN
                    <button class="bouton-blanc">$test</button>   
FIN;

        }

        $html = <<<FIN
            <body>
                    <h1 class="text-center"> LES ÉVÉNEMENTS </h1>
                    
                    <div class = "container">
                        $evenements
                    </div>
                    
            </body>
FIN;
        return $html;
    }

}