<?php

namespace goldenppit\views;

class VueConnexion
{
    private $tab;
    private $container;

    /**
     * VueConnexion constructor.
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
        $content = "";
        switch ($select) {
            case 0:
            {
                $content .= <<<FIN
<body>
    
    <div class=droite>
        <div>
            <div class = "titre_connexion">
            Connexion
            </div>
        <form name="connexion" method="POST" action="">
                <ul>
                    <div class="alignement"> 
                    <li> E-mail :<div class ="box-input">  <input type="text" name="u_mail" placeholder="exemple@exemple.fr"></div></li>
                    </div>
                    <div class="alignement">
                    <li> Mot de passe :<div class ="box-input">  <input type="password" name="u_mdp" placeholder="**********"></div></li>
                    </div>
                    <li> Mot de passe oublié ? <a href="#">Cliquez ici !</a> </li>                    
                </ul>
        
        <button class="bouton-bleu-connexion" type="button" onclick="#">Connexion</button>
        </form>

        </div>
                

                    <img src="images/femmeLogin.png" class="loginFemme">

    </div>
    

</body>
FIN;
            break;
            }
            case 1:
            {
                $content .= "zizi";
                break;
            }
        }

        $html = <<<FIN
<html>

<head>
    <title>Connexion</title>
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
}