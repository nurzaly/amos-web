<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporanKerosakkan extends Model
{
    protected $table = 'laporan_kerosakkan';
    protected $fillable = [
        'barcode', 'perihal', 'pelapor',
    ];

    public function asset(){
      return $this->belongsTo(Assets::class,'barcode','barcode');
    }

    public function staff(){
      return $this->hasOne(Staff::class,'email','email');
    }
}
