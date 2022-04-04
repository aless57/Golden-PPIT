<?php

namespace goldenppit\views;

class VueContact
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
                       <li> <a href="$url_afficherNot"> Notifications </a> </li> 
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
                $content.=$this->formulaireContact();
                break;

            }
            case 1:
                $content .= <<<FIN

<script> alert("Votre message a bien été envoyé, nous vous recontacterons bientôt! ") 
window.location.href = " $url_accueil"</script>
FIN;
        break;
            case 2:
                $content .= <<<FIN

<script> alert("Un problème est survenu, veuillez réessayer. ") 
window.location.href = "#"</script>
FIN;
                break;

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
                <a href="" class="text-center"> Nous contacter </a>
                <a href="#" class="text-center"> A propos de nous </a>
                <p class="text-center"> © 2022 GoldenPPIT. Tous droits réservés </p>
    </div>
    </footer>
</html>
FIN;
    }

    public function formulaireContact() :string{
        $url_envoyer = $this->container->router->pathFor('envoyer');

        $html = <<<FIN
        
         <h1 class="text-center">Contactez-nous !</h1>
         <span ></span>
		<div class = "container ">
		
	    <form method="post" action="$url_envoyer">
			<fieldset>
                
				<div class="field"> 
				    <label> Nom * :  </label>
				    <input type="text" name="nom" placeholder="Votre nom" pattern="[a-ZA-Z]+" required="required"/>

                </div>

                <div class="field"> 
                    <label>Prénom * :  </label>
                    <input type="text" name="prenom" placeholder="Votre prénom" pattern="[a-ZA-Z]+" required="required"/>
				
				</div>
				
				<div class="field"> 
                    <label>E-mail * : </label>
                    <input type="email" name="mail" placeholder="exemple@mail.fr" required="required"/>
				</div>
				<div class="field"> 
                    <label>Message * : </label>
                    <input type="text" class ="desc" name="message" placeholder="..." required="required"/>
				</div>
				 <div class="text-right">
                <span class="span "> *  : Champ obligatoire !</span>
				<div class="clearfix"></div>

				<input type="submit" value="Envoyer" name="submit" class="bouton-bleu" />
				</div>
				
				

			</fieldset>

            <div class="clearfix"></div>
            
		</form>

    </div>

FIN;


        return $html;
    }
}
