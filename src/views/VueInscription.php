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
        switch ($select) {
            case 0:
            {

            }
        }
        $html = <<<FIN
<html>

<head>
    <title>Inscription</title>
</head>

<body>
    <h1>Créer un copte et gérez vos événements en toute tranquilité !</h1>
		<form method="post" action="#">
			<fieldset>
				Nom :
				<input type="text" name="nom" placeholder="Votre nom" pattern="[a-ZA-Z]+" required="required"/><br />
				Prénom :
				<input type="text" name="prenom" placeholder="Votre prénom" pattern="[a-ZA-Z]+" required="required"/><br />
				Date de naissance :
				<input type="date" name="naissance" placeholder="//-//-////" /><br />
				Numéro de téléphone : 
				<input type="text" name="tel" placeholder="0X XX XX XX XX" pattern="0[0-9]{9}"/><br />
				E-mail :
				<input type="text" name="mail" placeholder="exemple@exemple.fr" required="required"/><br />
				Mot de passe :
				<input type="text" name="mdp" placeholder="**********" required="required"/><br />
				Confirmation de mot de passe : 
				<input type="text" name="mdpconfirm" placeholder="**********" required="required"/><br />
				Adresse :
				<input type="text" name="adr" placeholder="Votre adresse"/><br />
				Code Postal :
				<input type="text" name="cp" placeholder="Votre code postal"/><br />
				Département :
				<input type="text" name="dep" placeholder="Votre département" required="required"/><br />
				
				<input type="file" name="photo" placeholder="photo"
				
				</input type="checkbox" name="notif" >
				Activer les notifications par mail
				</input type="checkbox" name="confirminscri" required="required">
				Je veux devenir membre de Golden-PPIT
			</fieldset>
			Champ obligatoire !
			
			<br />
			<input type="submit" value="S'inscrire" name="submit" />
		</form>
    </div>
</body>
</html>
FIN;

        return $html;
    }
}