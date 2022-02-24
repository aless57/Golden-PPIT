<?php

namespace goldenppit\controllers;
use \goldenppit\models\Utilisateur;

/**
 * Class Authentication
 * @author Alessi
 * @package boissons\controls
 */
class Authentification {
    /**
     * Fonction de création de USer
     * @param $nom
     * @param $prenom
     * @param $username
     * @param $password
     * @throws \Exception
     */
    public static function createUser($mail, $password, $nom, $prenom, $sexe, $date_naissance, $tel, $photo, $notif_mail) {
        $nb = Utilisateur::where('mail','=',$mail)->count();
        if ($nb == 0) {
            $u = new Utilisateur();
            $u->mail = $mail;
            $u->mdp = password_hash($password, PASSWORD_DEFAULT);
            $u->nom = $nom;
            $u->prenom = $prenom;
            $u->sexe = $sexe;
            $u->date_naissance = $date_naissance;
            $u->tel = $tel;
            $u->photo = $photo;
            $u->notif_mail = $notif_mail;
            $u->statut = "membre";
            $u->id_ville = 1;//TODO
            $u->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fonction de vérification d'authentification
     * @param $mail
     * @param $password
     * @return bool
     */
    public static function authenticate($mail, $password) {
        $u = Utilisateur::where('mail','LIKE',$mail)->first();
        if(gettype($u) != 'NULL'){
            $res = password_verify($password, $u->mdp);
        }else{
            $res = false;
        }
        if ($res){
            self::loadProfile($u->login);
        }
        return $res;
    }

    /**
     * Fonction pour stocker le profile dans la variable de session
     * @param $mail
     */
    private static function loadProfile($mail) {
        session_destroy();
        $_SESSION = [];
        session_start();
        setcookie("mail", $mail, time() + 60*60*24*30, "/" );
        $_SESSION['profile'] = array('user' => Utilisateur::where('mail','=',$mail)->first()->login, 'mail' => $mail);
    }

    public static function checkAccessRights($required) {}

}
