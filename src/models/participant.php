<?php

namespace goldenppit\models;

use goldenppit\traits\CompsitePrimaryKeyTrait;
use Illuminate\Database\Eloquent\Model;

class participant extends Model
{
    use CompsitePrimaryKeyTrait;
    protected $table = 'participe';
    protected $primaryKey = ['p_user', 'p_event'];
    public $timestamps = false;
    public $incrementing = false;

}