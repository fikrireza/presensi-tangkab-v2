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
use DateTime;
use DatePeriod;
use DateIntercal;
use DateInterval;
use Carbon\Carbon;

class JadwalKerjaController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }

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

      // --- check validasi periode jadwal kerja skpd
      $getPeriode = JadwalKerja::select('periode_awal', 'periode_akhir')
                                          ->where('skpd_id', $request->skpd_id)
                                          ->where('flag_status', '=', 1)
                                          ->get();

      $tanggalmulai = $request->periode_akhir;
      $tanggalakhir = $request->periode_akhir;

      $dateRange=array();
      $iDateFrom=mktime(1,0,0,substr($tanggalmulai,5,2), substr($tanggalmulai,8,2), substr($tanggalmulai,0,4));
      $iDateTo=mktime(1,0,0,substr($tanggalakhir,5,2), substr($tanggalakhir,8,2), substr($tanggalakhir,0,4));

      if ($iDateTo>=$iDateFrom)
      {
          array_push($dateRange,date('Y-m-d',$iDateFrom)); // first entry
          while ($iDateFrom<$iDateTo)
          {
              $iDateFrom+=86400; // add 24 hours
              array_push($dateRange,date('Y-m-d',$iDateFrom));
          }
      }

      $flagtanggal = 0;
      foreach ($dateRange as $key) {
        foreach ($getPeriode as $keys) {
          $start_ts = strtotime($keys->periode_awal);
          $end_ts = strtotime($keys->periode_akhir);
          $user_ts = strtotime($key);

          if (($user_ts >= $start_ts) && ($user_ts <= $end_ts)) {
            $flagtanggal=1;
            break;
          }
        }
        if ($flagtanggal==1) break;
      }

      if ($flagtanggal==1) {
        return redirect()->route('jadwal-kerja.tambah')->withErrors($validator)->withInput()->with('gagal', 'Periode ini sudah ada '.$getPeriode[0]->periode_awal.' s/d '.$getPeriode[0]->periode_akhir);
      }
      // --- endcheck validasi periode jadwal kerja skpd

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
        return redirect()->route('jadwal-kerja.ubah', ['id' => $request->id ])->withErrors($validator)->withInput();
      }

      // --- check validasi periode jadwal kerja skpd
      $cek = JadwalKerja::find($request->id);
      if ($request->periode_awal!=$cek->periode_awal || $request->periode_akhir!=$cek->periode_akhir) {
        $getPeriode = JadwalKerja::select('periode_awal', 'periode_akhir')
                                            ->where('skpd_id', $request->skpd_id)
                                            ->where('id', '!=', $request->id)
                                            ->where('flag_status', '=', 1)
                                            ->get();

        $tanggalmulai = $request->periode_awal;
        $tanggalakhir = $request->periode_akhir;

        $dateRange=array();
        $iDateFrom=mktime(1,0,0,substr($tanggalmulai,5,2),     substr($tanggalmulai,8,2),substr($tanggalmulai,0,4));
        $iDateTo=mktime(1,0,0,substr($tanggalakhir,5,2),     substr($tanggalakhir,8,2),substr($tanggalakhir,0,4));

        if ($iDateTo>=$iDateFrom)
        {
            array_push($dateRange,date('Y-m-d',$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($dateRange,date('Y-m-d',$iDateFrom));
            }
        }

        $flagtanggal = 0;
        foreach ($dateRange as $key) {
          foreach ($getPeriode as $keys) {
            $start_ts = strtotime($keys->periode_awal);
            $end_ts = strtotime($keys->periode_akhir);
            $user_ts = strtotime($key);

            if (($user_ts >= $start_ts) && ($user_ts <= $end_ts)) {
              $flagtanggal=1;
              break;
            }
          }
          if ($flagtanggal==1) break;
        }

        if ($flagtanggal==1) {
          return redirect()->route('jadwal-kerja.ubah', ['id' => $request->id ])->withErrors($validator)->withInput()->with('gagal', 'Periode ini sudah ada '.$getPeriode[0]->periode_awal.' s/d '.$getPeriode[0]->periode_akhir);
        }
      }
      // --- endcheck validasi periode jadwal kerja skpd


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

}
