<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Skpd;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\JadwalKerja;
use App\Models\JamKerja;
use App\Models\JamKerjaGroup;

use DB;
use Auth;
use Validator;

class JamKerjaController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }

    public function jamKerja()
    {
      $getJamKerja = JamKerja::join('preson_pegawais', 'preson_pegawais.id', '=', 'preson_jam_kerja.actor')
                              ->select('preson_jam_kerja.*', 'preson_pegawais.nama as actor')
                              ->get();

      return view('pages.jamkerja.jamkerja', compact('getJamKerja'));
    }

    public function jamKerjaTambah()
    {
      return view('pages.jamkerja.jamkerjaAdd');
    }

    public function jamKerjaPost(Request $request)
    {
      $message = [
        'nama_jam_kerja.required' => 'Wajib di isi',
        'jam_masuk.required' => 'Wajib di isi',
        'jam_masuk_awal.required' => 'Wajib di isi',
        'jam_masuk_akhir.required' => 'Wajib di isi',
        'jam_pulang.required' => 'Wajib di isi',
        'jam_pulang_awal.required' => 'Wajib di isi',
        'jam_pulang_akhir.required' => 'Wajib di isi',
        'toleransi_pulcep.required' => 'Wajib di isi',
        'toleransi_terlambat.required' => 'Wajib di isi',
      ];

      $validator = Validator::make($request->all(), [
        'nama_jam_kerja' => 'required',
        'jam_masuk' => 'required',
        'jam_masuk_awal' => 'required',
        'jam_masuk_akhir' => 'required',
        'jam_pulang' => 'required',
        'jam_pulang_awal' => 'required',
        'jam_pulang_akhir' => 'required',
        'toleransi_pulcep' => 'required',
        'toleransi_terlambat' => 'required',
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('jadwal-kerja.tambahjam')->withErrors($validator)->withInput();
      }

      if($request->flag_besok == "on"){
        $flag_besok = 1;
      }else{
        $flag_besok = 0;
      }

      $set = new JamKerja;
      $set->nama_jam_kerja = $request->nama_jam_kerja;
      $set->jam_masuk = $request->jam_masuk;
      $set->jam_masuk_awal = $request->jam_masuk_awal;
      $set->jam_masuk_akhir = $request->jam_masuk_akhir;
      $set->jam_pulang = $request->jam_pulang;
      $set->jam_pulang_awal = $request->jam_pulang_awal;
      $set->jam_pulang_akhir = $request->jam_pulang_akhir;
      $set->toleransi_pulcep = $request->toleransi_pulcep;
      $set->toleransi_terlambat = $request->toleransi_terlambat;
      $set->flag_besok = $flag_besok;
      $set->flag_status = 1;
      $set->actor = Auth::user()->pegawai_id;
      $set->save();

      return redirect()->route('jadwal-kerja.jam')->with('berhasil', 'Berhasil Menambahkan Jam Kerja');
    }

    public function jamKerjaUbah($id)
    {
      $getJamKerja = JamKerja::find($id);

      return view('pages.jamkerja.jamkerjaEdit', compact('getJamKerja'));
    }

    public function jamKerjaEdit(Request $request)
    {
      $message = [
        'nama_jam_kerja.required' => 'Wajib di isi',
        'jam_masuk.required' => 'Wajib di isi',
        'jam_masuk_awal.required' => 'Wajib di isi',
        'jam_masuk_akhir.required' => 'Wajib di isi',
        'jam_pulang.required' => 'Wajib di isi',
        'jam_pulang_awal.required' => 'Wajib di isi',
        'jam_pulang_akhir.required' => 'Wajib di isi',
        'toleransi_pulcep.required' => 'Wajib di isi',
        'toleransi_terlambat.required' => 'Wajib di isi',
      ];

      $validator = Validator::make($request->all(), [
        'nama_jam_kerja' => 'required',
        'jam_masuk' => 'required',
        'jam_masuk_awal' => 'required',
        'jam_masuk_akhir' => 'required',
        'jam_pulang' => 'required',
        'jam_pulang_awal' => 'required',
        'jam_pulang_akhir' => 'required',
        'toleransi_pulcep' => 'required',
        'toleransi_terlambat' => 'required',
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('jadwal-kerja.ubahjam', ['id' => $request->id])->withErrors($validator)->withInput();
      }

      if($request->flag_besok == "on"){
        $flag_besok = 1;
      }else{
        $flag_besok = 0;
      }

      $set = JamKerja::find($request->id);
      $set->nama_jam_kerja = $request->nama_jam_kerja;
      $set->jam_masuk = $request->jam_masuk;
      $set->jam_masuk_awal = $request->jam_masuk_awal;
      $set->jam_masuk_akhir = $request->jam_masuk_akhir;
      $set->jam_pulang = $request->jam_pulang;
      $set->jam_pulang_awal = $request->jam_pulang_awal;
      $set->jam_pulang_akhir = $request->jam_pulang_akhir;
      $set->flag_besok = $flag_besok;
      $set->toleransi_pulcep = $request->toleransi_pulcep;
      $set->toleransi_terlambat = $request->toleransi_terlambat;
      $set->flag_status = 1;
      $set->actor = Auth::user()->pegawai_id;
      $set->update();

      return redirect()->route('jadwal-kerja.jam')->with('berhasil', 'Berhasil Mengubah Jam Kerja');
    }

}
