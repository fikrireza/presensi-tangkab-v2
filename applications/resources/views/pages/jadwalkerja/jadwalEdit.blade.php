@extends('layout.master')

@section('title')
<title>Ubah Jadwal Kerja | Presensi Online</title>
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
@endsection

@section('headscript')
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endsection

@section('breadcrumb')
  <h1>Ubah Jadwal Kerja</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ route('jadwal-kerja') }}">Jadwal Jam Kerja</a></li>
    <li class="active">Ubah Jadwal Kerja</li>
  </ol>
@endsection

@section('content')

  @if(Session::has('gagal'))
  <script>
    window.setTimeout(function() {
      $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 7000);
  </script>

  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Gagal!</h4>
        <p><b>{{ Session::get('gagal') }}</b></p>
      </div>
    </div>
  </div>
  @endif
  

<div class="row">
  <div class="col-md-8">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title" style="line-height:30px;">Ubah Jadwal Kerja</h3>
        <a href="{{ route('jadwal-kerja') }}" class="btn bg-blue pull-right">Kembali</a>
      </div>
      <form class="form-horizontal" role="form" action="{{ route('jadwal-kerja.edit') }}" method="post">
        {{ csrf_field() }}
        <div class="box-body">
          <div class="form-group {{ $errors->has('skpd_id') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">SKPD</label>
            <div class="col-sm-8">
              <input type="hidden" name="id" value="{{ $getJadwal->id }}">
              <select  name="skpd_id" class="form-control select2" required="">
                @foreach ($getSKPD as $key)
                <option value="{{$key->id}}" @if ($key->id == $getJadwal->skpd_id) selected="" @endif>{{$key->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('periode_awal') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">Periode Awal</label>
            <div class="col-sm-8">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" id="periode_awal" type="text" name="periode_awal"  value="{{ $getJadwal->periode_awal }}" placeholder="@if($errors->has('periode_awal'))
                  {{ $errors->first('periode_awal')}}@endif Periode Awal">
              </div>
            </div>
          </div>
          <div class="form-group {{ $errors->has('periode_akhir') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">Periode Akhir</label>
            <div class="col-sm-8">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" id="periode_akhir" type="text" name="periode_akhir"  value="{{ $getJadwal->periode_akhir }}" placeholder="@if($errors->has('periode_akhir'))
                  {{ $errors->first('periode_akhir')}}@endif Periode Akhir">
              </div>
            </div>
          </div>
          <div class="form-group {{ $errors->has('senin') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">Senin</label>
            <div class="col-sm-8">
              <select name="senin" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($jamKerja as $key)
                <option value="{{$key->id}}" {{ $key->id == $getJadwal->jadwal_1 ? 'selected=""' : ''}}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('selasa') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">Selasa</label>
            <div class="col-sm-8">
              <select name="selasa" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($jamKerja as $key)
                <option value="{{$key->id}}" {{ $key->id == $getJadwal->jadwal_2 ? 'selected=""' : ''}}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('rabu') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">Rabu</label>
            <div class="col-sm-8">
              <select name="rabu" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($jamKerja as $key)
                <option value="{{$key->id}}" {{ $key->id == $getJadwal->jadwal_3 ? 'selected=""' : ''}}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('kamis') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">Kamis</label>
            <div class="col-sm-8">
              <select name="kamis" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($jamKerja as $key)
                <option value="{{$key->id}}" {{ $key->id == $getJadwal->jadwal_4 ? 'selected=""' : ''}}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('jumat') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">Jum'at</label>
            <div class="col-sm-8">
              <select name="jumat" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($jamKerja as $key)
                <option value="{{$key->id}}" {{ $key->id == $getJadwal->jadwal_5 ? 'selected=""' : ''}}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('sabtu') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">Sabtu</label>
            <div class="col-sm-8">
              <select name="sabtu" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($jamKerja as $key)
                <option value="{{$key->id}}" {{ $key->id == $getJadwal->jadwal_6 ? 'selected=""' : ''}}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('minggu') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">Minggu</label>
            <div class="col-sm-8">
              <select name="minggu" class="form-control pilihHari">
                <option value=""></option>
                @foreach ($jamKerja as $key)
                <option value="{{$key->id}}" {{ $key->id == $getJadwal->jadwal_7 ? 'selected=""' : ''}}>{{$key->nama_jam_kerja}} || {{ $key->jam_masuk}} s/d {{ $key->jam_pulang}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group {{ $errors->has('flag_status') ? 'has-error' : '' }}">
            <label class="col-sm-3 control-label">Status</label>
            <div class="col-sm-8">
              <select  name="flag_status" class="form-control select2" required="">
                <option value="1" @if ($getJadwal->flag_status == 1) selected="" @endif> Aktif</option>
                <option value="0" @if ($getJadwal->flag_status == 0) selected="" @endif>Non Aktif</option>
              </select>
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
<script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script type="text/javascript">
$(".select2").select2();
$(".pilihHari").select2({
  placeholder: "|| --Pilih-- ",
  allowClear: true,
  escapeMarkup : function(text){
    text = text.split("||");
    return '<span class="pull-right">'+text[0]+'</span><b>'+text[1]+'</b>';
  }
});
$('#periode_awal').datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd',
  todayHighlight: true,
});
$('#periode_akhir').datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd',
  todayHighlight: true,
});
</script>
@endsection
