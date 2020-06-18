<?php

use Illuminate\Http\Request;

use App\Locations;
use App\Assets;

use App\Http\Resources\LocationResource;
use App\Http\Resources\AssetsResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Get only assets barcode updated
function trim_nama($nama){
  $nama = strtolower($nama);
  $nama = trim(explode('bin',$nama)[0]);
  if(strpos($nama," ")){
    $find = array("bin","mohd", ".", "abd","@", "ahmad","muhammad", "muhd", "dg","noor","nor", "wan","syed","rohim","nur");
    $replace = "";
    $nama = trim(str_replace($find,$replace,$nama));
  }

  return $nama;
}

function get_aset_search_key($short_name){
  $location = Locations::where('short_name',$short_name)->first();
  $search_key = $location->block_code;
  if($location->aset !== null){
    $search_key = $location->aset;
  }

  return $search_key;
}


Route::get('/', function(){
  return 'Amos api';
});

Route::post('/kerosakkan/store', function(Request $request){
  $laporan = App\LaporanKerosakkan::create([
    'barcode' => $request->barcode,
    'perihal' => $request->perihal,
    'pelapor' => $request->pelapor,
  ]);

  //return $request->all();

  if($laporan){
    return response()->json([
      'status' => 'success',
    ]);
  }

  return response()->json([
    'status' => 'failed',
  ]);

});

Route::get('/assets-jenis', function (Request $request){

  AssetsResource::withoutWrapping();
  //return $request->all();
  $nama = trim_nama($request->nama);
  //return $nama;
  $query = DB::table('assets')
  ->leftJoin('verifications','assets.id','=','verifications.asset_id')
  ->where('pegawai', 'like', '%'.$nama.'%');
  if($request->jenis_aset == 'I'){
    $query->where(function($q){
      $q->where('jenis_aset','I')
      ->orWhere('jenis_aset','R');
    });
  }
  else{
    $query->where('jenis_aset','H');
  }
  $query->select(
  'assets.id',
  'assets.no_siri_pendaftaran',
  'assets.barcode',
  'assets.kategori',
  'assets.sub_kategori',
  'assets.jenis',
  'assets.no_casis',
  'assets.jenis_aset',
  'assets.pegawai',
  'assets.kod_lokasi',
  'assets.tarikh_beli',
  'assets.jenama_model',
  'assets.harga_seunit',
  'assets.update_spa',
  'verifications.asset_id'
  );
  //$query->orderBy('verifications.asset_id');
  $query->orderBy('assets.kod_lokasi');
  //$query->limit(10);
  $assets = $query->get();


  //return $assets;
  return AssetsResource::collection($assets);
});



Route::get('/get-assets-by-location', function (Request $request){
  $short_name = $request->get('location');
  $search_key = get_aset_search_key($short_name);

  $q = DB::table('assets');
  $q->leftJoin('verifications','assets.id','=','verifications.asset_id');
  $q->where('assets.kod_lokasi','like','%/'.$search_key.'/%');
  $q->select(
    'assets.id',
    'assets.no_siri_pendaftaran',
    'assets.barcode',
    'assets.kategori',
    'assets.sub_kategori',
    'assets.jenis',
    'assets.no_casis',
    'assets.jenis_aset',
    'assets.pegawai',
    'assets.kod_lokasi',
    'assets.tarikh_beli',
    'assets.jenama_model',
    'assets.harga_seunit',
    'assets.update_spa',
    'verifications.asset_id'
  );
  //$q->orderBy('verifications.asset_id');
  $q->orderBy('assets.kod_lokasi');

  $assets = $q->get();

  AssetsResource::withoutWrapping();

  return AssetsResource::collection($assets);

  //return $q->get();
});

Route::get('/search-assets', function (Request $request){

  $search_key = $request->search_key;
  $q = DB::table('assets');
  $q->leftJoin('verifications','assets.id','=','verifications.asset_id');

  // $searchValues = explode('.',$search_key); 

  // foreach ($searchValues as $search_key) {
  //   $q->orWhere('assets.no_siri_pendaftaran', 'like', '%'.$search_key.'%');
  //   $q->orWhere('assets.kategori', 'like', '%'.$search_key.'%');
  //   $q->orWhere('assets.sub_kategori', 'like', '%'.$search_key.'%');
  //   $q->orWhere('assets.jenis', 'like', '%'.$search_key.'%');
  //   $q->orWhere('assets.no_casis', 'like', '%'.$search_key.'%');
  //   $q->orWhere('assets.kod_lokasi', 'like', '%'.$search_key.'%');
  //   $q->orWhere('assets.pegawai', 'like', '%'.$search_key.'%');
  //   $q->orWhere('assets.jenis_aset', 'like', '%'.$search_key.'%');
  //   $q->orderBy('verifications.asset_id');
  //   $q->orderBy('assets.kod_lokasi');
  // }

    $q->orWhere('assets.no_siri_pendaftaran', 'like', '%'.$search_key.'%');
    $q->orWhere('assets.kategori', 'like', '%'.$search_key.'%');
    $q->orWhere('assets.sub_kategori', 'like', '%'.$search_key.'%');
    $q->orWhere('assets.jenis', 'like', '%'.$search_key.'%');
    $q->orWhere('assets.no_casis', 'like', '%'.$search_key.'%');
    $q->orWhere('assets.kod_lokasi', 'like', '%'.$search_key.'%');
    $q->orWhere('assets.pegawai', 'like', '%'.$search_key.'%');
    $q->orWhere('assets.jenis_aset', 'like', '%'.$search_key.'%');
    $q->orderBy('verifications.asset_id');
    $q->orderBy('assets.kod_lokasi');

  $q->select(
    'assets.id',
    'assets.no_siri_pendaftaran',
    'assets.barcode',
    'assets.kategori',
    'assets.sub_kategori',
    'assets.jenis',
    'assets.no_casis',
    'assets.jenis_aset',
    'assets.pegawai',
    'assets.kod_lokasi',
    'assets.tarikh_beli',
    'assets.jenama_model',
    'assets.harga_seunit',
    'verifications.asset_id'
  );
  $q->orderBy('assets.kod_lokasi');

  //return $q->toSql();

  //return $q->toSql();

  AssetsResource::withoutWrapping();
  $assets = $q->get();

  return AssetsResource::collection($assets);

});

//Get only assets with null barcode
Route::get('/assets', function (Request $request){
  AssetsResource::withoutWrapping();

  if(filled($request->all())){
    $ret = null;
    $q = DB::table('assets');
    $q->leftJoin('verifications','assets.id','=','verifications.asset_id');
    foreach($request->all() as $k => $v){
      if(strpos($v, 'like') !== false){
        $q->where('assets.'.$k,'like','%/'.explode(' ',$v)[1].'/%');
      }
      else{
        $q->where('assets.'.$k,$v);
      }

    }
    //return $q->toSql();
    //$assets = $q->get();
  }
  else{
    $q = App\Assets::all();
  }

  $q->select(
  'assets.id',
  'assets.no_siri_pendaftaran',
  'assets.barcode',
  'assets.kategori',
  'assets.sub_kategori',
  'assets.jenis',
  'assets.no_casis',
  'assets.jenis_aset',
  'assets.pegawai',
  'assets.tarikh_beli',
  'assets.jenama_model',
  'assets.harga_seunit',
  'assets.kod_lokasi',
  'verifications.asset_id'
  );

  $assets = $q->get();

  return AssetsResource::collection($assets);
});

//Get only assets barcode updated
Route::get('/assets-has-barcode', function (Request $request){

  AssetsResource::withoutWrapping();

  $assets = DB::table('assets')
  ->leftJoin('location', 'assets.kod_lokasi', 'like', 'location.location_code')
  ->where('barcode', '!=', 'NULL')
  ->where('bahagian', $request->bahagian)
  ->select('assets.*', 'location_name', 'block_name','level','short_name')
  ->get();

  return AssetsResource::collection($assets);
});

Route::post('/assets-reset-barcode', 'AssetsController@resetBarcode');

$router->post('/assets-update-barcode', 'AssetsController@updateBarcode');

//Select single assets by barcode
Route::post('/assets-find-barcode', function (Request $request){

  AssetsResource::withoutWrapping();

  $barcode = $request->barcode;
  $assets = DB::table('assets')
  ->leftjoin('location', 'assets.kod_lokasi', 'like', 'location.location_code')
  ->where('barcode', $barcode)
  ->select('assets.*', 'location_name', 'block_name','level', 'short_name')
  ->get();

  return AssetsResource::collection($assets);
});

Route::get('/locations',function(Request $request){
  LocationResource::withoutWrapping();
  if(!blank($request->type)){
    $return = DB::table('location')
    ->leftJoin('pegawai_pemeriksa','location.short_name', '=', 'pegawai_pemeriksa.short_name')
    ->groupBy('block_code')
    ->groupBy('block_name')
    ->select('location.location_code','location.block_code','location.block_name','location.short_name','pegawai_pemeriksa.pemeriksa_1','pegawai_pemeriksa.pemeriksa_2')
    ->get();

    return LocationResource::collection($return);
  }

  return LocationResource::collection(Locations::all());
});

//Update location
Route::post('/update-location', function (Request $request){
  $data['status'] = 'failed';

  $update = DB::table('assets')
  ->where('id', $request->id)
  ->update(['kod_lokasi' => $request->kod_lokasi]);

  if($update == 1){
    $data['status'] = 'success';
  }

  return $data;
});

//Update PIC
Route::post('/update-pic', function (Request $request){
  $data['status'] = 'failed';

  $update = DB::table('assets')
  ->where('id', $request->id)
  ->update(['pegawai' => $request->pic_email]);

  if($update == 1){
    $data['status'] = 'success';
  }

  return $data;
});



//Get hartamodal count
Route::post('/count-user-assets', function (Request $request){

  $data['harta-modal'] = 0;
  $data['inventori'] = 0;

  $nama = trim_nama($request->nama);

  $data['harta-modal'] = DB::table('assets')
  ->where('jenis_aset', 'H')
  ->where('pegawai','like','%'.$nama.'%')
  ->count();

  $data['inventori'] = DB::table('assets')
  ->where('pegawai','like','%'.$nama.'%')
  ->where(function($query){
    $query->where('jenis_aset', 'I')
    ->orWhere('jenis_aset','R');
  })
  ->count();

  return $data;
});

Route::post('/save-pemeriksaan-data',function (Request $request){

  $location = $request->location;

  $verifications = App\Verifications::updateOrCreate(
    ['asset_id' => $request->asset_id],
    [
      'barcode' => $request->barcode,
      'jenis' => $request->jenis,
      'kod_lokasi_sebenar' => $location,
      'status' => $request->status,
      'catatan' => $request->catatan,
      'pemeriksa' => $request->pemeriksa
    ]

  );
  $data['status'] = "success";
  $data['message'] = "Maklumat terlah berjaya disimpan";
  return $data;
});

Route::post('/save-pegawai-pemeriksa',function (Request $request){
    $result = App\PegawaiPemeriksa::updateOrCreate(
      [
        'block_code' => $request->block_code,
        'short_name' => $request->short_name
      ],
      [
        'pemeriksa_1' => $request->nama_pemeriksa_1,
        'pemeriksa_2' => $request->nama_pemeriksa_2
      ]
    );

    $data['status'] = 'success';
    return $data;
});

Route::get('/get-pemeriksaan-data',function(Request $req){
  //return $req->all();
  $data ['status'] = 'failed';
  $asset = App\Verifications::where("asset_id",$req->id)->first();
  $data['status'] = 'success';


  if(!empty($asset)){
    $pemeriksa = App\Staff::where('email',$asset->pemeriksa)->first()->nama;
    $asset->pemeriksa = $pemeriksa;
    $data['data'] = $asset;
  }
  //$update = $asset->updated_at;
  //$asset->updated_at = Carbon\Carbon::parse($update)->diffForHumans();

  return $data;
});

Route::post('/save-update-spa',function(Request $req){

  $id = $req->id;
  $email = $req->email;


  if(empty($id) || empty($email)){
    return response()->json([
        'status' => 'failed'
      ]);
  }

  $asset = Assets::find($id);
  $asset_location = App\Locations::get_location_info($asset->kod_lokasi);

  //dd($asset_location);

  $is_valid_user = App\PegawaiPemeriksa::where('block_code',$asset_location->block_code)
              ->where(function($query) use ($email){
                $query->where('pemeriksa_1', $email)->orWhere('pemeriksa_2',$email);
              })->count();

  if(!$is_valid_user){
    return response()->json([
        'status' => 'failed',
        'data' => 'denied user'
      ]);
  }

  $tarikh_update_spa = now();

  Assets::where('id',$id)->update(['update_spa' => $tarikh_update_spa]);

  return response()->json([
        'status' => 'success',
        'data' => \Carbon\Carbon::parse($tarikh_update_spa)->format('d-m-yy h:i A')
      ]);

});
