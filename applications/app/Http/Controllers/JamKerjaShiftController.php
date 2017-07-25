<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Skpd;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\JadwalKerja;
use App\Models\JadwalKerjaShift;
use App\Models\JamKerja;

use DB;
use Auth;
use Validator;
use DateTime;
use DatePeriod;
use DateIntercal;
use DateInterval;
use Carbon\Carbon;

class JamKerjaShiftController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }

    /** START JAM KERJA GROUP **/
    public function index()
    {
      $getJamGroup = JadwalKerjaShift::orderBy('flag_status', 'desc')->get();

      return view('pages.jadwalkerjaShift.index', compact('getJamGroup'));
    }

    public function tambah()
    {
      $getJamKerja = JamKerja::get();

      return view('pages.jadwalkerjaShift.tambah', compact('getJamKerja'));
    }

    public function store(Request $request)
    {
      $message  = [
        'nama_group.required'  => 'Wajib di isi',
      ];

      $validator = Validator::make($request->all(), [
        'nama_group'  => 'required',
      ], $message);

      if($validator->fails()){
        return redirect()->route('jamkerjaShift.tambah')->withErrors($validator)->withInput();
      }

      $save = new JadwalKerjaShift;
      $save->nama_group = $request->nama_group;
      $save->jadwal1 = $request->jadwal1;
      $save->jadwal2 = $request->jadwal2;
      $save->jadwal3 = $request->jadwal3;
      $save->jadwal4 = $request->jadwal4;
      $save->jadwal5 = $request->jadwal5;
      $save->flag_status = 1;
      $save->actor = Auth::user()->id;
      $save->save();


      return redirect()->route('jamkerjaShift.index')->with('berhasil','Group Shift Berhasil Ditambah');
    }

    public function lihat($id)
    {
      $getJadwalKerjaShift = JadwalKerjaShift::find($id);

      if(!$getJadwalKerjaShift){
        return view('errors.404');
      }

      $getJamKerja = JamKerja::get();

      return view('pages.jadwalkerjaShift.lihat', compact('getJadwalKerjaShift', 'getJamKerja'));
    }

    public function edit(Request $request)
    {

      $update = JadwalKerjaShift::find($request->id);
      $update->nama_group = $request->nama_group;
      $update->jadwal1 = $request->jadwal1;
      $update->jadwal2 = $request->jadwal2;
      $update->jadwal3 = $request->jadwal3;
      $update->jadwal4 = $request->jadwal4;
      $update->jadwal5 = $request->jadwal5;
      $update->flag_status = 1;
      $update->actor = Auth::user()->id;
      $update->update();

      return redirect()->route('jamkerjaShift.index')->with('berhasil','Group Shift Berhasil Dirubah');
    }

    public function nonAktif($id)
    {
      $set = JadwalKerjaShift::find($id);
      $set->flag_status = 0;
      $set->actor = Auth::user()->pegawai_id;
      $set->update();

      return redirect()->route('jamkerjaShift.index')->with('berhasil','Group Shift Berhasil Dinonktif');
    }

    public function aktif($id)
    {
      $set = JadwalKerjaShift::find($id);
      $set->flag_status = 1;
      $set->actor = Auth::user()->pegawai_id;
      $set->update();

      return redirect()->route('jamkerjaShift.index')->with('berhasil','Group Shift Berhasil Diaktifkan');
    }
    /** END JAM KERJA GROUP **/
}
