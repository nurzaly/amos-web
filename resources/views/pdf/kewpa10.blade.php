<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>KEW.PA 11 - {{$data->nama_bangunan}}	</title>
	<link rel="stylesheet" href="css/report.css">
</head>

<body style="font-family: Arial;">
	<htmlpageheader name="letterheader">
		@php $pagenum =  '{PAGENO}' @endphp
		<table width="100%">
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td colspan="3" align="right">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td width="48%" align="left">
													<h5>Pekeliling Perbendaharaan Malaysia</h5>
												</td>
												<td width="52%" align="right">
													<h5>AM 2.4 Lampiran C</h5>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="3" align="right">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" align="right"><strong>KEW.PA-11</strong>
								</td>
							</tr>
							<tr>
							  <td colspan="3" align="right"><strong>No. Rujukan : .................................</strong></td>
						  </tr>
							<tr>
								<td colspan="3" align="center">
									<h2>BORANG PEMERIKSAAN ASET ALIH</h2> (Diisi oleh Pegawai Pemeriksa)</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td width="15%">Kementerian / Jabatan / PTJ</td>
								<td width="2%">:</td>
								<td>
									<table width="50%" border="0" cellspacing="0" cellpadding="5">
										<tbody>
											<tr>
												<td style="border-bottom: 1px solid black;">Kementerian Sumber Manusia / Jabatan Tenaga Manusia / ILP Sandakan</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td>Bahagian</td>
								<td>:</td>
								<td>
									<table width="50%" border="0" cellspacing="0" cellpadding="5">
										<tbody>
											<tr>
												<td style="border-bottom: 1px solid black;">{{$data->nama_bangunan}}</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>

	</htmlpageheader>


	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="border">

		<thead>
			<tr>
				<td width="5%" rowspan="2" align="center"><strong>Bil</strong></td>
				<td width="15%" rowspan="2" align="center"><strong>No. Siri Pendaftaran</strong></td>
				<td width="30%" rowspan="2" align="center"><strong>Jenis Aset</strong></td>
				<td width="20%" colspan="2" align="center"><strong>Lokasi</strong></td>
				<td width="20%" colspan="5" align="center"><strong>Status Aset</strong></td>
				<td width="10%" rowspan="2" align="center"><strong>Catatan</strong></td>
			</tr>

			<tr>
				<td width="10%" align="center"><strong>Mengikut<br> Rekod
				</strong></td>
				<td width="10%" align="center"><strong>Sebenar</strong></td>
				<td width="5%" align="center"><strong>A</strong></td>
				<td width="5%" align="center"><strong>B</strong></td>
				<td width="5%" align="center"><strong>C</strong></td>
				<td width="5%" align="center"><strong>D</strong></td>
				<td width="5%" align="center"><strong>E</strong></td>
			</tr>
		</thead>
		<tbody>
			@foreach($assets as $k => $v)
			<tr>
				{{-- <td align="center">{{$k + $assets->firstItem()}}</td> --}}
				<td align="center">{{$k + 1}}</td>
				<td align="center" style="text-transform:uppercase">{{$v->no_siri_pendaftaran}}</td>
				<td align="left" style="word-wrap:break-word;text-transform:capitalize;">{{$v->sub_kategori}}-{{$v->jenis}} {{$v->no_casis}} {{App\Assets::get_pegawai($v->pegawai)}}</td>
				<td align="center" style="word-wrap: break-word;">{{App\Locations::get_location_name($v->kod_lokasi)}}</td>
				<td align="center" style="word-wrap: break-word;">
					@if($v->kod_lokasi_sebenar !== null)
						{{App\Locations::get_location_name($v->kod_lokasi_sebenar,$v->kod_lokasi)}}
					@else
						{{App\Locations::get_location_name($v->kod_lokasi)}}
					@endif

				</td>
				<td align="center">@if(strpos($v->status,"0") !== false || $v->status == null)<img src="images/tick.png" width="10px">@else &nbsp; @endif</td>
				<td align="center">@if(strpos($v->status,"1") !== false)<img src="images/tick.png" width="10px">@else &nbsp; @endif</td>
				<td align="center">@if(strpos($v->status,"2") !== false)<img src="images/tick.png" width="10px">@else &nbsp; @endif</td>
				<td align="center">@if(strpos($v->status,"3") !== false)<img src="images/tick.png" width="10px">@else &nbsp; @endif</td>
				<td align="center" width="10">@if(strpos($v->status,"4") !== false)<img src="images/tick.png" width="10px">@else &nbsp; @endif</td>
				<td align="center">{{$v->catatan}}
				</td>
			</tr>
			{{-- @if($pagenum === '10')
				@php
					break;
				@endphp
			@endif --}}
			@endforeach
		</tbody>

	</table>


	<htmlpagefooter name="letterfooter2">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td width="29%">
						<table width="70%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td style="padding-bottom: 4px;border-bottom: 1px dotted black;">&nbsp;</td>
								</tr>
								<tr>
									<td>(Tandatangan)</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
					<td width="33%">
						<table width="70%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td style="padding-bottom: 4px;border-bottom: 1px dotted black;">&nbsp;</td>
								</tr>
								<tr>
									<td>(Tandatangan)</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
					<td width="38%" rowspan="4" valign="middle">
						<table class="table2" width="90%" cellspacing="1" cellpadding="7" border="2">
							<tbody>
								<tr>
									<td align="left">
										<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: none;">
											<tbody>
												<tr>
													<td colspan="3">Nota :</td>
												</tr>
												<tr>
													<td colspan="3" align="left">Lokasi: Nyatakan lokasi aset mengikut rekod dan lokasi aset semasa pemeriksaan.													</td>
												</tr>
												<tr>
													<td colspan="3" align="left">Status Aset : :Tandakan <img src="images/tick.png" width="10px"> pada yang berkenaan.</td>
												</tr>
												<tr>
												  <td colspan="3" align="left">&nbsp;</td>
											  </tr>
												<tr>
													<td align="left">&nbsp;</td>
													<td align="left">A. </td>
													<td align="left">Sedang Digunakan - Aset sedang digunakan</td>
												</tr>
												<tr>
													<td align="left">&nbsp;</td>
													<td align="left">B. </td>
													<td align="left"> Tidak Digunakan - Aset dibeli tetapi disimpan / tidak digunakan</td>
												</tr>
												<tr>
												  <td align="left">&nbsp;</td>
												  <td align="left">C.</td>
												  <td align="left"> Perlu Pembaikan - Aset yang rosak</td>
											  </tr>
												<tr>
												  <td align="left">&nbsp;</td>
												  <td align="left">D.</td>
												  <td align="left"> Sedang Diselenggara - Aset dihantar untuk penyelenggaraan</td>
											  </tr>
												<tr>
												  <td align="left">&nbsp;</td>
												  <td align="left">E.</td>
												  <td align="left"> Hilang = Aset yang tidak ditemui dimana-mana lokasi.</td>
											  </tr>
												<tr>
												  <td colspan="3" align="left">&nbsp;</td>
											  </tr>
												<tr>
												  <td colspan="3" align="left">Catatan : Apa-apa maklumat tambahan berkenaan aset tersebut</td>
											  </tr>
											</tbody>
										</table>
										<p>&nbsp;</p>
								  </td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="70%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td style="padding-bottom: 4px; border-bottom: 1px dotted black;"><span class="nama_pegawai">{{@$pemeriksa1->nama}}</span>
									</td>
								</tr>
								<tr>
									<td><span>(Nama Pegawai Pemeriksa 1)</span>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
					<td>
						<table width="70%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td style="padding-bottom: 4px; border-bottom: 1px dotted black;"><span class="nama_pegawai">{{@$pemeriksa2->nama}}</span>
									</td>
								</tr>
								<tr>
									<td><span class="nama_pegawai_line">(Nama Pegawai Pemeriksa 2)</span>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="70%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td style="padding-bottom: 4px; border-bottom: 1px dotted black;text-transform:capitalize;"><span>{{@$pemeriksa1->jawatan_hakiki}}</span>
									</td>
								</tr>
								<tr>
									<td><span>(Jawatan)</span>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
					<td>
						<table width="70%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td style="padding-bottom: 4px; border-bottom: 1px dotted black;text-transform:capitalize;">{{@$pemeriksa2->jawatan_hakiki}}</td>
								</tr>
								<tr>
									<td><span class="nama_pegawai_line">(Jawatan)</span>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="70%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td style="padding-bottom: 4px; border-bottom: 1px dotted black;">&nbsp;</td>
								</tr>
								<tr>
									<td><span class="nama_pegawai_line">(Tarikh Pemeriksaan)</span>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
					<td>
						<table width="70%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td style="padding-bottom: 4px; border-bottom: 1px dotted black;">&nbsp;</td>
								</tr>
								<tr>
									<td><span class="nama_pegawai_line">(Tarikh Pemeriksaan)</span>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
				  <td colspan="3" align="center">M.S {PAGENO}/{nbpg}</td>
			  </tr>
			</tbody>
		</table>
	</htmlpagefooter>
	@if(!app('request')->input('type') == 'stream')
		{{-- {{$assets->appends($_GET)->links()}} --}}

	<div class="btn_print"><a href="/amos/kewpa11?bangunan={{$data->short_name}}&type=stream">PRINT</a></div>
@endif
</body>

</html>
