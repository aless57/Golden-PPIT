<?php

namespace goldenppit\views;

class VueAccueil{

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
    public function render( int $select ) : string
    {
        $url_formConnexion = $this->container->router->pathFor( 'formConnexion' ) ;
        $url_formInsription = $this->container->router->pathFor( 'formInscription' ) ;
        switch ($select){
            case 0:
            {
            $content = <<<FIN
<a href="$url_formConnexion"> Form Connexion </a>
<a href="$url_formInsription"> Form Inscription </a>
FIN;

            }
        }
        $html =<<<FIN
<html>

<head>
    <title>GoldenPPIT</title>
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
