@extends('layout.master')

@section('title')
  <title>Jadwal Jam Kerja SKPD | Presensi Online</title>
@endsection

@section('breadcrumb')
  <h1>Jadwal Kerja SKPD</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active">Jadwal Kerja</li>
  </ol>
@endsection

@section('content')
@if(Session::has('berhasil'))
<script>
  window.setTimeout(function() {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
  }, 2000);
</script>

<div class="row">
  <div class="col-md-12">
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
      <p>{{ Session::get('berhasil') }}</p>
    </div>
  </div>
</div>
@endif

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header">
        <h3 class="box-title">Jadwal Kerja</h3>
        <a href="{{ route('jadwal-kerja.tambah') }}" class="btn bg-blue pull-right">Tambah Jadwal Kerja</a>
        <a href="{{ route('jadwal-kerja.jam') }}" class="btn bg-green pull-right">Lihat Jam Kerja</a>
      </div>
      <div class="box-body table-responsive">
        <table id="table_jadwal_kerja" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>SKPD</th>
              <th>Periode Awal</th>
              <th>Periode Akhir</th>
              <th>Senin</th>
              <th>Selasa</th>
              <th>Rabu</th>
              <th>Kamis</th>
              <th>Jumat</th>
              <th>Sabtu</th>
              <th>Minggu</th>
              @if (session('status') == 'superuser')
              <th>Aktor</th>
              @endif
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td></td>
              <th></th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              @if (session('status') == 'superuser')
              <th></th>
              @endif
              <td></td>
            </tr>
          </tfoot>
          <tbody>
            <?php $no = 1; ?>
            @foreach ($getSKPD as $key)
            <tr>
              <td>{{ $no }}</td>
              <td>{{ $key->skpd->nama }}</td>
              <td>{{ $key->periode_awal }}</td>
              <td>{{ $key->periode_akhir }}</td>
              <td>{{ $key->jadwal_1 ? $key->jamKerjaJadwal_1->jam_masuk .' s/d '. $key->jamKerjaJadwal_1->jam_pulang : '-' }}</td>
              <td>{{ $key->jadwal_2 ? $key->jamKerjaJadwal_2->jam_masuk .' s/d '. $key->jamKerjaJadwal_2->jam_pulang : '-' }}</td>
              <td>{{ $key->jadwal_3 ? $key->jamKerjaJadwal_3->jam_masuk .' s/d '. $key->jamKerjaJadwal_3->jam_pulang : '-' }}</td>
              <td>{{ $key->jadwal_4 ? $key->jamKerjaJadwal_4->jam_masuk .' s/d '. $key->jamKerjaJadwal_4->jam_pulang : '-' }}</td>
              <td>{{ $key->jadwal_5 ? $key->jamKerjaJadwal_5->jam_masuk .' s/d '. $key->jamKerjaJadwal_5->jam_pulang : '-' }}</td>
              <td>{{ $key->jadwal_6 ? $key->jamKerjaJadwal_6->jam_masuk .' s/d '. $key->jamKerjaJadwal_6->jam_pulang : '-' }}</td>
              <td>{{ $key->jadwal_7 ? $key->jamKerjaJadwal_7->jam_masuk .' s/d '. $key->jamKerjaJadwal_7->jam_pulang : '-' }}</td>
              @if (session('status') == 'superuser')
              <td>{{ $key->actor }}</td>
              @endif
              <td><a class="btn btn-xs btn-warning" href="{{ url('jadwal-kerja/ubah').'/'.$key->id }}"><i class="fa fa-edit"></i> Ubah</a>@if ($key->flag_status == 1)
              @if (session('status') == 'administrator' || session('status') == 'superuser')
                <a class="btn btn-xs btn-danger" href="" class="nonaktif" data-toggle="modal" data-target="#myModalNonAktif" data-value="{{ $key->id }}">NonAktif</a>
              @endif
              @else
              @if (session('status') == 'administrator' || session('status') == 'superuser')
                <a href="" class="aktif" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModalAktif" data-value="{{ $key->id }}">Aktifkan</a>
              @endif
              @endif</td>
            </tr>
            <?php $no++; ?>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


@endsection

@section('script')
<script>
  $(function () {
    $("#table_jadwal_kerja").DataTable();
  });
</script>
@endsection
