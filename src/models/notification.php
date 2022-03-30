<?php


namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, mixed $id_not)
 * @method static find(mixed $id_not)
 * @property mixed|string $n_objet
 * @property mixed|string $n_statut
 * @property mixed|string $n_type
 * @property mixed $n_destinataire
 * @property mixed $n_event
 * @property mixed $n_expediteur
 * @property mixed|string $n_contenu
 * @property mixed|string $n_statue
 * @property mixed|string $n_expetideur
 */
class notification extends Model
{

    protected $table = 'notification';
    protected $primaryKey = 'n_id';
    public $timestamps = false;

}
