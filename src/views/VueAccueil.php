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
FIN;

            }
        }
        $html =<<<FIN
<html>

<head>
    <title>GoldenPPIT</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section class="navbar">
            <div class="logo">
                <a href="racine" title="logo">
                    <img src="images/logo.png" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                        <a href="$url_formConnexion"> Se connecter </a>
                    </li>
                    <li>
                        <a href="$url_formInsription"> S'inscrire </a>
                    </li>                    
                </ul>
            </div>

            <div class="clearfix"></div>
    </section>
</body>
</html>
FIN;

        return $html;
    }
}
