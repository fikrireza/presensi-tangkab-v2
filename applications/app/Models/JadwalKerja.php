<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKerja extends Model
{
    protected $table = 'preson_jadwal_kerja';

    protected $fillable = ['skpd_id','periode_awal','periode_akhir','jadwal_1','jadwal_2','jadwal_3','jadwal_4','jadwal_5',
                          'jadwal_6','jadwal_7','flag_status', 'actor'];

    public function skpd()
    {
      return $this->belongsTo('App\Models\Skpd', 'skpd_id');
    }

    public function jamKerjaGroup()
    {
      return $this->belongsTo('App\Models\JamKerjaGroup', 'jam_kerja_group');
    }

    public function jamKerjaJadwal_1()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal_1');
    }

    public function jamKerjaJadwal_2()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal_2');
    }

    public function jamKerjaJadwal_3()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal_3');
    }

    public function jamKerjaJadwal_4()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal_4');
    }

    public function jamKerjaJadwal_5()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal_5');
    }

    public function jamKerjaJadwal_6()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal_6');
    }

    public function jamKerjaJadwal_7()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jadwal_7');
    }
}
