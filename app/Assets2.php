<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assets2 extends Model
{
    protected $table = 'assets2';

    protected $fillable = [
        'no_siri_pendaftaran', 'barcode', 'kategori','sub_kategori','jenis','butiran','no_casis', 'kod_lokasi','pegawai','jenis_aset', 'status','harga_seunit','page','bil','tarikh_beli','jenama_model'
    ];
    //protected $connection = 'mysql2';
    //public $timestamps = false;

}
