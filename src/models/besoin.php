<?php

namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, $id_b)
 * @property mixed $b_desc
 * @property mixed $b_objet
 * @property mixed $b_nombre
 * @property mixed $b_event
 */
class besoin extends Model
{

    protected $table = 'besoin';
    protected $primaryKey = 'b_id';
    public $timestamps = false;

}