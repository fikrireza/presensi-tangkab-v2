<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKerjaShift extends Model
{
    protected $table = 'preson_jadwal_kerja_shift';

    protected $fillable = ['skpd_id','nama_group','jadwal1','jadwal2','jadwal3','jadwal4','jadwal5','flag_status'];

    public function jadwal_1()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal1');
    }

    public function jadwal_2()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal2');
    }

    public function jadwal_3()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal3');
    }

    public function jadwal_4()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal4');
    }

    public function jadwal_5()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal5');
    }

}
