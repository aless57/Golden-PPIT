<?php /** @noinspection DuplicatedCode */

/** @noinspection HtmlUnknownTarget */

namespace goldenppit\views;

class VueCompte
{
    private $tab;
    private $container;

    /**
     * VueConnexion constructor
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
        $url_formInsription = $this->container->router->pathFor('formInscription');
        $url_formConnexion = $this->container->router->pathFor('formConnexion');
        $url_modifierCompte = $this->container->router->pathFor('formModifierCompte');
        $url_menu = $this->container->router->pathFor('accueil');
        $url_deconnexion = $this->container->router->pathFor('deconnexion');
        $content = "";

        if (isset($_SESSION['profile'])) {
            //Si l'utilisateur est connecté
            $bandeau .= <<<FIN
            <div class="menu text-right">
                <div class="logo">
                <a href="$url_menu" title="logo">
                    <img src="images/logo-white.png"  alt="logo">
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
                    <img src="images/logo-white.png"  alt="logo">
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
            //Erreur dans la connexion
            case 5:
            {
                $content .= "<div class=\"alert alert-danger\" role=\"alert\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i> Adresse mail  /  Mot de passe incorrect !</div>";

            }
            //Affichage du formulaire de connexion
            case 0:
            {
                $content .= $this->formulaireConnexion();
                break;
            }
            //Affichage du formulaire d'inscription
            case 1:
            {
                $content .= $this->formulaireInscription();
                break;
            }
            //Affichage du formulaire de mofication de compte
            case 2:
            {
                $content .= $this->formulaireModifierCompte();
                break;
            }
            //Affichage du formulaire du mot de passe oublié
            case 3:
            {
                $content .= $this->formulaireMotDePasseOublie();
                break;
            }
            //Affichage du formulaire de reset du mot de passe
            case 4:
            {
                $content .= $this->formulaireResetMDP();
                break;
            }
        }

        return <<<FIN
    <html lang="french">
    
        <head>
            <title>GoldenPPIT</title>
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
        <footer><div class="clearfix"></div>
            <div class="container text-center">
                    <a href="#"> Nous contacter </a>
                    <a href="#"> A propos de nous </a>
                    <p> © 2022 GoldenPPIT. Tous droits réservés </p>
            </div>    
        
        </footer>
    </html>
FIN;
    }

    /**
     * Formulaire de page de connexion
     * @return string
     */
    public function formulaireConnexion(): string
    {
        $url_connexion = $this->container->router->pathFor('enregisterConnexion');
        $url_motDePasseOublie = $this->container->router->pathFor('formMotDePasseOublie');
        return <<<FIN
    <body>
    <h1 class="text-center">Connexion</h1>
    <div class="clearfix"></div>

    <div class = "container ">
            
        <form name="connexion" method="POST" action="$url_connexion">
            <div class="fieldset-left">
            
                <div class="field"> 
				    Email : 
				    <input type="email" name="u_mail" placeholder="exemple@exemple.fr"/>
			    </div>
			
			    <div class="field"> 
				    Mot de passe : 
				    <input type="password" name="u_mdp" placeholder="***********"/>
			    </div>
			    <div class="text-right">
			    <p class = "p-accueil2">
			    Mot de passe oublié ? <a class="test" href="$url_motDePasseOublie">Cliquez ici !</a>
                </p>
			    <input class="bouton-bleu" type="submit" value="Connexion" >

                </div>
            <div class="clearfix"></div>
            </div>
            
            
            <img src="images/femmeLogin.png" class="loginFemme" alt="femmeLogin">
            <div class="clearfix"></div>
            

        </form>
    
        
        
    
</div>
   
</body>
FIN;

    }

    /**
     * Formulaire de page d'inscription
     * @return string
     */
    public function formulaireInscription(): string
    {
        $url_enregistrerInscription = $this->container->router->pathFor('enregistrerInscription');

        return <<<FIN
        <h1 class="text-center">Créer un compte et gérez vos événements en toute tranquilité !</h1>
		<div class = "container ">
		
	    <form method="post" action="$url_enregistrerInscription">
			<fieldset >
                <div class="field">
                <label class="input-pp"> <img src="images/user-pp.png" alt="pp" class="pp-img"/> 
                <input type="file" alt="photo de profile"  name="photo" placeholder="photo"/>
				</label>
				</div>
				<div class="field"> 
				    <label> Nom * :  </label>
				    <input type="text" name="nom" placeholder="Votre nom" pattern="[a-ZA-Z]+" required="required"/>

                </div>

                <div class="field"> 
				Prénom * : 
				<input type="text" name="prenom" placeholder="Votre prénom" pattern="[a-ZA-Z]+" required="required"/>
				
				</div>
				
				<div class="field"> 
				Date de naissance :
				<input type="date" name="naissance" placeholder="XX-XX-XXXX" />
				</div>
				
				<div class="field"> 
				Numéro de téléphone : 
				<input type="tel" name="tel" placeholder="0XXXXXXXXX"/>
				</div>
				
				<div class="field"> 
				E-mail * :
				<input type="email" name="mail" placeholder="exemple@mail.fr" required="required"/>
				</div>
				
				<div class="field"> 
				Mot de passe * :
				<input type="password" name="mdp" placeholder="**********" required="required"/>
				</div>
				
				<div class="field"> Confirmation de mot de passe * : 
				<input type="password" name="mdpconfirm" placeholder="**********" required="required"/>
				</div>
				
				<div class="field"> Ville :
				<input type="text" name="adr" placeholder="Votre ville"/>
				</div>
				
				<div class="field"> Code Postal :
				<input type="text" name="cp" placeholder="Votre code postal" pattern="[0-9]{5}" />
                </div>
			
				<div class="field"> Activer les notifications par mail  <input type="checkbox" name="notif" value="1" />
				</div>
				<div class="field"> Je veux devenir membre de Golden-PPIT *    
				<input type="checkbox" name="confirminscri" required="required"/>
                </div>
	                <div class="text-right">
                <span class="span "> *  : Champ obligatoire !</span>
				<div class="clearfix"></div>

				<input type="submit" value="S'inscrire" name="submit" class="bouton-bleu" />
				</div>
				<div class="clearfix"></div>

			</fieldset>

            <div class="clearfix"></div>
            
		</form>

    </div>
    
</body>
FIN;
    }

    /**
     * Formulaire de page de modification de compte
     * @return string
     */
    public function formulaireModifierCompte(): string
    {
        $url_accueil = $this->container->router->pathFor('racine');
        $url_enregistrerModification = $this->container->router->pathFor('enregistrerModifierCompte');
        if (isset($_SESSION['profile'])) {
            $nom = $this->tab[0]->u_nom;
            $prenom = $this->tab[0]->u_prenom;
            $naissance = $this->tab[0]->u_naissance;
            $telephone = $this->tab[0]->u_tel;
            $ville = $this->tab[1]->v_nom;
            $notifMail = $this->tab[0]->u_notif_mail;
            //si l'utilisateur est connecté
            $html = <<<FIN
        <h1 class="text-center">Modifier les informations actuelles de votre compte !</h1>
        <div class="container ">
          <form method="post" action="$url_enregistrerModification">
            <fieldset >
                <div class="field">
                <label class="input-pp">
                  <img src="images/user-pp.png" alt="pp" class="pp-img" />
                  <input type="file" alt="photo de profile" name="photo" placeholder="photo" />
                </label>
              </div>
              <div class="field">
                <label> Nom : </label>
                <input type="text" name="nom" placeholder="" pattern="[a-ZA-Z]+" required="required" value="$nom" />
              </div>
              <div class="field"> Prénom : <input type="text" name="prenom" placeholder="" pattern="[a-ZA-Z]+" required="required" value="$prenom" />
              </div>
              <div class="field"> Date de naissance : <input type="date" name="naissance" placeholder="" value="$naissance" />
              </div>
              <div class="field"> Numéro de téléphone : <input type="tel" name="tel" placeholder="" value="$telephone" />
              </div>
              <div class="field"> Mot de passe actuel * : <input type="password" name="mdp" placeholder="**********" required="required" />
              </div>
              <div class="field"> Nouveau mot de passe : <input type="password" name="mdp" placeholder="**********" required="required" />
              </div>
              <div class="field"> Confirmation du mot de passe : <input type="password" name="mdpconfirm" placeholder="**********" required="required" />
              </div>
              <div class="field"> Ville : <input type="text" name="adr" placeholder="" value="$ville" />
              </div>            
              <div class="field"> Activer les notifications par mail : 
                <input type="checkbox" name="notif" value="1" />
              </div>
              <span class="span text-right"> * : Champ obligatoire pour enregistrer les modifications !</span>
              <div class="clearfix"></div>
                <div class="text-right">
                <input type="submit" value="Modifier mes informations" name="submit" class="bouton-bleu " />
                <div class="clearfix"></div>
                </div>
            </fieldset> 
          </form>
        </div>
        FIN;
        } else {
            $html = <<<FIN
    <div class ="message-erreur">
        <h1>Vous devez être connecté pour accéder à cette page !</h1>
        <h2> <a href ="$url_accueil" > Connectez vous ici ! </a> </h2>
    </div>

FIN;
        }
        return $html;
    }

    /**
     * Fomulaire sur la récupération de mot de passe oublié
     * @return string
     */
    public function formulaireMotDePasseOublie(): string
    {
        $url_envoyer = $this->container->router->pathFor('envoyerLien');
        return <<<FIN
    <body>
    <h1 class="text-center">Récupérez votre mot de passe</h1>
    <div class="clearfix"></div>

    <div class = "container ">
            
        <form name="connexion" method="POST" action="#">
            <div class="fieldset-left">
                <div class="text-right">
			    <p class = "p-accueil2">
			    Renseignez votre adresse mail ci-dessous. Un mail vous sera envoyé dans les plus brefs delais !
                </p>
                </div>
                <div class="field"> 
				    Email : 
				    <input type="mail" name="u_mail" placeholder="$url_envoyer"/>
			    </div>
			    <div class="text-right">
			    <p class = "p-accueil2">
			    Si vous n'avez pas reçu de mail, il est possible qu'aucun compte ne soit lié à votre adresse mail ou bien que votre adresse soit bloqué.
                </p>
			    <input class="bouton-bleu" type="submit" value="Envoyer" >

                </div>
            <div class="clearfix"></div>
            </div>
            
            
            <img src="images/femmeLogin.png" class="loginFemme" alt="femmeLogin">
            <div class="clearfix"></div>
            

        </form>
    
        
        
    
</div>
   
</body>
FIN;

    }

    /**
     * Formulaire sur la recréation du mot de passe
     * @return string
     */
    public function formulaireResetMDP(): string
    {
        $url_envoyer = $this->container->router->pathFor('resetMDP');
        return <<<FIN
<body>
    <h1 class="text-center">Réinitialisé votre mot de passe</h1>
    <div class="clearfix"></div>

    <div class = "container ">
            
        <form name="connexion" method="POST" action="$url_envoyer">
            <div class="fieldset-left">
                <div class="text-right">
			    <p class = "p-accueil2">
			    Renseignez votre nouveau mot de passe ci-dessous
                </p>
                </div>
                <div class="field"> 
				    Mot de passe :
				    <input type="password" name="u_mdp" placeholder=""/>
			    </div>
			
			    <div class="field"> 
				    Confirmation du mot de passe : 
				    <input type="password" name="u_mdpconfirm" placeholder=""/>
			    </div>
			    <div class="text-right">
			    <input class="bouton-bleu" type="submit" value="Valider" >

                </div>
            <div class="clearfix"></div>
            </div>
            
            
            <img src="images/femmeLogin.png" class="loginFemme" alt="femmeLogin">
            <div class="clearfix"></div>
            

        </form>
    
        
        
    
</div>
   
</body>
FIN;

    }
}