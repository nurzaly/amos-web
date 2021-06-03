<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//use PDF;
use App\Assets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
  //file_put_contents("storage/data.txt","hai");

  return view('welcome');
});

Route::get('/assets', 'AssetsController@list');
Route::get('/assets2', 'AssetsController@list2');
Route::get('/assets/status/{status}/{remark}', 'AssetsController@list2');
Route::get('/assets/datatable', 'AssetsController@datatable')->name('get.assets');

Route::get('/json-assets', function () {
  $assets = Assets::limit(100)->pluck('no_siri_pendaftaran');

  $data['draw'] = 6;
  $data['recordsTotal'] = count($assets);
  $data['recordsFiltered'] = count($assets);
  $data['data'] = $assets;

  $n = 0;
  return $data;
});

Route::get('/privacypolicy', function () {
  //file_put_contents("storage/data.txt","hai");
  return view('privacypolicy');
});

Route::get('/save-spa', function (Request $request) {
  //return $request->all();
  $barcode = $request->barcode;
  $no_siri_pendaftaran = $request->no_siri_pendaftaran;
  if(blank($barcode)){
    return 0;
  }

  $jenis_aset = 'I';
  if (strpos(strtolower($no_siri_pendaftaran), '/h') !== false) {
    $jenis_aset = 'H';
  }

  //$jenis_aset = explode('/',$barcode)[1];
  $barcode = str_replace('/','',$barcode);

  $result = App\Assets2::updateOrCreate(

    ['barcode' => $barcode],
    [
      'no_siri_pendaftaran' => $request->no_siri_pendaftaran,
      'barcode' => $barcode,
      'kategori' => $request->kategori,
      'sub_kategori' => $request->sub_kategori,
      'jenis' => $request->jenis,
      'butiran' => $request->butiran,
      'no_casis' => $request->no_casis,
      'kod_lokasi' => $request->kod_lokasi,
      'pegawai' => $request->pegawai,
      'jenis_aset' => $jenis_aset,
      'status' => $request->status,
      'harga_seunit' => $request->harga_seunit,
      'jenama_model' => $request->jenama_model,
      'tarikh_beli' => $request->tarikh_beli,
      'page' => $request->page,
      'bil' => $request->bil,
    ]
  );
  return $result;
});

Route::get('/fail-write', function (Request $request) {
  //return $request->all();
  $barcode = $request->barcode;
  $page = $request->page;
  $bil = $request->bil;
  $tag = $request->tag;

  App\Fail::write($barcode, $page,$bil,$tag);

  return "done";
});


Route::get('/report/kewpa', function () {
  $directory = public_path();

  $data = DB::table('location')
  ->leftJoin('pegawai_pemeriksa','location.block_code', '=', 'pegawai_pemeriksa.block_code')
  ->groupBy('block_code')
  ->groupBy('short_name')
  ->orderBy('location.block_code')
  ->select('location.block_code','location.block_name','location.short_name','pegawai_pemeriksa.pemeriksa_1','pegawai_pemeriksa.pemeriksa_2')
  ->get();
  $n = 0;
  return view('report',compact('data','n'));
});

Route::get('/report/kerosakan', 'ReportController@listkewpa9')->name('report.kerosakan');
Route::get('/kewpa9/{id}/delete', 'ReportController@deletekewpa9');

Route::get('/mail', 'MailControllers@html_email');


//Route::post('/kewpa10', 'GenerateReportController@kewpa10');
Route::get('/kewpa9/pdf/{id}', 'GenerateReportController@kewpa9');
Route::post('/kewpa11', 'GenerateReportController@kewpa11');
Route::get('/kewpa11', 'GenerateReportController@kewpa11');



Route::get('/comingsoon', function(){
  return view('comingsoon');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/website', function(){
  return view('web.index');
});
