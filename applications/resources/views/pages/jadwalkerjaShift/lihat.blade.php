@extends('layout.master')

@section('title')
<title>Group Shift | Presensi Online</title>
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
@endsection

@section('headscript')
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endsection

@section('breadcrumb')
  <h1>Group Shift</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ route('jamkerjaShift.index') }}">Group Shift</a></li>
    <li class="active">Ubah Group Shift</li>
  </ol>
@endsection

@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title" style="line-height:30px;">Group Shift</h3>
        <a href="{{ route('jamkerjaShift.index') }}" class="btn bg-blue pull-right">Kembali</a>
      </div>
      <form class="form-horizontal" role="form" action="{{ route('jamkerjaShift.edit') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $getJadwalKerjaShift->id }}">
        <div class="box-body">
          <div class="form-group {{ $errors->has('nama_group') ? 'has-error' : '' }}">
            <label class="col-sm-4 control-label">Nama Group Jam Kerja</label>
            <div class="col-sm-8">
              <input type="text" name="nama_group" class="form-control" value="{{ old('nama_group', $getJadwalKerjaShift->nama_group) }}" required="">
            </div>
          </div>
          <div class="form-group {{ $errors->has('jadwal1') ? 'has-error' : '' }}">
            <label class="col-sm-4 control-label">Jadwal 1</label>
            <div class="col-sm-8">
              <select name="jadwal1" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($getJamKerja as $key)
                <option value="{{$key->id}}" {{ old('jadwal1', $getJadwalKerjaShift->jadwal1) == $key->id ? 'selected=""' : '' }}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('jadwal2') ? 'has-error' : '' }}">
            <label class="col-sm-4 control-label">Jadwal 2</label>
            <div class="col-sm-8">
              <select name="jadwal2" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($getJamKerja as $key)
                <option value="{{$key->id}}" {{ old('jadwal2', $getJadwalKerjaShift->jadwal2) == $key->id ? 'selected=""' : '' }}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('jadwal3') ? 'has-error' : '' }}">
            <label class="col-sm-4 control-label">Jadwal 3</label>
            <div class="col-sm-8">
              <select name="jadwal3" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($getJamKerja as $key)
                <option value="{{$key->id}}" {{ old('jadwal3', $getJadwalKerjaShift->jadwal3) == $key->id ? 'selected=""' : '' }}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('jadwal4') ? 'has-error' : '' }}">
            <label class="col-sm-4 control-label">Jadwal 4</label>
            <div class="col-sm-8">
              <select name="jadwal4" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($getJamKerja as $key)
                <option value="{{$key->id}}" {{ old('jadwal4', $getJadwalKerjaShift->jadwal4) == $key->id ? 'selected=""' : '' }}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('jadwal5') ? 'has-error' : '' }}">
            <label class="col-sm-4 control-label">Jadwal 5</label>
            <div class="col-sm-8">
              <select name="jadwal5" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($getJamKerja as $key)
                <option value="{{$key->id}}" {{ old('jadwal5', $getJadwalKerjaShift->jadwal5) == $key->id ? 'selected=""' : '' }}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="box-footer clearfix">
          <div class="col-md-6">
            <button type="submit" class="btn bg-purple pull-right">Ubah</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script type="text/javascript">
$(".pilihHari").select2({
  placeholder: "|| --Pilih-- ",
  allowClear: true,
  escapeMarkup : function(text){
    text = text.split("||");
    return '<span class="pull-right">'+text[0]+'</span><b>'+text[1]+'</b>';
  }
});
</script>
@endsection
