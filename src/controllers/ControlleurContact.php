<?php
namespace goldenppit\controllers;
use goldenppit\views\VueContact;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ControlleurContact
{
    private $container;

    /**
     * ControlleurEvenement constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }


    public function contact(Request $rq, Response $rs, $args): Response{
        $vue = new VueContact([], $this->container);
        $rs->getBody()->write($vue->render(0));
        return $rs;
    }

    public function envoyerMsg(Request $rq, Response $rs, $args): Response
    {
        $post = $rq->getParsedBody();

        $nom = filter_var($post['nom'], FILTER_SANITIZE_STRING);
        $prenom = filter_var($post['prenom'], FILTER_SANITIZE_STRING);
        $mail = filter_var($post['mail'], FILTER_SANITIZE_STRING);
        $message = filter_var($post['message'], FILTER_SANITIZE_STRING);

        $to = "goldenppit@gmail.com"; // L'adresse à laquelle il faut envoyer

        $subject = "Formulaire contact";
        $content = $prenom . " " . $nom . " a envoyé un message:" . "\n\n" . $message;

        $headers = "De: " . $mail;
        $vue = new VueContact([], $this->container);

        if(mail($to,$subject,$content,$headers)){
            $rs->getBody()->write($vue->render(1));
        }else{
            $rs->getBody()->write($vue->render(2));
        }

        return $rs;
    }
}