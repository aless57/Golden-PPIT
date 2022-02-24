<?php

namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

class souhaite extends Model
{

    protected $table = 'souhaite';
    protected $primaryKey = ['s_notif','s_event'];
    public $timestamps = false;

}