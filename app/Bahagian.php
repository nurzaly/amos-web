<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bahagian extends Model
{
    protected $table = 'bahagian';
    protected $connection = 'mysql2';
    public $timestamps = false;

    public static function getBahagian($tag){
      return self::where('tag',$tag)->first()->nama_bahagian;
    }
}
