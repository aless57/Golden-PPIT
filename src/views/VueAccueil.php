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
        switch ($select){
            case 0:
            {
            
            }
        }
        $html =<<<FIN
<html>

<head>
    <title>Slat'Koktel</title>
</head>

<body>
    <div class="banner">
        <div class="container">
            <div class="banner-main">
                <br>
                <div class="col-md-6 banner-left">
                    <img src="assets/images/Margarita.jpg" alt="">
                </div>
                <div class="col-md-6 banner-right simpleCart_shelfItem">
                    <h1>Margarita, notre produit phare !</h1>
                    <h5 class="item_price">Savoureux et facile à faire !</h5>
                    <h6>Ce cocktail aurait été créé en 1948 à Acapulco par une Américaine, Margaret Sames, dite «
                        Margarita », et porte comme nom la traduction en espagnol du prénom Margaret.</h6>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
</body>
</html>
FIN;

        return $html;
    }
}
