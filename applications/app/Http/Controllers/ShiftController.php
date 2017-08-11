<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pegawai;
use App\Models\Skpd;
use App\Models\Shift;
use App\Models\JamKerja;
use App\Models\JadwalKerja;
use App\Models\JadwalKerjaShift;

use Validator;
use Auth;
use DB;
use Excel;
use Illuminate\Support\Facades\Input;

class ShiftController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
      $getSkpd = skpd::where('flag_shift', 0)->get();

      $skpdShift = skpd::where('flag_shift', 1)->get();

      return view('pages.shift.index', compact('getSkpd', 'skpdShift'));
    }

    public function skpdShift(Request $request)
    {

      $set = skpd::find($request->skpd_id);
      $set->flag_shift = 1;
      $set->update();

      return redirect()->route('shift.index')->with('berhasil', 'SKPD Terpilih Menjadi Shift');
    }

    public function skpdShiftRemove($id)
    {
        $getSkpd = Skpd::find($id);

        if(!$getSkpd){
          return view('errors.404');
        }

        $getSkpd->flag_shift = 0;
        $getSkpd->actor = Auth::user()->id;
        $getSkpd->update();

        return redirect()->route('shift.index')->with('berhasil', 'SKPD Dihapus dari jadwal Shift');
    }

    public function jadwalShift()
    {
      $month = date('m');
      $year = date('Y');

      $start_date = "01-".$month."-".$year;
      $start_time = strtotime($start_date);

      $end_time = strtotime("+1 month", $start_time);

      for($i=$start_time; $i<$end_time; $i+=86400)
      {
        $tanggalBulan[] = date('d-m-Y', $i);

      }

      return view('pages.shift.jadwalShift', compact('tanggalBulan'));
    }

    public function jadwalShiftBulan(Request $request)
    {
      $bulan = explode('-', $request->bulan_shift);

      $month = $bulan[0];
      $year = $bulan[1];

      $start_date = "01-".$month."-".$year;
      $start_time = strtotime($start_date);

      $end_time = strtotime("+1 month", $start_time);

      for($i=$start_time; $i<$end_time; $i+=86400)
      {
        $tanggalBulan[] = date('d-m-Y', $i);
      }

      $pilihBulan = $request->bulan_shift;

      return view('pages.shift.jadwalShift', compact('tanggalBulan', 'pilihBulan'));
    }

    public function jadwalShiftTanggal($tanggal)
    {
      $skpd_id   = Auth::user()->skpd_id;
      // $list = DB::select("SELECT a.nama, a.fid, b.nama_group, c.nama_jam_kerja, d.tanggal, c.jam_masuk, c.jam_pulang
      //                     FROM preson_pegawais a, preson_jam_kerja_group b, preson_jam_kerja c, preson_shift_log d, preson_skpd e
      //                     WHERE b.jam_kerja_id = c.id
      //                     AND d.jam_kerja_id = c.id
      //                     AND d.fid = a.fid
      //                     AND DATE_FORMAT(STR_TO_DATE(d.tanggal,'%Y-%m-%d'), '%d-%m-%Y') = '$tanggal'
      //                     AND a.skpd_id = e.id
      //                     AND a.skpd_id = '$skpd_id'
      //                     group by a.nama
      //                     order by c.nama_jam_kerja asc");

      // $getPegawai = DB::select("SELECT preson_pegawais.nip_sapk, preson_pegawais.nama as nama_pegawai, preson_pegawais.fid from preson_pegawais, preson_strukturals
      //                           WHERE preson_pegawais.fid NOT IN (SELECT fid FROM (preson_shift_log) WHERE DATE_FORMAT(STR_TO_DATE(preson_shift_log.tanggal,'%Y-%m-%d'), '%d-%m-%Y') = '$tanggal')
      //                           AND preson_pegawais.skpd_id = $skpd_id
      //                           AND preson_strukturals.id = preson_pegawais.struktural_id
      //                           AND preson_pegawais.status = 1
      //                           ORDER BY preson_strukturals.nama ASC");
      $getPegawai = DB::select("SELECT preson_pegawais.nip_sapk, preson_pegawais.nama as nama_pegawai, preson_pegawais.fid
                                FROM preson_pegawais
                                WHERE preson_pegawais.fid NOT IN (SELECT fid
                                																	FROM preson_shift_log
                                																	WHERE DATE_FORMAT(STR_TO_DATE(preson_shift_log.tanggal,'%Y-%m-%d'), '%d-%m-%Y') = '$tanggal')
                                AND preson_pegawais.skpd_id = $skpd_id
                                AND preson_pegawais.status = 1
                                ORDER By preson_pegawais.nama ASC");

      $getJadwalKerjaShift = DB::select("SELECT *
                                FROM preson_jadwal_kerja_shift WHERE skpd_id = '$skpd_id'");


      // $getPegawaiKerja = DB::select("SELECT preson_shift_log.id, preson_pegawais.nama, preson_pegawais.nip_sapk, preson_jam_kerja.nama_jam_kerja, preson_jam_kerja.jam_masuk, preson_jam_kerja.jam_pulang FROM preson_shift_log, preson_pegawais, preson_jam_kerja
      //                                 WHERE preson_pegawais.fid = preson_shift_log.fid
      //                                 AND preson_shift_log.jam_kerja_id = preson_jam_kerja.id
      //                                 AND preson_pegawais.skpd_id = $skpd_id
      //                                 AND DATE_FORMAT(STR_TO_DATE(preson_shift_log.tanggal,'%Y-%m-%d'), '%d-%m-%Y') = '$tanggal'");
      $getPegawaiKerja = DB::select("SELECT preson_shift_log.id, preson_pegawais.nama, preson_pegawais.nip_sapk, preson_jadwal_kerja_shift.nama_group
                                    FROM preson_shift_log, preson_pegawais, preson_jadwal_kerja_shift, preson_jam_kerja
                                    WHERE preson_pegawais.fid = preson_shift_log.fid
                                    AND preson_shift_log.jadwal_kerja_shift_id = preson_jadwal_kerja_shift.id
                                    AND preson_pegawais.skpd_id = '$skpd_id'
                                    AND DATE_FORMAT(STR_TO_DATE(preson_shift_log.tanggal,'%Y-%m-%d'), '%d-%m-%Y') = '$tanggal'
                                    GROUP BY preson_pegawais.fid
                                    ORDER By preson_pegawais.nama ASC");

      return view('pages.shift.jadwalShiftTanggal', compact('tanggal','getPegawai','getJadwalKerjaShift','getPegawaiKerja'));
    }

    public function jadwalShiftTanggalStore(Request $request)
    {
      $jumlah = 1;
      foreach ($request->pegawai_fid as $pegawai) {
        $save = new Shift;
        $save->fid = $pegawai;
        $save->jadwal_kerja_shift_id = $request->jadwal_kerja_shift_id;
        $save->tanggal  = $request->tanggal;
        $save->actor = Auth::user()->pegawai_id;
        $save->save();
        $jumlah++;
      }

      $tanggal = date("d-m-Y", strtotime($request->tanggal));

      return redirect()->route('shift.jadwaltanggal', ['tanggal' => $tanggal])->with('berhasil', 'Jadwal Pegawai Berhasil Diinput '.$jumlah);

    }

    public function jadwalShiftUbah($id)
    {
      $getShift = Shift::join('preson_pegawais', 'preson_pegawais.fid', '=', 'preson_shift_log.fid')
                        ->select('preson_shift_log.*', 'preson_pegawais.nama as nama_pegawai', 'preson_pegawais.nip_sapk')
                        ->where('preson_shift_log.id', $id)
                        ->first();

      if($getShift == null){
        abort(404);
      }

      $skpd_id   = Auth::user()->skpd_id;
      $getJadwalKerjaShift = DB::select("SELECT *
                                FROM preson_jadwal_kerja_shift WHERE skpd_id = '$skpd_id'");

      return view('pages.shift.jadwalShiftUbah', compact('getShift', 'getJadwalKerjaShift'));

    }

    public function jadwalShiftEdit(Request $request)
    {
      $set = Shift::find($request->id);
      $set->jadwal_kerja_shift_id = $request->jadwal_kerja_shift_id;
      $set->actor = Auth::user()->pegawai_id;
      $set->keterangan = $request->keterangan;
      $set->update();

      $tanggal = date("d-m-Y", strtotime($request->tanggal));

      return redirect()->route('shift.jadwaltanggal', ['tanggal' => $tanggal])->with('berhasil', 'Jadwal Pegawai '.$request->nama_pegawai.' Berhasil Dirubah');
    }

    public function getUpload()
    {

        return view('pages.shift.uploadShift');
    }

    public function getTemplate(Request $request)
    {
      $bulan = $request->bulan_shift;

      $start_date = "01-".$bulan;
      $start_time = strtotime($start_date);

      $end_time = strtotime("+1 month", $start_time);

      for($i=$start_time; $i<$end_time; $i+=86400)
      {
        $tanggalBulan[] = date('d-m-Y', $i);
      }

      $getPegawai = Pegawai::select('fid', 'nip_sapk', 'nama')
                            ->where('status', 1)
                            ->where('skpd_id', Auth::user()->skpd_id)
                            ->get()
                            ->toArray();

      $getJadwalKerjaShift = JadwalKerjaShift::select('id', 'nama_group')
                                              ->where('skpd_id', Auth::user()->skpd_id)
                                              ->where('flag_status', 1)
                                              ->get()
                                              ->toArray();


      return Excel::create('Shift - '.$bulan, function($excel) use($tanggalBulan, $getPegawai, $getJadwalKerjaShift){
        foreach ($tanggalBulan as $tanggal) {
          $excel->sheet($tanggal, function($sheet) use ($tanggalBulan)
          {
            $sheet->row(1, array('FID', 'Jadwal Kerja'));
            $sheet->cell('A1:B1', function($cell){
              $cell->setFontSize(12);
              $cell->setFontWeight('bold');
              $cell->setAlignment('center');
              $cell->setValignment('center');
            });
            $sheet->setColumnFormat(array(
                                      'A' => '0',
                                      'B' => '0',
                                  ));
            $sheet->setAllBorders('thin');
            $sheet->setFreeze('A1');
          });
        }
        $excel->sheet('List Pegawai', function($sheet) use ($getPegawai)
        {
          $sheet->fromArray($getPegawai, null, 'A3', true);
          $sheet->mergeCells('A1:C2');
          $sheet->row(1, array('List Pegawai SKPD'));
          $sheet->row(3, array('FID','NIP','Nama'));
          $sheet->cell('A1:C2', function($cell){
            $cell->setFontSize(12);
            $cell->setFontWeight('bold');
            $cell->setAlignment('center');
            $cell->setValignment('center');
          });
          $sheet->setAutoFilter('A3:C3');
          $sheet->setAllBorders('thin');
          $sheet->setFreeze('A4');
        });
        $excel->sheet('Jadwal Shift', function($sheet) use ($getJadwalKerjaShift)
        {
          $sheet->fromArray($getJadwalKerjaShift, null, 'A3', true);
          $sheet->mergeCells('A1:B2');
          $sheet->row(1, array('List Jadwal Shift'));
          $sheet->row(3, array('ID','Nama Jadwal Shift'));
          $sheet->cell('A1:B2', function($cell){
            $cell->setFontSize(12);
            $cell->setFontWeight('bold');
            $cell->setAlignment('center');
            $cell->setValignment('center');
          });
          $sheet->setAllBorders('thin');
          $sheet->setFreeze('A4');
        });

      })->download('xlsx');


    }

    public function postTemplate(Request $request)
    {
        if(Input::hasFile('postTemplate'))
        {
    			$path = Input::file('postTemplate')->getRealPath();

          $bulan = $request->upload_bulan_shift;

          $start_date = "01-".$bulan;
          $start_time = strtotime($start_date);

          $end_time = strtotime("+1 month", $start_time);

          for($i=$start_time; $i<$end_time; $i+=86400)
          {
            $tanggalBulan[] = date('d-m-Y', $i);
          }


          foreach ($tanggalBulan as $tanggal)
          {
            $data = Excel::selectSheets($tanggal)->load($path)->get();
            if(!empty($data) && $data->count())
            {
              foreach ($data as $key)
              {
                  $formatTanggal = explode('-', $tanggal);
                  $susunTanggal = $formatTanggal[2].'-'.$formatTanggal[1].'-'.$formatTanggal[0];

                  $save = new Shift;
                  $save->fid = $key->fid;
                  $save->tanggal = $susunTanggal;
                  $save->jadwal_kerja_shift_id = (int)$key->jadwal_kerja;
                  $save->keterangan = 'Upload System Excel';
                  $save->actor  = Auth::user()->pegawai_id;
                  $save->save();
              }
            }else{
              return back()->with('error', 'Harap Pilih File Sesuai Dengan Template Atau Beberapa Data Telah Disimpan');
            }
          }

          return redirect()->route('shift.jadwal')->with('message', 'Berhasil Import Jadwal Shift '.$bulan);

    		}

    }


}
