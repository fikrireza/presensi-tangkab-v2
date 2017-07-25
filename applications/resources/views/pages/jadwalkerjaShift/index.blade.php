@extends('layout.master')

@section('title')
  <title>Group Shift | Presensi Online</title>
@endsection

@section('breadcrumb')
  <h1>Group Shift</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active">Group Shift</li>
  </ol>
@endsection

@section('content')
<script>
  window.setTimeout(function() {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
  }, 2000);
</script>

@if(Session::has('berhasil'))
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

{{-- Modal NonAktif Group Kerja --}}
<div class="modal fade" id="myModalNonAktif" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Non Aktif Group Shift?</h4>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin untuk me-non Aktifkan Group Shift ini?</p>
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
        <a class="btn btn-danger btn-flat" id="setnonaktif">Ya, saya yakin</a>
      </div>
    </div>
  </div>
</div>

{{-- Modal Aktif Group Kerja --}}
<div class="modal fade" id="myModalAktif" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Aktifkan Group Shift?</h4>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin untuk Aktifkan Group Shift ini?</p>
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
        <a class="btn btn-danger btn-flat" id="setaktif">Ya, saya yakin</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header">
        <h3 class="box-title">Group Shift</h3>
        <a href="{{ route('jamkerjaShift.tambah') }}" class="btn bg-blue pull-right">Tambah Group Shift</a>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped" id="table_jadwal_kerja">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Group Shift</th>
              <th>Jadwal 1</th>
              <th>Jadwal 2</th>
              <th>Jadwal 3</th>
              <th>Jadwal 4</th>
              <th>Jadwal 5</th>
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
              <th></th>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tfoot>
          <tbody>
            <?php $no = 1; ?>
            @foreach ($getJamGroup as $key)
            <tr>
              <td>{{ $no }}</td>
              <td>{{ $key->nama_group }}</td>
              <td>{{ $key->jadwal1 ? $key->jadwal_1->jam_masuk .' s/d '. $key->jadwal_1->jam_pulang : '-'}}</td>
              <td>{{ $key->jadwal2 ? $key->jadwal_2->jam_masuk .' s/d '. $key->jadwal_2->jam_pulang : '-'}}</td>
              <td>{{ $key->jadwal3 ? $key->jadwal_3->jam_masuk .' s/d '. $key->jadwal_3->jam_pulang : '-'}}</td>
              <td>{{ $key->jadwal4 ? $key->jadwal_4->jam_masuk .' s/d '. $key->jadwal_4->jam_pulang : '-'}}</td>
              <td>{{ $key->jadwal5 ? $key->jadwal_5->jam_masuk .' s/d '. $key->jadwal_5->jam_pulang : '-'}}</td>
              @if (session('status') == 'superuser')
              <td>{{ $key->actor }}</td>
              @endif
              <td><a class="btn btn-xs btn-warning" href="{{ route('jamkerjaShift.lihat', ['id' => $key->id]) }}"><i class="fa fa-edit"></i> Ubah</a>@if ($key->flag_status == 1)
              @if (session('status') == 'administrator' || session('status') == 'superuser')
                <a href="" class="btn btn-xs btn-danger nonaktif" data-toggle="modal" data-target="#myModalNonAktif" data-value="{{ $key->id }}">NonAktif</a>
              @endif
              @else
              @if (session('status') == 'administrator' || session('status') == 'superuser')
                <a href="" class="btn btn-xs btn-primary aktif" data-toggle="modal" data-target="#myModalAktif" data-value="{{ $key->id }}">Aktifkan</a>
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

$('a.nonaktif').click(function(){
  var a = $(this).data('value');
  $('#setnonaktif').attr('href', "{{ url('/') }}/jadwal-shift-group/non/"+a);
});
$('a.aktif').click(function(){
  var a = $(this).data('value');
  $('#setaktif').attr('href', "{{ url('/') }}/jadwal-shift-group/aktif/"+a);
});
</script>
@endsection
