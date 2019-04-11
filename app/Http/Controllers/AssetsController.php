<?php

namespace App\Http\Controllers;

use Illuminate\Support\MessageBag;
use DB;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Assets;

class AssetsController extends Controller
{
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
