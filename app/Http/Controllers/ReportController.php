<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function listkewpa9(){
      $rosak =\App\LaporanKerosakkan::all();
      return view('reportkewpa9',compact('rosak'));
    }

    public function deletekewpa9($id){
      \App\LaporanKerosakkan::destroy($id);
      return redirect()->route('report.kerosakan');
    }
}
