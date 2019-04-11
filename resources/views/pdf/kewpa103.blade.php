<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>KEW.PA 10</title>
	<link rel="stylesheet" href="css/report.css">
</head>

<body style="font-family: Times New Roman;">
	<htmlpageheader name="letterheader">
		<table width="100%">
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td colspan="2" align="right">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td width="48%" align="left">
													<h5>Pekeliling Perbendaharaan Malaysia</h5>
												</td>
												<td width="52%" align="right">
													<h5>KP 2.4/2013 Lampiran C</h5>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="right">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align="right"><strong>KEW.PA-10</strong>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<h2>LAPORAN PEMERIKSAAN HARTA MODAL</h2> (diisi oleh Pegawai Pemeriksa)</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td width="20%">Kementerian / Jabatan</td>
								<td width="80%">
									<table width="50%" border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td style="border-bottom: 1px solid black;">: Kementerian Sumber Manusia / Jabatan Tenaga Manusia</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td>Bahagian</td>
								<td>
									<table width="50%" border="0" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td style="border-bottom: 1px solid black;">: {{$data->nama_bangunan}}</td>
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
				<td width="10" rowspan="3" align="center">Bil</td>
				<td width="100" rowspan="3" align="center">No. Siri Pendaftaran</td>
				<td rowspan="3" align="center">Jenis Harta Modal</td>
				<td colspan="2" rowspan="2" align="center">Lokasi</td>
				<td colspan="4" align="center">Daftar</td>
				<td width="14%" rowspan="3" align="center">Keadaan Harta Modal</td>
				<td width="15%" rowspan="3" align="center">Catatan</td>
			</tr>

			<tr>
				<td colspan="2" align="center">Lengkap</td>
				<td colspan="2" align="center">Kemaskini</td>
			</tr>
			<tr>
				<td align="center">Mengikut<br> Rekod
				</td>
				<td width="7%" align="center">Sebenar</td>
				<td width="10" align="center">Ya</td>
				<td width="10" align="center">Tidak</td>
				<td width="10" align="center">Ya</td>
				<td width="10" align="center">Tidak</td>
			</tr>
		</thead>
		<tbody>
			@foreach($assets as $v)
			<tr>
				<td align="center">{{$data->bil++}}</td>
				<td align="center" style="text-transform:uppercase">{{$v->no_siri_pendaftaran}}</td>
				<td align="left" style="word-wrap:break-word; width:200px;text-transform:capitalize;">{{$v->sub_kategori}}-{{$v->jenis}} {{$v->no_casis}} {{App\Assets::get_pegawai($v->pegawai)}}</td>
				<td align="center" style="word-wrap: break-word; width:30px;">{{App\Locations::get_location_name($v->kod_lokasi)}}</td>
				<td align="center">{{App\Locations::get_location_name($v->kod_lokasi_sebenar)}}</td>
				<td align="center"><img src="images/tick.png" width="10px">
				</td>
				<td align="center">&nbsp;</td>
				<td align="center">{!!($v->kod_lokasi == $v->kod_lokasi_sebenar) ? "<img src='images/tick.png' width='10px'>" : "&nbsp;"!!}</td>
				<td align="center">{!!($v->kod_lokasi != $v->kod_lokasi_sebenar) ? "<img src='images/tick.png' width='10px'>" : "&nbsp;"!!}</td>
				<td align="center">{{$v->status}}</td>
				<td align="center">{{$v->catatan}}</td>
			</tr>
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
													<td colspan="2">Nota :</td>
												</tr>
												<tr>
													<td align="left">Lokasi</td>
													<td align="left">
														<p> :Nyatakan lokasi Harta Modal mengikut rekod dan lokasi Harta Modal semasa pemeriksaan.</p>
													</td>
												</tr>
												<tr>
													<td align="left">Daftar</td>
													<td align="left">:Tandakan <img src="images/tick.png" width="10px"> pada yang berkenaan.</td>
												</tr>
												<tr>
													<td align="left">Keadaan Harta Modal</td>
													<td align="left">:Nyatakan sama ada sedang digunakan atau tidak digunakan.</td>
												</tr>
												<tr>
													<td align="left">Catatan</td>
													<td align="left"> :Penjelasan kepada penemuan semasa pemeriksaan.</td>
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
			</tbody>
		</table>
	</htmlpagefooter>
	@if(!app('request')->input('type') == 'stream')
	<div class="btn_print"><a href="/amos/kewpa10?bangunan={{$data->bangunan}}&type=stream">PRINT</a></div>
@endif
</body>

</html>
