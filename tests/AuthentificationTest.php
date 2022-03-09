<?php /** @noinspection PhpIllegalPsrClassPathInspection */

namespace goldenppit\controllers;
require('../../index.php');
use PHPUnit\Framework\TestCase;

class AuthentificationTest extends TestCase
{

    public function testAuthenticate()
    {
        //TODO À Faire
        $authentification = new Authentification();
        $authentification::authenticate("testtest@gmail.com", "azertyuiop");
    }

    public function testCreateUser()
    {
        //TODO À Faire
    }
}
