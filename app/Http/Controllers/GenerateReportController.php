<?php

namespace App\ Http\ Controllers;

use Illuminate\ Http\ Request;
use DB;
use PDF;
use App;

class GenerateReportController extends Controller {

	public function kewpa9(Request $request){

		$assets = App\Assets::where('barcode',$request->barcode)->first();
		$perihal = App\LaporanKerosakkan::where('barcode',$request->barcode)->first();
		$staf = App\Staff::where('email',$perihal->pelapor)->first();

		//return view('pdf.kewpa9',compact('assets'));

		$pdf = PDF::loadView( 'pdf.kewpa9', compact('assets','perihal','staf'), [],[
			'debug'=>true,
			'format'=> 'A4-P'
		]);

		return $pdf->stream( 'KEWPA9.pdf' );
	}

	public function kewpa11( Request $request ) {
		//dd($request->all());
		$data = (object)[];
		$data->bil = 1;
		$pemeriksa1 = [];
		$pemeriksa2 = [];

		$bangunan = $request->get( 'bangunan' );


		if ( filled( $bangunan ) ) {

			$location = App\Locations::where('short_name',$bangunan)->first();

			//return $location->block_code;

			if($location->aset == null){
				$search =  $location->block_code;
			}
			else{
				$search =  $location->aset;

			}



			$q = DB::table( 'assets' )->leftjoin( 'verifications', 'assets.id', '=', 'verifications.asset_id' );


			$q->where( 'kod_lokasi', 'like', '%/' . $search . '/%' );



			$q->select(
				'assets.id',
				'assets.sub_kategori',
				'assets.jenis',
				'assets.no_casis',
				'assets.no_siri_pendaftaran',
				'assets.kod_lokasi',
				'assets.pegawai',
				'verifications.kod_lokasi_sebenar',
				'verifications.status',
				'verifications.catatan'
			)
			//->limit(1)
			->orderBy('jenis_aset','asc')
			->orderBy('jenis','asc');
			//->paginate(500);



			$data->bangunan = $location->block_code;
			$data->short_name = $request->bangunan;
			$data->nama_bangunan = $location->block_name ;
			$data->total = $q->count();

			// if($data->total > 1000){
			// 	$assets = $q->paginate(500);
			// }
			// else{
			// 	$assets = $q->get();
			// }

			$assets = $q->get();





			//return $assets;


			$pemeriksa1 = @App\ Staff::where( 'email', App\ Locations::get_pegawai( $location->short_name, 1 ) )->select( 'nama', 'jawatan_hakiki' )->first();
			$pemeriksa2 = @App\ Staff::where( 'email', App\ Locations::get_pegawai( $location->short_name, 2 ) )->select( 'nama', 'jawatan_hakiki' )->first();

			if ( $data->total == 0 ) {
				//return $q->toSql();
				dd( 'No data found' );
			}
			//return $assets;
		} else {
			dd( 'No block selected' );
		}

		//return $assets;
		//$data->total = count( $assets );

		if(filled($request->type) && $request->type == 'stream'){
			ini_set( "pcre.backtrack_limit", "50000000000" );

			$pdf = PDF::loadView( 'pdf.kewpa10', compact('data', 'assets', 'pemeriksa1', 'pemeriksa2'), [],[
				'debug'=>true
			]);
			$filename = str_replace(' ','-','KEWPA11-'.$data->nama_bangunan.'.pdf');
			$pdf->save('pdf/'.$filename);
			return redirect('pdf/'. $filename);
		}
		else{
			return view('pdf.kewpa10', compact('data', 'assets', 'pemeriksa1', 'pemeriksa2'));
		}

	}

	public function kewpa11x( Request $request ) {
		$data = (object)[];
		$data->bil = 1;

		$bangunan = $request->get( 'bangunan' );


		if ( filled( $bangunan ) ) {
			$q = DB::table( 'assets' )->leftjoin( 'verifications', 'assets.id', '=', 'verifications.asset_id' )->where( 'assets.kod_lokasi', 'like', '%/' . $request->bangunan . '/%' )->where( function ( $query ) {
				$query->where( 'jenis_aset', 'I' )->orWhere( 'jenis_aset', 'R' );
			} )->select(
				'assets.id',
				'assets.no_siri_pendaftaran',
				'assets.sub_kategori',
				'assets.jenis',
				'assets.no_casis',
				'assets.kod_lokasi',
				'assets.pegawai',
				'verifications.kod_lokasi_sebenar',
				'verifications.status',
				'verifications.catatan',
				DB::raw( 'count(assets.jenis) as total' )
			)->groupBy( 'assets.jenis' );


			$assets = $q->get();
			$data->bangunan = $bangunan;
			$data->nama_bangunan = App\ Locations::get_block_name( $bangunan );

			//return $assets;

			$data->total = count( $assets );

			if ( $data->total == 0 ) {
				dd( 'No data found' );
			}

			$pemeriksa1 = App\ Staff::where( 'email', @App\ Locations::get_pegawai( $bangunan, 1 ) )->select( 'nama', 'jawatan_hakiki' )->first();
			$pemeriksa2 = App\ Staff::where( 'email', @App\ Locations::get_pegawai( $bangunan, 2 ) )->select( 'nama', 'jawatan_hakiki' )->first();
		} else {
			dd( 'No block selected' );
		}

		//return $assets;

		//dd($assets);
		//$data->total = count( $assets );
		if(filled($request->type) && $request->type == 'stream'){
			ini_set("pcre.backtrack_limit", "50000000");
			$pdf = PDF::loadView( 'pdf.kewpa11', compact('data', 'assets', 'pemeriksa1', 'pemeriksa2'), [], [
				'format' => 'A4-L',
				'display_mode' => 'fullpage'
			] );

			return $pdf->stream( 'KEWPA11 - '.$data->nama_bangunan.'.pdf' );
		}
		else{
			return view('pdf.kewpa11', compact('data', 'assets', 'pemeriksa1', 'pemeriksa2'));
		}

		//$pdf->strcode2utf("&#x2713;");


	}
}
