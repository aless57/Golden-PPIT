<?php

namespace goldenppit\views;

class VueInscription
{
    private $tab;
    private $container;

    /**
     * VueInscription constructor.
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
        $url_formConnexion = $this->container->router->pathFor('formConnexion');
        $url_formInsription = $this->container->router->pathFor('formInscription');
        $url_enregistrerInscription = $this->container->router->pathFor('enregistrerInscription');

        switch ($select) {
            case 0: //L'utilisateur est connecté, on le renvoie sur l'accueil
            {

            }
            case 1 : //L'utilisateur n'est pas connecté, on lui affiche le formulaire d'inscription
            {

            }

        }
        $html = <<<FIN
<html>

<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
<nav>
        <div class ="container">
            <div class="logo">
                <a href="$url_accueil" title="logo">
                    <img src="images/logo-white.png"  alt="Logo">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li> <a href="$url_formConnexion"> Se connecter </a> </li>                    
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </nav>
    <h1 class="text-center">Créer un compte et gérez vos événements en toute tranquilité !</h1>
		<div class = "container ">
		
		<form method="post" action="$url_enregistrerInscription">
			<fieldset class="fieldset">
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
				<input type="tel" name="tel" placeholder="0X XX XX XX XX"/>
				</div>
				
				<div class="field"> 
				E-mail * :
				<input type="email" name="mail" placeholder="exemple@exemple.fr" required="required"/>
				</div>
				
				<div class="field"> 
				Mot de passe * :
				<input type="password" name="mdp" placeholder="**********" required="required"/>
				</div>
				
				<div class="field"> Confirmation de mot de passe * : 
				<input type="password" name="mdpconfirm" placeholder="**********" required="required"/>
				</div>
				
				<div class="field"> Adresse :
				<input type="text" name="adr" placeholder="Votre adresse"/>
				</div>
				
				<div class="field"> Code Postal :
				<input type="text" name="cp" placeholder="Votre code postal" pattern="[0-9]{5}"/>
				</div>
				
				<div class="field"> Département * :
				<input type="text" name="dep" placeholder="Votre département" pattern="[a-zA-z\-\']+" required="required"/>
				</div>
				
				<span class="span text-right"> *  : Champ obligatoire !</span>
			</fieldset>
			<fieldset class="fieldset">
			<div class="field">
			<label class="input-pp"> <img src="images/user-pp.png" alt="pp" class="pp-img"/> 
				<input type="file" alt="photo de profile"  name="photo" placeholder="photo"/>
				</label>
				</div>
				
				<div class="field">
				<label class="cb-label"> Activer les notifications par mail</label>

				<input type="checkbox" name="notif" />
				</div>
				<div class="field">
                <label class="cb-label"> Je veux devenir membre de Golden-PPIT * </label>    
				<input type="checkbox" name="confirminscri" required="required"/>
                </div>
            </fieldset>
            <div class="clearfix"/>
            
			<input type="submit" value="S'inscrire" name="submit" class="bouton-bleu" />
		</form>

    </div>
    
</body>
<footer>
    <div class="container">
                <a href="#" class="text-center"> Nous contacter </a>
                <a href="#" class="text-center"> A propos de nous </a>
                <p class="text-center"> © 2022 GoldenPPIT. Tous droits réservés </p>
    </div>
</footer>
</html>
FIN;

        return $html;
    }
}