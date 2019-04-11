<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = (object)[];
        $veri = (object)[];

        $data->harta_modal = App\Assets::where('jenis_aset','H')->count();
        $data->inventori = App\Assets::where('jenis_aset','!=','H')->count();
        $data->blocks = App\Locations::select('short_name','block_code')->groupBy("short_name")->orderBy('block_code')->get();
        $data->n = 1;

        $assert_veri = App\Assets::join('verifications','assets.id','=','verifications.asset_id')->count();
        $assert_not_veri = $data->harta_modal + $data->inventori - $assert_veri;

        //App\Log::info($assert_not_veri);

        $veri->a = App\Verifications::where('status','like','%0%')->count() + $assert_not_veri;
        $veri->b = App\Verifications::where('status','like','%1%')->count();
        $veri->c = App\Verifications::where('status','like','%2%')->count();
        $veri->d = App\Verifications::where('status','like','%3%')->count();
        $veri->e = App\Verifications::where('status','like','%4%')->count();



        //return json_decode(json_encode($data), true);
        $pegawai_pemeriksa = App\Staff::where('amos','admin')->get();
        //return $pegawai_pemeriksa;

        return view('home',compact('data','pegawai_pemeriksa','veri'));
    }
}
