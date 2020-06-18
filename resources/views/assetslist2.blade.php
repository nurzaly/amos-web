@extends('adminlte::page')

@section('title', 'AmosILPSDK')

@section('content_header')
<h1>Senarai Aset {{ $remark ?? "" }}</h1>
@stop

@section('content')

  <table class="table table-bordered" id="users-table">
          <thead>
              <tr>
                  <th>Num</th>
                  <th>No Siri Pendaftaran</th>
                  <th>Kategori</th>
                  <th>Sub Kategori</th>
                  <th>Jenis</th>
                  <th>Pegawai</th>
                  <th>Kod Lokasi</th>
              </tr>
          </thead>
          <tbody>
            @foreach($assets as $key => $asset)
              <tr>
                  @if(!$remark)
                    <td>{{$key + $assets->firstItem()}}</td>
                  @else
                    <td>{{$key + 1}}</td>
                  @endif
                  <td>{{$asset->no_siri_pendaftaran}}</td>
                  <td>{{$asset->kategori}}</td>
                  <td>{{$asset->sub_kategori}}</td>
                  <td>{{$asset->jenis}}</td>
                  <td>{{$asset->pegawai}}</td>
                  <td>{{$asset->kod_lokasi}}</td>
              </tr>
            @endforeach
          </tbody>
      </table>
      {{$assets->links("pagination::bootstrap-4")}}

@stop

@section('js')
<script>

</script>
@stop
