<?php

namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, $id_b)
 */
class besoin extends Model
{

    protected $table = 'besoin';
    protected $primaryKey = 'b_id';
    public $timestamps = false;

}