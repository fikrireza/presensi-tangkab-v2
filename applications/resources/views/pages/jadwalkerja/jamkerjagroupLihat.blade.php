@extends('layout.master')

@section('title')
<title>Group Jam Kerja | Presensi Online</title>
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
@endsection

@section('headscript')
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endsection

@section('breadcrumb')
  <h1>Group Jam Kerja</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ route('jadwal-kerja') }}">Jadwal Jam Kerja</a></li>
    <li><a href="{{ route('jadwal-kerja.group') }}">Group Jam Kerja</a></li>
    <li class="active">Group Jam Kerja</li>
  </ol>
@endsection

@section('content')

{{-- Modal NonAktif Group Kerja --}}
<div class="modal fade" id="myModalNonAktif" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Non Aktif Group Kerja?</h4>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin untuk me-non Aktifkan Group Kerja ini?</p>
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
        <h4 class="modal-title">Aktifkan Group Kerja?</h4>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin untuk Aktifkan Group Kerja ini?</p>
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
        <a class="btn btn-danger btn-flat" id="setaktif">Ya, saya yakin</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title" style="line-height:30px;">Group Jam Kerja</h3>
        <a href="{{ route('jadwal-kerja.group') }}" class="btn bg-blue pull-right">Kembali</a>
      </div>
      <form class="form-horizontal" role="form" action="{{ route('jadwal-kerja.editgroup') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="group_id" value="{{ $lihats[0]->id }}">
        <div class="box-body">
          <table class="table">
            <tr>
              <td><label class="control-label">Nama Group Jam Kerja</label>&nbsp;</td>
              <td><input type="text" name="nama_group" class="form-control" value="{{ $lihats[0]->nama_group }}" readonly=""></td>
            </tr>
            @php
              $no = 1;
              $count = $lihats->count();
            @endphp
            @foreach ($lihats as $pecah)
            <tr>
              <td><label class="control-label">Jam Kerja {{ $no }}</label>&nbsp;</td>
              <td>
                <select name="jam_kerja_id" class="form-control select2" disabled>
                  <option value="--Pilih--">-- Pilih --</option>
                  @foreach ($getJamKerja as $key)
                  <option value="{{ $key->id }}" @if($pecah->jam_kerja_id == $key->id) selected="" @endif>{{ $key->nama_jam_kerja}} -> {{ $key->jam_masuk }} s/d {{$key->jam_pulang}}</option>
                  @endforeach
                </select>
              </td>
              <td>
                @if ($pecah->flag_status == 1)
                  @if (session('status') == 'administrator' || session('status') == 'superuser')
                    <a href="" class="nonaktif" data-toggle="modal" data-target="#myModalNonAktif" data-value="{{ $pecah->id }}">NonAktif</a>
                  @endif
                  @else
                  @if (session('status') == 'administrator' || session('status') == 'superuser')
                    <a href="" class="aktif" data-toggle="modal" data-target="#myModalAktif" data-value="{{ $pecah->id }}">Aktifkan</a>
                  @endif
                @endif
              </td>
            </tr>
            @php
              $no++;
            @endphp
            @endforeach

            @for ($i=$count; $i < 5; $i++)
            <tr>
              <td><label class="control-label">Jam Kerja {{ $i+1 }}</label>&nbsp;</td>
              <td>
                <select name="jamKerja[][jam_kerja_id]" class="form-control select2">
                  <option value="">-- Pilih --</option>
                  @foreach ($getJamKerja as $key)
                  <option value="{{ $key->id }}">{{ $key->nama_jam_kerja}} -> {{ $key->jam_masuk }} s/d {{$key->jam_pulang}}</option>
                  @endforeach
                </select>
              </td>
            </tr>
            @endfor
          </table>
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
$(".select2").select2();

$('a.nonaktif').click(function(){
  var a = $(this).data('value');
  $('#setnonaktif').attr('href', "{{ url('/') }}/jadwal-kerja-group/non/"+a);
});
$('a.aktif').click(function(){
  var a = $(this).data('value');
  $('#setaktif').attr('href', "{{ url('/') }}/jadwal-kerja-group/aktif/"+a);
});
</script>
@endsection
