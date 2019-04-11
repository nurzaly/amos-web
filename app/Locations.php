<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    //

    protected $table = 'location';
    public $timestamps = false;

    public static function get_location_info($kod_lokasi){
      return self::where('location_code', $kod_lokasi)->first();
    }

    public static function get_location_name($code, $code_asal = NULL){
      if(blank($code)) return;

      $q =  self::where('location_code',$code);
      if($q->count() == 0) return "No location found" . $code;

      $loc = $q->select('short_name','level','block_code','location_name')->first();
      $level = $loc->level ?? "";
      return $loc->block_code.$level.'-'.$loc->short_name.', '.$loc->location_name;
    }

    public static function get_block_name($block_code){
      return self::where('block_code',$block_code)->pluck('block_name')[0];
    }

    public static function get_pegawai($short_name, $type){
      @$r = PegawaiPemeriksa::where('short_name',$short_name)->pluck('pemeriksa_'.$type)[0];
      return $r;
    }

    public static function get_aset_search_key($short_name){
      $location = self::where('short_name',$short_name)->first();
      $search_key = $location->block_code;
      if($location->aset !== null){
        $search_key = $location->aset;
      }

      return $search_key;
    }
}
