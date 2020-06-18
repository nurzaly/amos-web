@extends('adminlte::page')

@section('title', 'AmosILPSDK')

@section('content_header')
<h1>Senarai Aset</h1>
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
      </table>

@stop

@section('js')
<script>
$(function() {
  $('#users-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{!! route('get.assets') !!}',
      pageLength: 25,
      columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex' },
          { data: 'no_siri_pendaftaran', name: 'no_siri_pendaftaran' },
          { data: 'kategori', name: 'kategori' },
          { data: 'sub_kategori', name: 'sub_kategori' },
          { data: 'jenis', name: 'jenis' },
          { data: 'pegawai', name: 'pegawai' },
          { data: 'kod_lokasi', name: 'kod_lokasi' }
      ]
  });
});

</script>
@stop
