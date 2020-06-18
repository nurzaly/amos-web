<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PegawaiPemeriksa extends Model
{
    protected $fillable = ['block_code','pemeriksa_1','pemeriksa_2','short_name'];
    protected $table = 'pegawai_pemeriksa';


    public static function get_pegawai_info($email){
      return self::where('pemeriksa_1', $email)->orWhere('pemeriksa_2', $email)->first();
    }
}
