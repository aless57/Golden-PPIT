<?php

namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

class participant extends Model
{

    protected $table = 'participant';
    protected $primaryKey = ['p_user', 'p_event'];
    public $timestamps = false;

}