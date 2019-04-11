@extends('adminlte::page')

@section('title', 'AmosILPSDK')

@section('content_header')
<h1>Laporan Kew.PA</h1>
@stop

@section('content')
<table id="kewpa" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
  <thead>
    <tr role="row">
      <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Bil</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Bangunan</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Kod Bangunan</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Kewpa11</th>

    </tr>
  </thead>
  <tbody>
	  @foreach($data as $v)
    <tr role="row" class="odd">
      <td class="sorting_1">{{++$n}}</td>
      <td>{{$v->block_name}}</td>
      <td>{{$v->block_code}}</td>
      <td>
        <a class="papar" href="/amos/kewpa11?bangunan={{$v->short_name}}" target="_blank">Papar HTML</a>
        | <a class="papar" href="/amos/kewpa11?bangunan={{$v->short_name}}&type=stream" target="_blank">Jana PDF</a>
        <br >
        @if(file_exists(public_path().'/pdf/'.str_replace(' ','-','KEWPA11-'.$v->block_name.'.pdf')))
          | <a target="_blank" href="{{asset('/pdf/'.str_replace(' ','-','KEWPA11-'.$v->block_name.'.pdf'))}}">Laporan terakhir</a>
            -> [{{date('d/m/Y h:i:s A',filemtime(public_path().'/pdf/'.str_replace(' ','-','KEWPA11-'.$v->block_name.'.pdf')))}}]
        @else
          | Laporan terakhir -> [Tidak Wujud]
        @endif
      </td>

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
@stop

@section('js')
<script>
  $(function() {
    //$('#kewpa').DataTable();
    $('#kewpa').DataTable({
      'pageLength'  : 30,
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
@stop
