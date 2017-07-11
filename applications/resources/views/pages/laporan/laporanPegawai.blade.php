@extends('layout.master')

@section('title')
  <title>Detail Laporan</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
@endsection

@section('content')

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <div class="box-title">
          <p>Pilih Periode</p>
        </div>
      </div>
      <form action="{{ route('laporanPegawai.store')}}" method="POST">
      {{ csrf_field() }}
      <div class="box-body">
        @if(isset($absensi))
        <div class="row">
          <div class="col-xs-6">
            <input type="text" class="form-control" name="start_date" id="start_date" value="{{ $start_dateR }}" placeholder="dd/mm/yyyy" required="">
            <input type="hidden" name="nip_sapk" value="{{ Auth::user()->nip_sapk }}" />
          </div>
          <div class="col-xs-6">
            <input type="text" class="form-control" name="end_date" id="end_date" value="{{ $end_dateR }}" placeholder="dd/mm/yyyy" required="">
          </div>
        </div>
        @else
        <div class="row">
          <div class="col-xs-6">
            <input type="text" class="form-control" name="start_date" id="start_date" value="" placeholder="dd/mm/yyyy" required="">
            <input type="hidden" name="nip_sapk" value="{{ Auth::user()->nip_sapk }}" />
          </div>
          <div class="col-xs-6">
            <input type="text" class="form-control" name="end_date" id="end_date" value="" placeholder="dd/mm/yyyy" required="">
          </div>
        </div>
        @endif
      </div>
      <div class="box-footer">
        <button class="btn btn-block bg-purple">Pilih</button>
        @if (isset($absensi))
          <a href="{{ route('laporan.cetakPegawai', ['download'=>'pdf', 'bulanhitung'=>$bulan, 'nip_sapk'=>$nip_sapk]) }}" class="btn btn-block bg-green">Download PDF</a>
        @endif
      </div>
      </form>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header">
        <h3 class="box-title">Absensi</h3>
      </div>
      <div class="box-body table-responsive">
        @if(isset($absensi))
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Tanggal</th>
              <th class="text-center">Hari</th>
              <th class="text-center">Jam Datang</th>
              <th class="text-center">Jam Pulang</th>
              <th class="text-center" width="40%">Keterangan</th>
            </tr>
          </thead>
          <tbody>
              @php
                $no = 1;
              @endphp

              @foreach ($tanggalBulan as $tanggal)
              <tr>
                <td>{{ $no }}</td>
                <td>{{ $tanggal }}</td>
                @php
                $day = explode('/', $tanggal);
                $day = $day[1]."/".$day[0]."/".$day[2];
                $day = date('D', strtotime($day));

                $dayList = array(
                  'Sun' => 'Minggu',
                  'Mon' => 'Senin',
                  'Tue' => 'Selasa',
                  'Wed' => 'Rabu',
                  'Thu' => 'Kamis',
                  'Fri' => 'Jum&#039;at',
                  'Sat' => 'Sabtu'
                );
                @endphp
                <td>{{ $dayList[$day] }}</td>

                @php
                  $flag=0;
                @endphp

                @foreach ($hariLibur as $lib)
                  @php
                    $holiday = explode('-', $lib->libur);
                    $holiday = $holiday[2]."/".$holiday[1]."/".$holiday[0];
                  @endphp
                  @if($holiday == $tanggal)
                    @php
                      $flag++;
                    @endphp
                    <td colspan="2" align="center">{{ $lib->keterangan }}</td>
                  @endif
                @endforeach

                @php
                    $flaginter = 0;
                @endphp

                @foreach ($absensi as $absen)
                  @if ($absen->tanggal == $tanggal)
                    @php
                      $flag++;
                    @endphp
                    <td align="center">@if($absen->jam_datang != null) {{ $absen->jam_datang }} @else x @endif</td>
                    <td align="center">@if($absen->jam_pulang != null) {{ $absen->jam_pulang }} @else x @endif</td>
                  @endif

                  @if (($dayList[$day] == 'Sabtu') || ($dayList[$day] == 'Minggu'))
                    @php
                      $flag++;
                    @endphp
                    <td colspan="2" align="center">Libur</td>
                    @break
                  @endif
                @endforeach

                @if ($flag==0)
                  @if ($tanggal > date("d/m/Y"))
                    <td align="center">x</td>
                    <td align="center">x</td>
                  @else
                    <td align="center">x</td>
                    <td align="center">x</td>
                  @endif
                @endif

                @foreach ($intervensi as $interv)
                  @php
                  $mulai = explode('-', $interv->tanggal_mulai);
                  $mulai = $mulai[2]."/".$mulai[1]."/".$mulai[0];
                  $akhir = explode('-', $interv->tanggal_akhir);
                  $akhir = $akhir[2]."/".$akhir[1]."/".$akhir[0];

                  $mulai = new DateTime($interv->tanggal_mulai);
                  $akhir   = new DateTime($interv->tanggal_akhir);

                  @endphp

                  @for($i = $mulai; $mulai <= $akhir; $i->modify('+1 day'))
                    @if ($tanggal == $i->format("d/m/Y"))
                        @php
                        $flag++;
                        $flaginter++;
                        @endphp
                      <td align="center"><b>{{ $interv->jenis_intervensi}}</b> | {{ $interv->deskripsi }}</td>
                    @endif
                  @endfor
                @endforeach

                @if ($flaginter==0 && $flag==0)
                <td align="center"><span style="color:red;"><b>Alpa</b></span></td>
                @elseif($flaginter==0)
                  @if (($dayList[$day] == 'Sabtu') || ($dayList[$day] == 'Minggu'))
                    @php
                      $flag++;
                    @endphp
                    <td align="center">Libur</td>
                  @else
                    @foreach ($absensi as $absen)
                      @if ($absen->tanggal == $tanggal)
                        @php
                          $flag++;
                        @endphp

                        @php
                        if (!in_array($absen->tanggal, $tanggalapel)) {
                          $tglnew = explode('/', $absen->tanggal);
                          $tglformat = $tglnew[2].'-'.$tglnew[1].'-'.$tglnew[0];
                          // --- CHECK FRIDAY DATE ---
                          if ((date('N', strtotime($tglformat)) != 5)) {
                            $lower_telatdtg = 80100;
                            $upper_telatdtg = 90100;
                            $lower_plgcepat = 150000;
                            $upper_plgcepat = 160000;
                            $batas_jamdtg = 70000;
                            $batas_jamplg = 190000;

                            if (in_array($absen->tanggal, $ramadhanformatslash)) {
                              $upper_plgcepat = 150000;
                            }

                            $rawjamdtg = $absen->jam_datang;
                            $jamdtg = str_replace(':', '', $rawjamdtg);
                            $rawjamplg = $absen->jam_pulang;
                            $jamplg = str_replace(':', '', $rawjamplg);

                            if ($absen->jam_datang==null || $jamdtg < $batas_jamdtg || $jamdtg > $upper_telatdtg) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensitelat))) {
                                echo "<td align='center'> Alpa </td>";
                              }
                            } else if ($absen->jam_pulang==null || $jamplg > $batas_jamplg) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensipulcep))) {
                                echo "<td align='center'> Alpa </td>";
                              }
                            } else if (($jamdtg > $lower_telatdtg && $jamdtg < $upper_telatdtg) && (($jamplg > $lower_plgcepat && $jamplg < $upper_plgcepat) || $jamplg < $upper_plgcepat)) {
                              $intertelat = 0;
                              $interpulcep = 0;
                              $interbebas = 0;
                              if (in_array($absen->tanggal, $tanggalintervensibebas)) $interbebas++;
                              if (in_array($absen->tanggal, $tanggalintervensitelat)) $intertelat++;
                              if (in_array($absen->tanggal, $tanggalintervensipulcep)) $interpulcep++;
                              if ($interbebas==0) {
                                if ($intertelat==0 && $interpulcep==0) {
                                  echo "<td align='center'> Terlambat & Pulang Cepat </td>";
                                } else if ($intertelat!=0 && $interpulcep==0) {
                                  echo "<td align='center'> Pulang Cepat </td>";
                                } else if ($intertelat==0 && $interpulcep!=0) {
                                  echo "<td align='center'> Terlambat </td>";
                                }
                              }
                            } else if ($jamdtg > $lower_telatdtg && $jamdtg < $upper_telatdtg) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensitelat))) {
                                echo "<td align='center'> Terlambat </td>";
                              }
                            } else if (($jamplg > $lower_plgcepat && $jamplg < $upper_plgcepat) || (($jamdtg > $batas_jamdtg && $jamdtg < $lower_telatdtg) && $jamplg < $upper_plgcepat)) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensipulcep))) {
                                echo "<td align='center'> Pulang Cepat </td>";
                              }
                            }
                          } else {
                            $lower_telatdtg = 73100;
                            $upper_telatdtg = 83100;
                            $lower_plgcepat = 150000;
                            $upper_plgcepat = 160000;
                            $batas_jamdtg = 63000;
                            $batas_jamplg = 190000;

                            if (in_array($absen->tanggal, $ramadhanformatslash)) {
                              $lower_telatdtg = 80100;
                              $upper_telatdtg = 90100;
                              $upper_plgcepat = 153000;
                            }

                            $rawjamdtg = $absen->jam_datang;
                            $jamdtg = str_replace(':', '', $rawjamdtg);
                            $rawjamplg = $absen->jam_pulang;
                            $jamplg = str_replace(':', '', $rawjamplg);

                            if ($absen->jam_datang==null || $jamdtg < $batas_jamdtg || $jamdtg > $upper_telatdtg) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensitelat))) {
                                echo "<td align='center'> Alpa </td>";
                              }
                            } else if ($absen->jam_pulang==null || $jamplg > $batas_jamplg) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensipulcep))) {
                                echo "<td align='center'> Alpa </td>";
                              }
                            } else if (($jamdtg > $lower_telatdtg && $jamdtg < $upper_telatdtg) && (($jamplg > $lower_plgcepat && $jamplg < $upper_plgcepat) || $jamplg < $upper_plgcepat)) {
                              $intertelat = 0;
                              $interpulcep = 0;
                              $interbebas = 0;
                              if (in_array($absen->tanggal, $tanggalintervensibebas)) $interbebas++;
                              if (in_array($absen->tanggal, $tanggalintervensitelat)) $intertelat++;
                              if (in_array($absen->tanggal, $tanggalintervensipulcep)) $interpulcep++;
                              if ($interbebas==0) {
                                if ($intertelat==0 && $interpulcep==0) {
                                  echo "<td align='center'> Terlambat & Pulang Cepat </td>";
                                } else if ($intertelat!=0 && $interpulcep==0) {
                                  echo "<td align='center'> Pulang Cepat </td>";
                                } else if ($intertelat==0 && $interpulcep!=0) {
                                  echo "<td align='center'> Terlambat </td>";
                                }
                              }
                            } else if ($jamdtg > $lower_telatdtg && $jamdtg < $upper_telatdtg) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensitelat))) {
                                echo "<td align='center'> Terlambat </td>";
                              }
                            } else if (($jamplg > $lower_plgcepat && $jamplg < $upper_plgcepat) || (($jamdtg > $batas_jamdtg && $jamdtg < $lower_telatdtg) && $jamplg < $upper_plgcepat)) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensipulcep))) {
                                echo "<td align='center'> Pulang Cepat </td>";
                              }
                            }
                          }
                        } else {
                          $tglnew = explode('/', $absen->tanggal);
                          $tglformat = $tglnew[2].'-'.$tglnew[1].'-'.$tglnew[0];

                          $maxjamdatang = 83100;
                          $upper_telatdtg = 90100;
                          $lower_plgcepat = 150000;
                          $upper_plgcepat = 160000;
                          $batas_jamdtg = 70000;
                          $batas_jamplg = 190000;

                          if (in_array($absen->tanggal, $ramadhanformatslash)) {
                            $upper_plgcepat = 150000;
                          }


                          $rawjamdtg = $absen->jam_datang;
                          $jamdtg = str_replace(':', '', $rawjamdtg);
                          $rawjamplg = $absen->jam_pulang;
                          $jamplg = str_replace(':', '', $rawjamplg);

                          if (in_array($absen->mach_id, $mesinapel)) {
                            if ($absen->jam_datang==null || $jamdtg < $batas_jamdtg || $jamdtg > $upper_telatdtg) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensitelat))) {
                                echo "<td align='center'>Alpa</td>";
                              }
                            } else if ($absen->jam_pulang==null || $jamplg > $batas_jamplg) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensipulcep))) {
                                echo "<td align='center'>Alpa</td>";
                              }
                            } else if ($jamdtg > $maxjamdatang && $jamplg > $upper_plgcepat) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensitelat))) {
                                echo "<td align='center'>Tidak Apel</td>";
                              }
                            } else if ($jamdtg > $maxjamdatang && $jamplg < $upper_plgcepat) {
                              $intertelat = 0;
                              $interpulcep = 0;
                              $interbebas = 0;
                              if (in_array($absen->tanggal, $tanggalintervensibebas)) $interbebas++;
                              if (in_array($absen->tanggal, $tanggalintervensitelat)) $intertelat++;
                              if (in_array($absen->tanggal, $tanggalintervensipulcep)) $interpulcep++;
                              if ($interbebas==0) {
                                if ($intertelat==0 && $interpulcep==0) {
                                  echo "<td align='center'>Terlambat dan Pulang Cepat</td>";
                                } else if ($intertelat!=0 && $interpulcep==0) {
                                  echo "<td align='center'>Pulang Cepat</td>";
                                } else if ($intertelat==0 && $interpulcep!=0) {
                                  echo "<td align='center'>Terlambat</td>";
                                }
                              }
                            } else if ((($jamdtg < $maxjamdatang && $jamdtg > $batas_jamdtg) && $jamplg < $upper_plgcepat) || (($jamdtg < $maxjamdatang && $jamdtg > $batas_jamdtg) && $jamplg==null)) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensipulcep))) {
                                echo "<td align='center'>Pulang Cepat</td>";
                              }
                            }
                          } else {
                            if ($absen->jam_datang==null || $jamdtg < $batas_jamdtg || $jamdtg > $upper_telatdtg) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensitelat))) {
                                echo "<td align='center'>Alpa</td>";
                              }
                            } else if ($absen->jam_pulang==null || $jamplg > $batas_jamplg) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensipulcep))) {
                                echo "<td align='center'>Alpa</td>";
                              }
                            } else if (($jamdtg <= $maxjamdatang || $jamdtg >= $maxjamdatang) && $jamplg > $upper_plgcepat) {
                              if ((!in_array($absen->tanggal, $tanggalintervensibebas)) && (!in_array($absen->tanggal, $tanggalintervensitelat))) {
                                echo "<td align='center'>Tidak Apel</td>";
                              }
                            } else if ($jamdtg > $maxjamdatang && $jamplg < $upper_plgcepat) {
                              $intertelat = 0;
                              $interpulcep = 0;
                              $interbebas = 0;
                              if (in_array($absen->tanggal, $tanggalintervensibebas)) $interbebas++;
                              if (in_array($absen->tanggal, $tanggalintervensitelat)) $intertelat++;
                              if (in_array($absen->tanggal, $tanggalintervensipulcep)) $interpulcep++;
                              if ($interbebas==0) {
                                if ($intertelat==0 && $interpulcep==0) {
                                  echo "<td align='center'>Terlambat dan Pulang Cepat</td>";
                                } else if ($intertelat!=0 && $interpulcep==0) {
                                  echo "<td align='center'>Pulang Cepat</td>";
                                } else if ($intertelat==0 && $interpulcep!=0) {
                                  echo "<td align='center'>Terlambat</td>";
                                }
                              }
                            }
                          }
                        }
                        @endphp
                      @endif
                    @endforeach
                  @endif
                @endif
              </tr>
              @php
                $no++
              @endphp
              @endforeach
            </tr>
            @php
            $no++
            @endphp
          </tbody>
        </table>

        @else
        <table class="table table-bordered">
          <thead>
            <tr>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Hari</th>
                <th class="text-center">Jam Datang</th>
                <th class="text-center">Jam Pulang</th>
                <th class="text-center">Keterangan</th>
              </tr>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="18" align="center">Pilih Periode Waktu</td>
            </tr>
          </tbody>
        </table>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$('#start_date').datepicker({
  autoclose: true,
  format: 'dd/mm/yyyy',
  changeMonth: true,
  changeYear: true,
  showButtonPanel: true,
});
$('#end_date').datepicker({
  autoclose: true,
  format: 'dd/mm/yyyy',
  changeMonth: true,
  changeYear: true,
  showButtonPanel: true,
});

</script>
@endsection
