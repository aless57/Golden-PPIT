<?php

namespace goldenppit\controllers;
use \goldenppit\models\utilisateur;
use \goldenppit\models\ville;

/**
 * Class Authentication
 * @package goldenppit\controllers
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
    public static function createUser($mail, $password, $nom, $prenom, $date_naissance, $tel, $photo, $notif_mail, $ville) {
        $nb = Utilisateur::where('u_mail','=',$mail)->count();
        if ($nb == 0) {
            $u = new Utilisateur();
            $u->u_mail = $mail;
            $u->u_mdp = password_hash($password, PASSWORD_DEFAULT);
            $u->u_nom = $nom;
            $u->u_prenom = $prenom;
            $u->u_naissance = $date_naissance;
            $u->u_tel = $tel;
            $u->u_photo = $photo;
            $u->u_notif_mail = $notif_mail;
            $u->u_statut = "membre";
            //A modif
            //$u->u_ville = Ville::where('v_nom','LIKE',$ville)->first()->v_id;
            $u->u_ville = $ville;
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
        $u = Utilisateur::where('u_mail','LIKE',$mail)->first();
        if(gettype($u) != 'NULL'){
            $res = password_verify($password, $u->u_mdp);
        }else{
            $res = false;
        }
        if ($res){
            self::loadProfile($u->u_mail);
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
        $_SESSION['profile'] = array('user' => Utilisateur::where('u_mail','=',$mail)->first()->login, 'mail' => $mail);
    }

    public static function checkAccessRights($required) {}

}
