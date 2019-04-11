<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
use DB;

class Verifications extends Model
{
  protected $fillable = [
      'asset_id', 'kod_lokasi_sebenar', 'status', 'catatan', 'jenis','pemeriksa','updated_at'
  ];


  public function getUpdatedAtAttribute($value){
    return \Carbon\Carbon::parse($value)->diffForHumans();
  }

  public function getKodLokasiSebenarAttribute($value){

    $location = App\Locations::get_location_info($value);
    return ucwords($location->block_code.explode('/',$value)[3].'-'.($location->short_name ?? $location->block_name) . ", " . $location->location_name);
  }

  public static function get_catatan($jenis){
    $catatans = self::where('jenis',$jenis)
    ->groupBy('catatan')
    ->select('catatan')
    ->get();

    $ret = [];
    foreach ($catatans as $v) {
      if(strlen(trim($v->catatan)) > 0){
        $ret[] = $v->catatan;
      }

    }

    return implode(', ', $ret);
  }

  public static function get_status($jenis){
    $status = self::where('jenis',$jenis)
    ->groupBy('status')
    ->select('status',DB::raw('count(status) as total'))
    ->get();

    $ret = [];
    foreach ($status as $v) {
      $ret[] = $v->status . ' - ' . $v->total;
    }

    return implode(', ', $ret);
  }

  public static function check_kemaskini_kewpa11($jenis){
    @$kuantiti_rekod = Assets::where('jenis',$jenis)
    ->groupBy('jenis')
    ->select(DB::raw('count(jenis) as total'))
    //->toSql();
    ->pluck('total')[0];

    @$kuantiti_sebenar = Verifications::where('jenis',$jenis)
    ->groupBy('jenis')
    ->select(DB::raw('count(jenis) as total'))
    //->toSql();
    ->pluck('total')[0];

    if($kuantiti_rekod != $kuantiti_sebenar){
      return false;
    }

    @$lokasi_rekod = Assets::where('jenis',$jenis)
    ->select('id','kod_lokasi')
    ->get();

    foreach($lokasi_rekod as $v){
      $lokasi_sebenar = Verifications::where('asset_id',$v->id)->where('kod_lokasi_sebenar',$v->kod_lokasi)->count();
      if($lokasi_sebenar == 0){
        return false;
      }
    }
    return true;


  }

  public static function get_lokasi_sebenar_inventori($jenis){
    $ret = [];
    $assets = self::where('jenis',$jenis)
    ->groupBy('kod_lokasi_sebenar')
    ->select('kod_lokasi_sebenar', DB::raw('count(kod_lokasi_sebenar) as total'))
    ->get();

    foreach($assets as $v){
      $ret[] = App\Locations::get_location_name($v->getOriginal('kod_lokasi_sebenar')) . "-" . $v->total;
    }

    return implode(', ',$ret);
  }

  public static function get_kuantiti_sebenar($jenis){
    return self::where('jenis',$jenis)
    ->groupBy('jenis')
    ->select(DB::raw('count(jenis) as total'))
    ///->toSql();
    ->pluck('total')[0];
  }
}
