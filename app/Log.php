<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    protected $fillable = [
        'data','tag'
    ];

    public static function info($data,$tag = NULL){
      $log = new Log();
      $log->data = $data;
      $log->tag = $tag;
      $log->save();
    }
    //protected $connection = 'mysql2';
    //public $timestamps = false;

}
