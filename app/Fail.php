<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fail extends Model
{

    protected $fillable = [
        'no_siri_pendaftaran','data','tag'
    ];

    public static function write($no_siri_pendaftaran,$data=NULL,$tag = NULL){
      $log = new Fail();
      $log->no_siri_pendaftaran = $no_siri_pendaftaran;
      $log->data = $data;
      $log->tag = $tag;
      $log->save();
    }
    //protected $connection = 'mysql2';
    //public $timestamps = false;

}
