@extends('adminlte::page')

@section('title', 'AmosILPSDK')

@section('content_header')
<h1>Senarai Aset</h1>
@stop

@section('content')
<table id="kewpa" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
  <thead>
    <tr role="row">
      <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Bil</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">No Siri Pendaftaran</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Barcode</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Kategori</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Sub Kategori</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Jenis</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">No Casis</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Kod Lokasi</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">PIC</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Jenis Aset</th>

    </tr>
  </thead>
  <tbody>
	  @foreach($assets as $v)
    <tr role="row" class="odd">
      <td class="sorting_1">{{++$n}}</td>
      <td>{{$v->no_siri_pendaftaran}}</td>
      <td>{{$v->barcode}}</td>
      <td>{{$v->kategori}}</td>
      <td>{{$v->sub_kategori}}</td>
      <td>{{$v->jenis}}</td>
      <td>{{$v->no_casis}}</td>
      <td>{{$v->kod_lokasi}}</td>
      <td>{{$v->pegawai}}</td>
      <td>{{$v->jenis_aset}}</td>

    </tr>
	  @endforeach
  </tbody>
  <tfoot>
  </tfoot>
</table>

<!-- Modal -->
<div class="modal fade" id="printoption" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form" action="/amos/kewpa11" method="post" target="_blank">
          @csrf
          <div class="form-group">
            <label for="bil_item">Bilangan Item Per Halaman</label>
            <input type="number" name="bil_item" class="form-control" id="bil_item" placeholder="Tetapan asal 10">
          </div>

          <div class="form-group">
            <label for="skip">Bermula dari item?</label>
            <input type="number" name="skip" class="form-control" id="skip" placeholder="Tetapan asal mula dari item pertama">
          </div>

          <div class="form-group">
            <label for="take">Hingga item?</label>
            <input type="number" name="take" class="form-control" id="take" placeholder="Tetapan asal sehingga item terakhir">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button id="submit_print" type="submit" class="btn btn-primary">Jana Kewpa</button>
          </div>
        </form>

      </div>

    </div>
  </div>
</div>

<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>No Siri Pendaftaran</th>
                <th>Last name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>No Siri Pendaftaran</th>
                <th>Last name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>
@stop

@section('js')
<script>
  $(function() {
    $('#example').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "json-assets"
    } );

    //$('#kewpa').DataTable();

    // $('#kewpa').DataTable({
    //   'pageLength'  : 30,
    //   'paging'      : true,
    //   'lengthChange': false,
    //   'searching'   : true,
    //   'ordering'    : true,
    //   'info'        : true,
    //   'autoWidth'   : false
    // })
  })
</script>
@stop
