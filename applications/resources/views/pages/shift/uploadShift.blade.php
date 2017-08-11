@extends('layout.master')

@section('title')
  <title>Jadwal Shift Uplaod | Presensi Online</title>
@endsection

@section('breadcrumb')
  <h1>Upload Jadwal Shift</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ route('shift.jadwal')}}">Jadwal Shift</a></li>
    <li class="active">Upload Jadwal Shift</li>
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
  <div class="col-md-6">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <div class="box-title">
          <p>Pilih Bulan</p>
        </div>
      </div>
      <form action="{{ route('shift.getTemplate')}}" method="POST">
      {{ csrf_field() }}
      <div class="box-body">
        <div class="row">
          <div class="col-xs-12">
            <input type="text" class="form-control" name="bulan_shift" id="bulan_shift" value="" placeholder="mm-yyyy" required="">
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button class="btn btn-block bg-purple">Download Template</button>
      </div>
      </form>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <div class="box-title">
          <p>Upload Jadwal</p>
        </div>
      </div>
      <form action="{{ route('shift.postTemplate')}}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="box-body">
        <div class="row">
          <div class="col-xs-5">
            <input type="text" class="form-control" name="upload_bulan_shift" id="upload_bulan_shift" value="" placeholder="mm-yyyy" required="">
          </div>
          <div class="col-xs-7">
            <input type="file" class="form-control" name="postTemplate"  value="" required="" accept=".xlsx">
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button class="btn btn-block bg-purple">Upload Jadwal</button>
      </div>
      </form>
    </div>
  </div>
</div>

{{-- <div class="row">
  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header">
        <h3 class="box-title">Hari</h3>
        <a href="{{ route('shift.getUpload') }}" class="btn bg-blue pull-right">Upload Excel</a>
      </div>
      <div class="box-body table-responsive">
        <table id="table_hari" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td></td>
              <th></th>
              <td></td>
            </tr>
          </tfoot>
          <tbody>
            @foreach ($tanggalBulan as $key)
            <tr>
              <td>{{ $no }}</td>
              <td>{{ $key }}</td>
              <td><a href="{{ url('jadwal-shift').'/'.$key }}"><i class="fa fa-edit"></i> Lihat</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div> --}}


@endsection

@section('script')
<script>
  $(function () {
    $("#table_hari").DataTable();
  });
  $('#bulan_shift').datepicker({
    autoclose: true,
    viewMode: 'years',
    format: 'mm/yyyy',
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    format: "mm-yyyy",
    viewMode: "months",
    minViewMode: "months"
  });

  $('#upload_bulan_shift').datepicker({
    autoclose: true,
    viewMode: 'years',
    format: 'mm/yyyy',
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    format: "mm-yyyy",
    viewMode: "months",
    minViewMode: "months"
  });
</script>
@endsection
