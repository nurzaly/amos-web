<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DB;
use App;

class AssetsResource extends JsonResource
{
  /**
  * Transform the resource into an array.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return array
  */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'no_siri_pendaftaran' => strtoupper($this->no_siri_pendaftaran),
      'barcode' => $this->barcode,
      'kategori' => $this->kategori,
      'sub_kategori' => $this->sub_kategori,
      'jenis' => $this->jenis ?? "",
      'jenis_aset' => $this->jenis_aset,
      'no_casis' => $this->no_casis,
      'pegawai' => ucwords($this->pegawai),
      'kod_lokasi' => $this->kod_lokasi,
      'tarikh_beli' => $this->tarikh_beli,
      'jenama_model' => $this->jenama_model,
      'harga_seunit' => 'RM' . $this->harga_seunit,
      'verification_id' => $this->asset_id ?? null,
      'lokasi' => $this->get_short_name($this->kod_lokasi) ?? null,
    ];
  }

  private function get_update_spa($value){
    if(empty($value)){
      return null;
    }
    return \Carbon\Carbon::parse($value)->format('d-m-yy h:i A');
  }

  private function get_no_casis($no_casis){
    if(filled($no_casis)) return " - no. casis : " . $no_casis;
  }

  private function get_short_name($kod_lokasi){
    $r =  App\Locations::where('location_code',$kod_lokasi)
    ->select(
      'block_code',
      'block_name',
      'location_name',
      'short_name'
      )
    ->first();
    @$r->level = explode("/",$kod_lokasi)[3];
    //return $r->block_code . explode('/',$kod_lokasi)[3] . ' - ' . $r->block_name;
    return $r ?? null;
  }

  private function get_pegawai_name($email){

    $staf = DB::connection('mysql2')
    ->table('direktori')
    ->where('email',$email)
    ->value('nama');

    return $staf;
  }






}
