<?php

namespace goldenppit\controllers;

use goldenppit\models\utilisateur;
use goldenppit\models\ville;

/**
 * Class Authentication
 * @package goldenppit\controllers
 */
class Authentification
{
    /**
     * Fonction de création de User
     * @param $mail
     * @param $password
     * @param $nom
     * @param $prenom
     * @param $date_naissance
     * @param $tel
     * @param $photo
     * @param $notif_mail
     * @param $ville
     * @param $cp
     * @return bool
     */
    public static function createUser($mail, $password, $nom, $prenom, $date_naissance, $tel, $photo, $notif_mail, $ville, $cp): bool
    {
        $nb = Utilisateur::where('u_mail', '=', $mail)->count();
        if ($cp == null) {
            $id_ville = Ville::where('v_nom', '=', $ville)->first()->v_id;
        } else if ($ville == null) {
            $id_ville = Ville::where('v_code_postal', '=', $cp)->first()->v_id;
        } else {
            $id_ville = Ville::where('v_nom', '=', $ville)->where('v_code_postal', '=', $cp)->first()->v_id;
        }

        if ($nb == 0) {
            $u = new Utilisateur();
            $u->u_mail = $mail;
            $u->u_mdp = password_hash($password, PASSWORD_DEFAULT);
            $u->u_nom = $nom;
            $u->u_prenom = $prenom;
            if($date_naissance != null) {
                $u->u_naissance = $date_naissance;
            }
            if($tel != null) {
                $u->u_tel = $tel;
            }
            if($photo != null) {
                $u->u_photo = $photo;
            }
            if($notif_mail != null) {
                $u->u_notif_mail = $notif_mail;
            }
            if(($ville != null || $cp != null) && $id_ville != null) {
                $_SESSION['inscriptionOK'] = "ville";
                $u->u_ville = $id_ville;
            }
            $u->u_statut = "membre";
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
    public static function authenticate($mail, $password): bool
    {
        $u = Utilisateur::where('u_mail', 'LIKE', $mail)->first();
        if (gettype($u) != 'NULL') {
            $res = password_verify($password, $u->u_mdp);
        } else {
            $res = false;
        }
        if ($res) {
            self::loadProfile($mail);
        }
        $_SESSION['inscriptionOK'] = true;
        return $res;
    }

    /**
     * Fonction pour stocker le profile dans la variable de session
     * @param $mail
     */
    private static function loadProfile($mail)
    {
        session_destroy();
        $_SESSION = [];
        session_start();
        $mail = str_replace("%40", "@", $mail);
        setcookie("mail", $mail, time() + 60 * 60 * 24 * 30, "/");
        $_SESSION['profile'] = array('user' => Utilisateur::where('u_mail', '=', $mail)->first()->login, 'mail' => $mail);
    }

}
