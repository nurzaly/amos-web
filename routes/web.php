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

Route::get('/assets', function () {
  $assets = Assets::where('id',3);
  $n = 0;
  return view('assetslist',compact('assets','n'));
});

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
  if(blank($barcode)){
    return 0;
  }
  $jenis_aset = explode('/',$barcode)[1];
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
      'jenis_aset' => $jenis_aset
    ]
  );
  return $result;
});

Route::get('/fail-write', function (Request $request) {
  //return $request->all();
  $no_siri_pendaftaran = $request->no_siri_pendaftaran;
  $data = $request->data;
  $tag = $request->tag;

  App\Fail::write($no_siri_pendaftaran,$data,$tag);

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

Route::get('/mail', 'MailControllers@html_email');


//Route::post('/kewpa10', 'GenerateReportController@kewpa10');
//Route::get('/kewpa10', 'GenerateReportController@kewpa10');
Route::post('/kewpa11', 'GenerateReportController@kewpa11');
Route::get('/kewpa11', 'GenerateReportController@kewpa11');



Route::get('/comingsoon', function(){
  return view('comingsoon');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
