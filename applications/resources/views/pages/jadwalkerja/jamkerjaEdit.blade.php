@extends('layout.master')

@section('title')
  <title>Ubah Tambah Jam Kerja</title>
  <link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}" media="screen" title="no title">
@endsection

@section('breadcrumb')
  <h1>Ubah Tambah Jam Kerja</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ route('jadwal-kerja') }}">Jadwal Jam Kerja</a></li>
    <li><a href="{{ route('jadwal-kerja.group') }}">Group Jam Kerja</a></li>
    <li><a href="{{ route('jadwal-kerja.jam') }}">Jam Kerja</a></li>
    <li class="active">Ubah Jam Kerja</li>
  </ol>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title" style="line-height:30px;">Ubah Jam Kerja</h3>
      </div>
      <form class="form-horizontal" role="form" action="{{ route('jadwal-kerja.editjam') }}" method="update">
        {{ csrf_field() }}
        <div class="box-body">
          <div class="form-group {{ $errors->has('nama_jam_kerja') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">Nama Jam Kerja</label>
            <div class="col-sm-8">
              <input type="hidden" name="id" value="{{ $getJamKerja->id }}">
              <input type="text" name="nama_jam_kerja" class="form-control" value="{{ old('nama_jam_kerja', $getJamKerja->nama_jam_kerja) }}" required="">
            </div>
          </div>
          <div class="form-group {{ $errors->has('jam_masuk') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label">Jam Masuk</label>
            <div class="col-sm-8 bootstrap-timepicker timepicker">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                </div>
                <input type="text" name="jam_masuk" id="timepicker1" class="form-control" value="{{ old('jam_masuk', $getJamKerja->jam_masuk) }}" required="">
              </div>
            </div>
          </div>
          <div class="form-group {{ $errors->has('jam_masuk_awal') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label">Jam Masuk Awal</label>
            <div class="col-sm-8 bootstrap-timepicker timepicker">
              <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-clock-o"></i>
              </div>
              <input type="text" name="jam_masuk_awal" id="timepicker2" class="form-control" value="{{ old('jam_masuk_awal', $getJamKerja->jam_masuk_awal) }}" required="">
              </div>
            </div>
          </div>
          <div class="form-group {{ $errors->has('jam_masuk_akhir') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label">Jam Masuk Akhir</label>
            <div class="col-sm-8 bootstrap-timepicker timepicker">
              <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-clock-o"></i>
              </div>
              <input type="text" name="jam_masuk_akhir" id="timepicker3" class="form-control" value="{{ old('jam_masuk_akhir', $getJamKerja->jam_masuk_akhir) }}" required="">
              </div>
            </div>
          </div>
          <div class="form-group {{ $errors->has('jam_pulang') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label">Jam Pulang</label>
            <div class="col-sm-8 bootstrap-timepicker timepicker">
              <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-clock-o"></i>
              </div>
              <input type="text" name="jam_pulang" id="timepicker4" class="form-control" value="{{ old('jam_pulang', $getJamKerja->jam_pulang) }}" required="">
              </div>
            </div>
          </div>
          <div class="form-group {{ $errors->has('jam_pulang_awal') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label">Jam Pulang Awal</label>
            <div class="col-sm-8 bootstrap-timepicker timepicker">
              <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-clock-o"></i>
              </div>
              <input type="text" name="jam_pulang_awal" id="timepicker5" class="form-control" value="{{ old('jam_pulang_awal', $getJamKerja->jam_pulang_awal) }}" placeholder="@if($errors->has('jam_pulang_awal'))
                {{ $errors->first('jam_pulang_awal')}} @endif 00:00:00" required="">
              </div>
            </div>
          </div>
          <div class="form-group {{ $errors->has('jam_pulang_akhir') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label">Jam Pulang Akhir</label>
            <div class="col-sm-8 bootstrap-timepicker timepicker">
              <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-clock-o"></i>
              </div>
              <input type="text" name="jam_pulang_akhir" id="timepicker6" class="form-control" value="{{ old('jam_pulang_akhir', $getJamKerja->jam_pulang_akhir) }}" placeholder="@if($errors->has('jam_pulang_akhir'))
                {{ $errors->first('jam_pulang_akhir')}} @endif 00:00:00" required="">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Tanggal Berikutnya</label>
            <div class="col-sm-8">
              <label>
                <input type="checkbox" class="minimal" name="flag_besok" {{ $getJamKerja->flag_besok == 0 ? '' : 'checked' }}>
              </label>
            </div>
          </div>
          <div class="form-group {{ $errors->has('toleransi_terlambat') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label">Toleransi Terlambat</label>
            <div class="col-sm-8">
              <input type="text" name="toleransi_terlambat" class="form-control" value="{{ old('toleransi_terlambat', $getJamKerja->toleransi_terlambat) }}" required="">
            </div>
          </div>
          <div class="form-group {{ $errors->has('toleransi_pulcep') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label">Toleransi Pulang Cepat</label>
            <div class="col-sm-8">
              <input type="text" name="toleransi_pulcep" class="form-control" value="{{ old('toleransi_pulcep', $getJamKerja->toleransi_pulcep) }}" required="">
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn bg-purple pull-right">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"/>
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script type="text/javascript">
  $(['#timepicker1', '#timepicker2', '#timepicker3', '#timepicker4', '#timepicker5', '#timepicker6']).timepicker({
    showInputs: false,
    use24hours: true,
    format: 'HH:mm:ss',
    showMeridian: false
  });
</script>
@endsection
