@extends('adminlte::page')

@section('title', 'AmosILPSDK')

@section('content_header')
<h1>Laporan Kerosakan Kew.PA-9</h1>
@stop

@section('content')
<table id="kewpa" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
  <thead>
    <tr role="row">
      <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Bil</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Jenis Aset</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Perihal Kerosakan</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Pelapor</th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Action</th>

    </tr>
  </thead>
  <tbody>
	  @foreach($rosak as $key => $v)
    <tr role="row" class="odd">
      <td class="sorting_1">{{$key+1}}</td>
      <td>{{$v->asset->jenis ?? ""}}</td>
      <td>{{$v->perihal}}</td>
      <td>{{App\Staff::get_staf_info($v->pelapor)->nama}}</td>
      <td><a href="/amos/kewpa9/pdf/{{$v->id}}">Jana Kewpa9</a> | <a href="/amos/kewpa9/{{$v->id}}/delete">Delete</a></td>

    </tr>
	  @endforeach
  </tbody>
  <tfoot>
  </tfoot>
</table>

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
