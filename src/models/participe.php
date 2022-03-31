<?php

namespace goldenppit\models;

use goldenppit\traits\CompsitePrimaryKeyTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, mixed $id_ev)
 * @property mixed $p_user
 * @property mixed $p_event
 */
class participe extends Model
{
    use CompsitePrimaryKeyTrait;

    protected $table = 'participe';
    protected $primaryKey = ['p_user', 'p_event'];
    public $timestamps = false;
    public $incrementing = false;

}