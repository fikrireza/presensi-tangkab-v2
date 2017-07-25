<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePresonJadwalKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preson_jadwal_kerja', function(Blueprint $table){
          $table->dropColumn('jam_kerja_group');
          $table->integer('jadwal_1')->after('periode_akhir')->nullable()->unsigned();
          $table->integer('jadwal_2')->after('jadwal_1')->nullable()->unsigned();
          $table->integer('jadwal_3')->after('jadwal_2')->nullable()->unsigned();
          $table->integer('jadwal_4')->after('jadwal_3')->nullable()->unsigned();
          $table->integer('jadwal_5')->after('jadwal_4')->nullable()->unsigned();
          $table->integer('jadwal_6')->after('jadwal_5')->nullable()->unsigned();
          $table->integer('jadwal_7')->after('jadwal_6')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
