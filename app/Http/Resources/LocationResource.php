<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DB;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
          'id' => $this->id ?? NULL,
          'location_code' => $this->location_code ?? NULL,
          'level' => $this->get_level($this->location_code),
          'short_name' =>  $this->short_name ?? NULL,
          'block_name' =>  $this->block_name ?? NULL,
          'block_code' => $this->block_code ?? NULL,
          'location_name' =>  $this->location_name ?? NULL,
          'total' =>  $this->get_total_asets($this->block_code),
          'pemeriksa_1' =>  $this->get_pegawai_name($this->pemeriksa_1),
          'pemeriksa_2' =>  $this->get_pegawai_name($this->pemeriksa_2),
        ];
    }

    private function get_total_asets($block){
      return \App\Assets::where('kod_lokasi','like','%/'.$block.'/%')->count();
    }

    private function get_level($kod_lokasi){
      return @explode('/',$kod_lokasi)[3];
    }

    private function get_pegawai_name($email){
      if(blank($email)) return NULL;

      $staf = DB::connection('mysql2')
      ->table('direktori')
      ->where('email',$email)
      ->value('nama');

      return $staf;
    }

    private function get_short_name($short_name, $block_name){

      return  $this->short_name ?? $this->block_name;
    }

    private function set_level($code){
      $level = 0;
      switch ($code) {
        case str_contains($code,'/01/'):
          $level = "[G]";
          break;
        case str_contains($code,'/02/'):
          $level = "[L1]";
          break;
        case str_contains($code,'/03/'):
          $level = "[L2]";
          break;
        case str_contains($code,'/04/'):
          $level = "[L3]";
          break;
        case str_contains($code,'/05/'):
          $level = "[L4]";
          break;

      }
      return $level;
    }
}
