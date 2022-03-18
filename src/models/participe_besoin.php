<?php

namespace goldenppit\models;

use goldenppit\traits\CompsitePrimaryKeyTrait;
use Illuminate\Database\Eloquent\Model;

class participe_besoin extends Model
{
    use CompsitePrimaryKeyTrait;
    protected $table = 'participe_besoin';
    protected $primaryKey = ['pb_user', 'pb_besoin'];
    public $timestamps = false;
    public $incrementing = false;

}