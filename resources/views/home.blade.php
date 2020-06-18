@extends('adminlte::page')

@section('title', 'AmosILPSDK')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-diamond"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Jumlah Harta Modal</span>
        <span class="info-box-number">{{number_format($data->harta_modal)}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-suitcase"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Jumlah Inventori</span>
        <span class="info-box-number">{{number_format($data->inventori)}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->


  <!-- /.col -->
</div>
<div class="row">
  <div class="col-md-8">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Senarai Aset Bagi Setiap Blok</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <table class="table table-condensed">
          <tbody>
            <tr>
              <th style="width: 10px">#</th>
              <th>Nama Bangunan</th>
              <th>Code Block</th>
              <th>Bil Aset</th>
              <th>Status</th>
              <th>Peratus</th>
            </tr>
            @foreach($data->blocks as $block)

              @php
                $bil_aset = App\Assets::count_asset($block->short_name);
                $bil_aset_veri = App\Assets::count_asset_verified($block->short_name);
                $percent = $bil_aset_veri/$bil_aset*100;
                //temp
                //$percent = 100;
                //$cls_percent = 'progress-bar-danger';
                if($percent == 100){
                  $cls_percent = 'progress-bar-green';
                }
                else if($percent > 50){
                  $cls_percent = 'progress-bar-yellow';
                }
                else if($percent > 30){
                  $cls_percent = 'progress-bar-primary';
                }
                else{
                  $cls_percent = 'progress-bar-danger';
                }
              @endphp

              <tr>
                <td>{{$data->n++}}</td>
                <td>{{$block->short_name}}</td>
                <td>
                  <div>
                    {{-- <div class="progress-bar progress-bar-danger" style="width: 55%"></div> --}}
                    {{$block->block_code}}
                  </div>
                </td>
                <td>{{number_format($bil_aset)}}</td>
                <td>
                  <div class="progress progress-xs">
                      <div class="progress-bar {{$cls_percent}}" style="width: {{$percent}}%"></div>
                    </div>
                </td>
                  <td><span class="badge bg-gray">{{number_format($percent)}}%, ({{$bil_aset_veri}})</span></td>
                {{-- <td><span class="badge bg-gray">{{number_format($percent)}}%, ({{number_format($bil_aset)}})</span></td> --}}
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Status Aset</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="160" width="188" style="width: 188px; height: 160px;"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                  <ul class="chart-legend clearfix">
                    <li><i class="fa fa-circle-o text-green"></i> A - Sedang Digunakan</li>
                    <li><i class="fa fa-circle-o text-red"></i> B - Tidak Digunakan</li>
                    <li><i class="fa fa-circle-o text-yellow"></i> C - Perlu Pembaikan</li>
                    <li><i class="fa fa-circle-o text-aqua"></i> D - Sedang Diselenggara</li>
                    <li><i class="fa fa-circle-o text-light-blue"></i> E - Hilang</li>
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="/amos/assets/status/0/Sedang Digunakan">A - Sedang Digunakan <span class="pull-right text-green"> {{$veri->a}}</span></a></li>
                <li><a href="/amos/assets/status/1/Tidak Digunakan">B - Tidak Digunakan <span class="pull-right text-red"> {{$veri->b}}</span></a></li>
                <li><a href="/amos/assets/status/2/Perlu Pembaikan">C - Perlu Pembaikan <span class="pull-right text-yellow"> {{$veri->c}}</span></a></li>
                <li><a href="/amos/assets/status/3/Sedang Diselenggara">D - Sedang Diselenggara <span class="pull-right text-aqua"> {{$veri->d}}</span></a></li>
                <li><a href="/amos/assets/status/4/Hilang">E - Hilang <span class="pull-right text-light-blue"> {{$veri->e}}</span></a></li>
              </ul>
            </div>
            <!-- /.footer -->
          </div>
  </div>
  <div class="col-md-4">
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Pegawai Pemeriksa</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                      </button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <ul class="users-list clearfix">
          @foreach($pegawai_pemeriksa as $v)
          <li>
            <img src="{{  asset('http://apps.ilpsdk.gov.my/stafed/images/face/'. explode('@',$v->email)[0] . '.jpg') }}" alt="User Image" width="100">
            <a class="users-list-name" href="#">{{$v->nama}}</a>
            {{-- <span class="users-list-date">{{App\Bahagian::getBahagian($v->bahagian)}}</span> --}}
          </li>
          @endforeach
        </ul>
        <!-- /.users-list -->
      </div>
      <!-- /.box-body -->

      <!-- /.box-footer -->
    </div>
  </div>
</div>
<div class="row">

</div>
@stop
@section('js')
  <!-- ChartJS -->
<script src="//adminlte.io/themes/AdminLTE/bower_components/chart.js/Chart.js"></script>
<script>
// -------------
  // - PIE CHART -
  // -------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
  var pieChart       = new Chart(pieChartCanvas);
  var PieData        = [
    {
      value    : {{$veri->a}},
      color    : '#00a65a',
      highlight: '#00a65a',
      label    : 'A'
    },
    {
      value    : {{$veri->b}},
      color    : '#f56954',
      highlight: '#f56954',
      label    : 'B'
    },
    {
      value    : {{$veri->c}},
      color    : '#f39c12',
      highlight: '#f39c12',
      label    : 'C'
    },
    {
      value    : {{$veri->d}},
      color    : '#00c0ef',
      highlight: '#00c0ef',
      label    : 'D'
    },
    {
      value    : {{$veri->e}},
      color    : '#3c8dbc',
      highlight: '#3c8dbc',
      label    : 'E'
    },
  ];
  var pieOptions     = {
    // Boolean - Whether we should show a stroke on each segment
    segmentShowStroke    : true,
    // String - The colour of each segment stroke
    segmentStrokeColor   : '#fff',
    // Number - The width of each segment stroke
    segmentStrokeWidth   : 1,
    // Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    // Number - Amount of animation steps
    animationSteps       : 100,
    // String - Animation easing effect
    animationEasing      : 'easeOutBounce',
    // Boolean - Whether we animate the rotation of the Doughnut
    animateRotate        : true,
    // Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale         : false,
    // Boolean - whether to make the chart responsive to window resizing
    responsive           : true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio  : false,
    // String - A legend template
    legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    // String - A tooltip template
    // tooltipTemplate      : '<%=value %> <%=label%> users'
    tooltipTemplate      : '<%=value %> <%=label%>'
  };
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  // -----------------
  // - END PIE CHART -
  // -----------------

</script>
@stop
