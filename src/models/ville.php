<?php

namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string $v_id
 * @property mixed|string $v_nom
 * @property mixed|string $v_dep
 * @property mixed|string $v_code_postal
 * @method static where(string $string, string $string1, $ville)
 */
class ville extends Model
{

    protected $table = 'ville';
    protected $primaryKey = 'v_id';
    public $timestamps = false;

}