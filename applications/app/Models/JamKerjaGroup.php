<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamKerjaGroup extends Model
{
    protected $table = 'preson_jam_kerja_group';

    protected $fillable = ['nama_group', 'group_id', 'jam_kerja_id', 'flag_status'];

    public function jamKerja()
    {
      return $this->belongsTo('App\Models\JamKerja', 'jam_kerja_id');
    }

    public function jadwalkerja()
    {
      return $this->hasMany('App\Models\JadwalKerja', 'group_id');
    }
}
