<?php


namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, mixed $id_not)
 * @method static find(mixed $id_not)
 */
class notification extends Model
{

    protected $table = 'notification';
    protected $primaryKey = 'n_id';
    public $timestamps = false;

}
