<?php

namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, $mail)
 * @method static find(mixed $mail)
 * @property mixed $u_mail
 * @property mixed $u_nom
 * @property mixed $u_prenom
 * @property mixed $u_naissance
 * @property false|mixed|string|null $u_mdp
 * @property mixed $u_photo
 * @property mixed $u_tel
 * @property mixed $u_notif_mail
 * @property mixed|string $u_statut
 * @property mixed $u_ville
 */
class utilisateur extends Model
{

    protected $table = 'utilisateur';
    protected $primaryKey = 'u_mail';
    public $timestamps = false;

}