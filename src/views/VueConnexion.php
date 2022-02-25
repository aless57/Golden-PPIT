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
        //$url_connexion = $this->container->router->pathFor( 'connexion' ) ;
        $content = "";
        switch ($select) {
            case 0:
            {
                $content = <<<FIN
        <h1>Connexion</h1>
    <form name="connexion" method="POST" action="">
        E-mail :<input type="text" name="u_mail" placeholder="exemple@exemple.fr">
        Mot de passe :<input type="password" name="u_mdp" placeholder="**********">
        Mot de passe oublié ? <a href="#">Cliquez ici !</a>
        <input type="submit" value="Connexion">
    </form>
FIN;

            }
            case 1:
            {
                $content = "connexion ok";
            }
            default:
                $content = $select;
        }

        $html = <<<FIN
<html>

<head>
    <title>Connexion</title>
</head>

<body>
$content
    test
</body>
</html>
FIN;

        return $html;
    }
}