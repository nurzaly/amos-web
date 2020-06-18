<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaporanKerosakkanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_kerosakkan', function (Blueprint $table) {
          $table->increments('id');
          $table->string('barcode',100);
          $table->text('perihal_kerosakkan')->nullable();;
          $table->integer('user_id')->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_kerosakkan', function (Blueprint $table) {
            //
        });
    }
}
