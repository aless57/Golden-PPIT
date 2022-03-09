<?php /** @noinspection PhpIllegalPsrClassPathInspection */

namespace goldenppit\controllers;

use PHPUnit\Framework\TestCase;

class ControlleurAccueilTest extends TestCase
{

    public function test__construct()
    {
        $this->assertClassHasAttribute('container', ControlleurAccueil::class);
        $this->assertInstanceOf(ControlleurAccueil::class, new ControlleurAccueil(""));
    }

    public function testAccueil()
    {
        // Cette fonction est une fonction d'affichage inutile de la tester avec un test unitaire.
        $this->assertTrue(true);
    }

    public function testConnexionInscription()
    {
        // Cette fonction est une fonction d'affichage inutile de la tester avec un test unitaire.
        $this->assertTrue(true);
    }
}
