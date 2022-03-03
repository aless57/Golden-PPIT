<?php

namespace goldenppit\views;

class VueModifierCompte
{
    private $tab;
    private $container;

    /**
     * VueModifierCompte constructor.
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
        $url_accueil = $this->container->router->pathFor('racine');
        $url_formInsription = $this->container->router->pathFor('formInscription');
        $url_formConnexion = $this->container->router->pathFor('formConnexion');
        $content = "";

        switch ($select) {
            case 0:
            {
                $content .= $this->formulaireModifierCompte();
                break;
            }
        }

        $html = <<<FIN
<html>

<head>
    <title>GoldenPPIT</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav>
        <div class ="container">
            <div class="logo">
                <a href="$url_accueil" title="logo">
                    <img src="images/logo-white.png" >
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li> <a href="$url_formConnexion"> Se connecter </a></li>
                    <li> <a href="$url_formInsription"> S'inscrire </a> </li>      
                </ul>
            </div>

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

    public function formulaireModifierCompte(): string
    {
        $url_enregistrerModification = $this->container->router->pathFor('enregistrerModifierCompte');
        $html = <<<FIN
<h1 class="text-center">Modifier les informations actuelles de votre compte !</h1>
		<div class = "container ">
		
		<form method="post" action="$url_enregistrerModification">
			<fieldset class="fieldset">
				<div class="field"> 
				    <label> Nom :  </label>
				    <input type="text" name="nom" placeholder="Votre nom" pattern="[a-ZA-Z]+" required="required"/>

                </div>

                <div class="field"> 
				Prénom : 
				<input type="text" name="prenom" placeholder="Votre prénom" pattern="[a-ZA-Z]+" required="required"/>
				
				</div>
				
				<div class="field"> 
				Date de naissance :
				<input type="date" name="naissance" placeholder="XX-XX-XXXX" />
				</div>
				
				<div class="field"> 
				Numéro de téléphone : 
				<input type="tel" name="tel" placeholder="0X XX XX XX XX"/>
				</div>
				
				<div class="field"> 
				Mot de passe actuel * :
				<input type="password" name="mdp" placeholder="**********" required="required"/>
				</div>
				
				<div class="field"> 
				Nouveau mot de passe :
				<input type="password" name="mdp" placeholder="**********" required="required"/>
				</div>
				
				<div class="field"> Confirmation du nouveau mot de passe : 
				<input type="password" name="mdpconfirm" placeholder="**********" required="required"/>
				</div>
				
				<div class="field"> Adresse :
				<input type="text" name="adr" placeholder="Votre adresse"/>
				</div>
				
				<div class="field"> Code Postal :
				<input type="text" name="cp" placeholder="Votre code postal" pattern="[0-9]{5}"/>
				</div>
				
				<div class="field"> Département :
				<input type="text" name="dep" placeholder="Votre département" pattern="[a-zA-z\-\']+" required="required"/>
				</div>
				
				<span class="span text-right"> * : Champ obligatoire pour enregistrer les modifications !</span>
			</fieldset>
			<fieldset class="fieldset">
			<div class="field">
			<label class="input-pp"> <img src="images/user-pp.png" alt="pp" class="pp-img"/> 
				<input type="file" alt="photo de profile"  name="photo" placeholder="photo"/>
				</label>
				</div>
				
				<div class="field">
				<label class="cb-label"> Activer les notifications par mail</label>

				<input type="checkbox" name="notif" value="1"/>
				</div>
            </fieldset>
            <div class="clearfix"/>
            
			<input type="submit" value="Modifier mes informations" name="submit" class="bouton-bleu" />
		</form>

    </div>
    
</body>
FIN;
        return $html;

    }
}