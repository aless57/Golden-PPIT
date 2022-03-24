<?php

namespace goldenppit\views;

class VueInvitationEvenement
{
    private $tab;
    private $container;

    /**
     * VueEvenement constructor.
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
        $html = <<<FIN
<html lang="french">

<head>
    <title>GoldenPPIT</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="src/calendar/calendarjs.css" />
    <script src="src/calendar/calendarjs.js"></script>
</head>

<body>

    <nav>
    <div class = "container">
    
            <div class="clearfix"></div>
        </div>
    </nav>
    <div class = "content-wrap">
    </div>
    </div>
</body>
<footer>
    <div class="clearfix"></div>
        <div class="container text-center">
                <a href="#"> Nous contacter </a>
                <a href="#"> A propos de nous </a>
                <p> © 2022 GoldenPPIT. Tous droits réservés </p>
        </div>    
    
    </footer>
</html>
FIN;

        return $html;
    }
}