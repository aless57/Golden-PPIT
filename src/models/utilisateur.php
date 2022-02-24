<?php

namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

class utilisateur extends Model
{

    protected $table = 'utilisateur';
    protected $primaryKey = 'u_mail';
    public $timestamps = false;

}