<?php

namespace goldenppit\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $s_event
 * @property mixed $s_user
 */
class souhaite extends Model
{

    protected $table = 'souhaite';
    protected $primaryKey = ['s_notif', 's_event'];
    public $timestamps = false;

}