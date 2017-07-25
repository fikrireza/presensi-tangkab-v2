<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTableJamKerjaGroupToJamKerjaShift extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preson_jam_kerja_group', function(Blueprint $table){
          $table->dropColumn('group_id');
          $table->dropColumn('jam_kerja_id');
          $table->integer('jadwal1')->after('nama_group')->nullable()->unsigned();
          $table->integer('jadwal2')->after('jadwal1')->nullable()->unsigned();
          $table->integer('jadwal3')->after('jadwal2')->nullable()->unsigned();
          $table->integer('jadwal4')->after('jadwal3')->nullable()->unsigned();
          $table->integer('jadwal5')->after('jadwal4')->nullable()->unsigned();
        });

        Schema::rename('preson_jam_kerja_group', 'preson_jadwal_kerja_shift');
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
