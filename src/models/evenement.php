<?php


namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

class evenement extends Model
{

    protected $table = 'evenement';
    protected $primaryKey = 'e_id';
    public $timestamps = false;

}
