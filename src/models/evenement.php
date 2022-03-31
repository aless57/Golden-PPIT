<?php


namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, mixed $nom)
 * @method static find(mixed $id_ev)
 * @property mixed $e_supp_date
 * @property mixed $e_titre
 * @property mixed|string $e_statut
 * @property mixed $e_archive
 * @property mixed $e_proprio
 * @property mixed $e_ville
 * @property mixed $e_id
 * @property mixed $e_date
 * @property mixed $e_desc
 */
class evenement extends Model
{

    protected $table = 'evenement';
    protected $primaryKey = 'e_id';
    public $timestamps = false;

}
