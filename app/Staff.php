<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'direktori';
    protected $connection = 'mysql2';
    public $timestamps = false;

    public static function get_staf_info($email){

    }
}
