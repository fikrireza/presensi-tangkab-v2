@extends('layout.master')

@section('title')
<title>Tambah Group Shift | Presensi Online</title>
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
@endsection

@section('headscript')
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endsection

@section('breadcrumb')
  <h1>Tambah Group Shift</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ route('jamkerjaShift.index') }}">Group Shift</a></li>
    <li class="active">Tambah Group Shift</li>
  </ol>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title" style="line-height:30px;">Tambah Group Shift</h3>
        <a href="{{ route('jamkerjaShift.index') }}" class="btn bg-blue pull-right">Kembali</a>
      </div>
      <form class="form-horizontal" role="form" action="{{ route('jamkerjaShift.store') }}" method="post">
        {{ csrf_field() }}
        <div class="box-body">
          @if(session('status') == 'administrator' || session('status') == 'superuser')
          <div class="form-group {{ $errors->has('skpd_id') ? 'has-error' : '' }}">
            <label class="col-sm-4 control-label">SKPD</label>
            <div class="col-sm-8">
              <select name="skpd_id" class="form-control select2">
                <option value="">--Pilih--</option>
                @foreach ($getSkpd as $key)
                  <option value="{{$key->id}}" {{ old('skpd_id') == $key->id ? 'selected=""' : '' }}>{{$key->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>
          @else
          <input type="hidden" name="skpd_id" value="{{ Auth::user()->skpd_id }}">
          @endif
          <div class="form-group {{ $errors->has('nama_group') ? 'has-error' : '' }}">
            <label class="col-sm-4 control-label">Nama Group Jam Kerja</label>
            <div class="col-sm-8">
              <input type="text" name="nama_group" class="form-control" value="{{ old('nama_group') }}" placeholder="@if($errors->has('nama_group'))
                {{ $errors->first('nama_group')}}@endif Nama Group Jam Kerja" required="">
            </div>
          </div>
          <div class="form-group {{ $errors->has('jadwal1') ? 'has-error' : '' }}">
            <label class="col-sm-4 control-label">Jadwal 1</label>
            <div class="col-sm-8">
              <select name="jadwal1" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($getJamKerja as $key)
                <option value="{{$key->id}}" {{ old('jadwal1') == $key->id ? 'selected=""' : '' }}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
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
                <option value="{{$key->id}}" {{ old('jadwal2') == $key->id ? 'selected=""' : '' }}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
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
                <option value="{{$key->id}}" {{ old('jadwal3') == $key->id ? 'selected=""' : '' }}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
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
                <option value="{{$key->id}}" {{ old('jadwal4') == $key->id ? 'selected=""' : '' }}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
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
                <option value="{{$key->id}}" {{ old('jadwal5') == $key->id ? 'selected=""' : '' }}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          {{-- <table class="table" id="JamKerja">
            <tr>
              <td><label class="control-label">Jadwal 1</label></td>
              <td>
                <select name="jamKerja[1][jam_kerja_id]" class="form-control select2">
                  <option value="">-- Pilih --</option>
                  @foreach ($getJamKerja as $key)
                  <option value="{{ $key->id }}">{{ $key->nama_jam_kerja}} -> {{ $key->jam_masuk }} s/d {{$key->jam_pulang}}</option>
                  @endforeach
                </select>
                @if($errors->has('jamKerja[1][jam_kerja_id]'))
                  <span class="help-block">
                    <i>* {{$errors->first('jamKerja[1][jam_kerja_id]')}}</i>
                  </span>
                @endif
              </td>
            </tr>
            <tr>
              <td><label class="control-label">Jadwal 2</label></td>
              <td>
                <select name="jamKerja[2][jam_kerja_id]" class="form-control select2">
                  <option value="">-- Pilih --</option>
                  @foreach ($getJamKerja as $key)
                  <option value="{{ $key->id }}">{{ $key->nama_jam_kerja}} -> {{ $key->jam_masuk }} s/d {{$key->jam_pulang}}</option>
                  @endforeach
                </select>
                @if($errors->has('jamKerja[2][jam_kerja_id]'))
                  <span class="help-block">
                    <i>* {{$errors->first('jamKerja[2][jam_kerja_id]')}}</i>
                  </span>
                @endif
              </td>
            </tr>
            <tr>
              <td><label class="control-label">Jadwal 3</label></td>
              <td>
                <select name="jamKerja[3][jam_kerja_id]" class="form-control select2">
                  <option value="">-- Pilih --</option>
                  @foreach ($getJamKerja as $key)
                  <option value="{{ $key->id }}">{{ $key->nama_jam_kerja}} -> {{ $key->jam_masuk }} s/d {{$key->jam_pulang}}</option>
                  @endforeach
                </select>
                @if($errors->has('jamKerja[3][jam_kerja_id]'))
                  <span class="help-block">
                    <i>* {{$errors->first('jamKerja[3][jam_kerja_id]')}}</i>
                  </span>
                @endif
              </td>
            </tr>
            <tr>
              <td><label class="control-label">Jadwal 4</label></td>
              <td>
                <select name="jamKerja[4][jam_kerja_id]" class="form-control select2">
                  <option value="">-- Pilih --</option>
                  @foreach ($getJamKerja as $key)
                  <option value="{{ $key->id }}">{{ $key->nama_jam_kerja}} -> {{ $key->jam_masuk }} s/d {{$key->jam_pulang}}</option>
                  @endforeach
                </select>
                @if($errors->has('jamKerja[4][jam_kerja_id]'))
                  <span class="help-block">
                    <i>* {{$errors->first('jamKerja[4][jam_kerja_id]')}}</i>
                  </span>
                @endif
              </td>
            </tr>
            <tr>
              <td><label class="control-label">Jadwal 5</label></td>
              <td>
                <select name="jamKerja[5][jam_kerja_id]" class="form-control select2">
                  <option value="">-- Pilih --</option>
                  @foreach ($getJamKerja as $key)
                  <option value="{{ $key->id }}">{{ $key->nama_jam_kerja}} -> {{ $key->jam_masuk }} s/d {{$key->jam_pulang}}</option>
                  @endforeach
                </select>
                @if($errors->has('jamKerja[5][jam_kerja_id]'))
                  <span class="help-block">
                    <i>* {{$errors->first('jamKerja[5][jam_kerja_id]')}}</i>
                  </span>
                @endif
              </td>
            </tr>
          </table> --}}
        </div>
        <div class="box-footer clearfix">
          <div class="col-md-6">
            <button type="submit" class="btn bg-purple pull-right">Simpan</button>
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
$('input[type="checkbox"].flat-purple').iCheck({
  checkboxClass: 'icheckbox_flat-purple'
});

</script>
@endsection
