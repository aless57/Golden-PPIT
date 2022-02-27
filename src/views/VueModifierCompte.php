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
        $url_formConnexion = $this->container->router->pathFor( 'formModifierCompte' ) ;
        $url_formConnexion = $this->container->router->pathFor( 'formConnexion' ) ;
        $url_formInsription = $this->container->router->pathFor( 'formInscription' ) ;
        switch ($select) {
            case 0: 
            {
                $content = <<<FIN
                <section>
                <div class="logo-accueil" >            
                    <img src="images/logo-accueil.png" class="img-logo">
                </div>
                    <div class="text-center">
                        <p class = "p-accueil"> Rejoignez notre communauté et devenez membre de notre association ! </p>
                        <button class="bouton-bleu" type="button" onclick="window.location.href='$url_formInsription'">Créer un compte</button>
                      
                        <p class = "p-accueil2"> Vous avez déjà un compte? <a href="$url_formConnexion"> Connectez-vous!</a> </p>
            
                    <div class="clearfix"></div>
                    </div>
                    
                </section>

FIN;
            }

        }
        $html = <<<FIN
<html>

<head>
    <title>ModifierCompte</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav>  
        <div class ="container">
            <div class="logo">
                <a herf="$url_accueil" title="logo">
                    <img src="images/logo-white.png">
                </a>
            </div>
            <div class="menu text-right">
            
                <ul>
                
                    <li> <a herf="$url_formConnexion"> gggg </a> </li>
                
                </ul>
            </div>


            <div class="clearfix"></div>
        </div>


    </nav>
        <h1 class = "text-center">Modifiez les champs que vous souaitez changer !</h1>
        <div class ="html">
            <div class="body">
            

            
                
                



            </div>
        </div>
    
</body>
</html>
FIN;

        return $html;
    }
}