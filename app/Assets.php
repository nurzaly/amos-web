<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App;

class Assets extends Model
{
  protected $fillable = [
      'no_siri_pendaftaran', 'barcode', 'kategori','sub_kategori','jenis','butiran','no_casis', 'kod_lokasi','pegawai','jenis_aset'
  ];

  public static function get_pegawai($email){
    return '[PIC:' . explode('bin',$email)[0] . ']';
  }

  public static function count_assets_by_block($short_name){
    $search_key = Locations::get_aset_search_key($short_name);
    return self::where('kod_lokasi','like','%/'.$search_key.'/%')->count();
  }



  public static function get_no_siri($nosiri, $jenis, $bangunan){
    $last = null;
    $ret = null;
    $temp = null;
    $n = null;
    $list = [];

    $assets = self::where('jenis',$jenis)->where('kod_lokasi','like','%/'.$bangunan.'/%')->orderBy('no_siri_pendaftaran','asc')->pluck('no_siri_pendaftaran');

    foreach($assets as $v){
      $no = last(explode('/',$v));
      $list[] = $no;

    }
    sort($list);

    foreach($list as $v){
      //$no = explode('/',$v);
      $n = $v;
      if(is_numeric($n)){
        if(blank($ret)){
          $ret = $n;
        }
        else{
          if(($n-$last) == 1){
            $temp = $n;
            //$ret .= " - " . $n;
          }
          else{
            if(filled($temp)) $ret .= ' - ' . $temp;
            $ret .= ", " . $n;
            $temp = null;
          }
        }
        $last = $n;
      }
    }
    if(filled($temp)) $ret .= " - " . $last;
    //return $no[0] . '/' . $no[1] . '/' . $no[2] . '/' . $no[3] . '/' . $no[4] . '/' . $ret;
    $nosiri = explode('/',$nosiri);
    unset($nosiri[count($nosiri)-1]);
    return implode('/',$nosiri) . '/' . $ret;
  }

  public static function get_lokasi_rekod($jenis, $bangunan){
    $ret = null;
    $assets = self::where('jenis',$jenis)
    ->where('kod_lokasi','like','%/'.$bangunan.'/%')
    ->groupBy('kod_lokasi')
    ->select('kod_lokasi',DB::raw('count(kod_lokasi) as total'))
    ->get();
    //return $assets;
    $ret = [];
    foreach($assets as $v){
      $ret[] = App\Locations::get_location_name($v->kod_lokasi) . "-" . $v->total;
    }
    $ret = implode(", ",$ret);
    return $ret;
  }

  public static function count_asset($short_name){
    $search_key = App\Locations::get_aset_search_key($short_name);
    //if($short_name == "RUMAH PENGARAH") Log::info(self::where('kod_lokasi','like','%/'.$search_key.'/%')->toSql() . " " . $search_key);
    return self::where('kod_lokasi','like','%/'.$search_key.'/%')->count();
  }

  public static function count_asset_verified($short_name){
    $search_key = App\Locations::get_aset_search_key($short_name);
    $q = self::where('assets.kod_lokasi','like','%/'.$search_key.'/%');
    $q->join('verifications','assets.id','=','verifications.asset_id');

    return $q->count();
  }





}
