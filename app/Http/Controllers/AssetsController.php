<?php

namespace App\Http\Controllers;

use Illuminate\Support\MessageBag;
use DB;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Assets;
use Yajra\Datatables\Datatables;

class AssetsController extends Controller
{

  public function list(){
    //$assets = Assets::limit(100)->get();
    return view('assetslist');


  }

  public function list2($status = NULL,$remark = NULL){

    if(isset($status)){

      $assets2 = Assets::join('verifications','assets.id','=','verifications.asset_id')
      ->where('verifications.status','like','%'.$status.'%');

      if($status != 0){
        $assets = $assets2->paginate(20);
        return view('assetslist2',compact('remark'))->withAssets($assets);
      }

      $assets1 = Assets::whereNotIn('id',function($query) {
          $query->select('asset_id')->from('verifications');
        })->get();

      $assets = $assets1->merge($assets2->get())->paginate(20);

      //return $assets;
    }
    else{
      $assets = Assets::paginate(20);
    }

    return view('assetslist2', compact('remark'))->withAssets($assets);


  }

  public function datatable(){
    $assets = Assets::all();
    return DataTables::of($assets)->addIndexColumn()->make(true);
  }

  public function updateBarcode(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'barcode' => 'required|unique:assets,barcode',
    ]);

    $id = $request->input('id');
    $barcode = $request->input('barcode');

    if ($validator->fails()) {
      $barcode = Assets::where('barcode', $barcode)->select('no_siri_pendaftaran')->first();
      $data['status'] = "duplicate";
      $data['message'] = "Duplicate with " . $barcode->no_siri_pendaftaran;
      return $data;
    } else {
      $r = Assets::where('id', $id)->update(['barcode'=>$barcode]);
      //log::info($r);
      if ($r == 1) {
        $data['status'] = 'success';
        $data['message'] = 'Success update barcode';
        return $data;
      } elseif ($r == 0) {
        $data['status'] = 'failed';
        $data['message'] = 'No update occur';
        $data['data'] = $request->all();
        return $data;
      } else {
        $data['status'] = 'failed';
        $data['message'] = $r;
        return $data;
      }
    }
  }

  public function findBarcode()
  {
    $barcode = request('barcode');
    return DB::table('assets')
    ->join('location', 'assets.kod_lokasi', 'like', 'location.location_code')
    ->where('barcode', $barcode)
    ->select('assets.*', 'location_name', 'block_name')
    ->get();
    //return Assets::where('barcode',$barcode)->first();
  }

  public function resetBarcode(Request $request)
  {
    if ($request->has('id')) {
      $data['status'] = 'failed';

      $update = DB::table('assets')->where('id', $request->input('id'))->update(['barcode' => 'NULL']);

      if ($update == 1) {
        $data['status'] = 'success';
      }
    }
    return $data;
  }
}
