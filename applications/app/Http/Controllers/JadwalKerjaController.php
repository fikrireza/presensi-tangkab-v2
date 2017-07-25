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

class JadwalKerjaController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }

    /** START JADWAL KERJA **/
    public function index()
    {
      $getSKPD = JadwalKerja::get();

      return view('pages.jadwalkerja.jadwal', compact('getSKPD'));
    }

    public function jadwalTambah()
    {
      $getSKPD = Skpd::get();
      $jamKerja = JamKerja::get();

      return view('pages.jadwalkerja.jadwalTambah', compact('getSKPD', 'jamKerja'));
    }

    public function jadwalPost(Request $request)
    {
      $message = [
        'skpd_id.required' => 'Wajib di isi',
        'periode_akhir.required' => 'Wajib di isi',
        'periode_awal.required' => 'Wajib di isi',
      ];

      $validator = Validator::make($request->all(), [
        'skpd_id' => 'required',
        'periode_akhir' => 'required',
        'periode_awal' => 'required',
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('jadwal-kerja.tambah')->withErrors($validator)->withInput();
      }

      $set = new JadwalKerja;
      $set->skpd_id = $request->skpd_id;
      $set->periode_awal = $request->periode_awal;
      $set->periode_akhir = $request->periode_akhir;
      $set->jadwal_1 = $request->senin;
      $set->jadwal_2 = $request->selasa;
      $set->jadwal_3 = $request->rabu;
      $set->jadwal_4 = $request->kamis;
      $set->jadwal_5 = $request->jumat;
      $set->jadwal_6 = $request->sabtu;
      $set->jadwal_7 = $request->minggu;
      $set->flag_status = 1;
      $set->actor = Auth::user()->pegawai_id;
      $set->save();

      return redirect()->route('jadwal-kerja')->with('berhasil', 'Berhasil Menambahkan Jadwal Kerja');

    }

    public function jadwalUbah($id)
    {
      $getJadwal = JadwalKerja::find($id);
      $getSKPD = Skpd::get();
      $jamKerja = JamKerja::get();

      return view('pages.jadwalkerja.jadwalEdit', compact('getJadwal', 'getSKPD', 'jamKerja'));

    }

    public function jadwalEdit(Request $request)
    {
      $message = [
        'skpd_id.required' => 'Wajib di isi',
        'periode_akhir.required' => 'Wajib di isi',
        'periode_awal.required' => 'Wajib di isi',
      ];

      $validator = Validator::make($request->all(), [
        'skpd_id' => 'required',
        'periode_akhir' => 'required',
        'periode_awal' => 'required',
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('jadwal-kerja.tambah')->withErrors($validator)->withInput();
      }

      $set = JadwalKerja::find($request->id);
      $set->skpd_id = $request->skpd_id;
      $set->periode_awal = $request->periode_awal;
      $set->periode_akhir = $request->periode_akhir;
      $set->jadwal_1 = $request->senin;
      $set->jadwal_2 = $request->selasa;
      $set->jadwal_3 = $request->rabu;
      $set->jadwal_4 = $request->kamis;
      $set->jadwal_5 = $request->jumat;
      $set->jadwal_6 = $request->sabtu;
      $set->jadwal_7 = $request->minggu;
      $set->flag_status = $request->flag_status;
      $set->actor = Auth::user()->pegawai_id;
      $set->update();

      return redirect()->route('jadwal-kerja')->with('berhasil', 'Berhasil Mengubah Jadwal Kerja');
    }

    /** START JADWAL KERJA **/


    /** START JAM KERJA GROUP **/
    // public function jamGroup()
    // {
    //   $getJamGroup = JamKerjaGroup::where('flag_status', 1)->groupBy('group_id')->get();
    //   $getJamKerja = JamKerja::with('groupJamKerja')->where('flag_status', 1)->get();
    //   // dd($getJamKerja);
    //   return view('pages.jadwalkerja.jamkerjagroup', compact('getJamGroup'));
    // }
    //
    // public function jamGroupAdd()
    // {
    //   $getJamKerja = JamKerja::get();
    //
    //   return view('pages.jadwalkerja.jamkerjagroupAdd', compact('getJamKerja'));
    // }
    //
    // public function jamGroupPost(Request $request)
    // {
    //   $message  = [
    //     'nama_group.required'  => 'Wajib di isi',
    //   ];
    //
    //   $validator = Validator::make($request->all(), [
    //     'nama_group'  => 'required',
    //   ], $message);
    //
    //   if($validator->fails()){
    //     return redirect()->route('jadwal-kerja.tambahgroup')->withErrors($validator)->withInput();
    //   }
    //
    //   $group = JamKerjaGroup::select('group_id')->max('group_id');
    //   if($group == null){
    //     $group += 1;
    //   }else{
    //     $group += 1;
    //   }
    //
    //   DB::transaction(function() use($request, $group) {
    //     $jamKerja = $request->input('jamKerja');
    //     if($jamKerja != ""){
    //       foreach($jamKerja as $jam){
    //         if($jam['jam_kerja_id'] != null){
    //           $create = new JamKerjaGroup;
    //           $create->nama_group   = $request->nama_group;
    //           $create->group_id     = $group;
    //           $create->jam_kerja_id = $jam['jam_kerja_id'];
    //           $create->flag_status = 1;
    //           $create->actor = Auth::user()->pegawai_id;
    //           $create->save();
    //         }
    //       }
    //     }
    //   });
    //
    //   return redirect()->route('jadwal-kerja.group')->with('berhasil','Group Jam Kerja Berhasil Ditambah');
    // }
    //
    // public function jamGroupLihat($group_id)
    // {
    //   $lihats = JamKerjaGroup::where('group_id', '=', $group_id)->get();
    //   $getJamKerja = JamKerja::get();
    //
    //   return view('pages.jadwalkerja.jamkerjagroupLihat', compact('lihats', 'getJamKerja'));
    // }
    //
    // public function jamGroupUbah(Request $request)
    // {
    //
    //   DB::transaction(function() use($request) {
    //     $jamKerja = $request->input('jamKerja');
    //     if($jamKerja != ""){
    //       foreach($jamKerja as $jam){
    //         if($jam['jam_kerja_id'] != null){
    //           $create = new JamKerjaGroup;
    //           $create->nama_group   = $request->nama_group;
    //           $create->group_id     = $request->group_id;
    //           $create->jam_kerja_id = $jam['jam_kerja_id'];
    //           $create->flag_status = 1;
    //           $create->actor = Auth::user()->pegawai_id;
    //           $create->save();
    //         }
    //       }
    //     }
    //   });
    //
    //   return redirect()->route('jadwal-kerja.group')->with('berhasil','Group Jam Kerja Berhasil Ditambah');
    // }
    //
    // public function nonAktif($id)
    // {
    //   $set = JamKerjaGroup::find($id);
    //   $set->flag_status = 0;
    //   $set->actor = Auth::user()->pegawai_id;
    //   $set->update();
    //
    //   return redirect()->route('jadwal-kerja.group')->with('berhasil','Group Jam Kerja Berhasil Dinonktif');
    // }
    //
    // public function aktif($id)
    // {
    //   $set = JamKerjaGroup::find($id);
    //   $set->flag_status = 1;
    //   $set->actor = Auth::user()->pegawai_id;
    //   $set->update();
    //
    //   return redirect()->route('jadwal-kerja.group')->with('berhasil','Group Jam Kerja Berhasil Diaktifkan');
    // }
    /** END JAM KERJA GROUP **/

}
