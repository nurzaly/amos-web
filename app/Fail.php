<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fail extends Model
{

    protected $fillable = [
        'barcode','page','bil','tag'
    ];

    public static function write($barcode, $page=NULL, $bil=NULL, $tag = NULL){
      $log = new Fail();
      $log->barcode = $barcode;
      $log->page = $page;
      $log->bil = $bil;
      $log->tag = $tag;
      $log->save();
    }
    //protected $connection = 'mysql2';
    //public $timestamps = false;

}
