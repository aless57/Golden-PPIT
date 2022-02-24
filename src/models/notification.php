<?php


namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{

    protected $table = 'notification';
    protected $primaryKey = 'n_id';
    public $timestamps = false;

}
