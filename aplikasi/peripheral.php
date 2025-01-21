<?php include('config.php'); ?>  
<script language="javascript">
function createRequestObject() {
	var ajax;
	if (navigator.appName == 'Microsoft Internet Explorer') {
		ajax = new ActiveXObject('Msxml2.XMLHTTP');
	} else {
		ajax = new XMLHttpRequest();
	}
	return ajax;
}

var http = createRequestObject();

function sendRequest(nomor) {
	if (nomor == "") {
		alert("Anda belum memilih Printer !");
	} else {
		http.open('GET', 'aplikasi/filterPeripheral.php?nomor=' + encodeURIComponent(nomor), true);
		http.onreadystatechange = handleResponse;
		http.send(null);
	}
}

function handleResponse() {
	if (http.readyState == 4) {
		var string = http.responseText.split('&&&');
		document.getElementById('nomor').value = string[0];
		document.getElementById('id_perangkat').value = string[1];
		document.getElementById('perangkat').value = string[2];
		document.getElementById('keterangan').value = string[3];
		document.getElementById('divisi').value = string[4];
		document.getElementById('user').value = string[5];
		document.getElementById('lokasi').value = string[6];
		document.getElementById('tgl_perawatan').value = string[7];
		document.getElementById('bulan').value = string[8];
		document.getElementById('tipe').value = string[9];
		document.getElementById('brand').value = string[10];
		document.getElementById('model').value = string[11];
		document.getElementById('pembelian_dari').value = string[12];
		document.getElementById('sn').value = string[13];
	}
}
</script>


<?
function kdauto($tabel, $inisial) {
	$struktur = mysql_query("SELECT * FROM $tabel");
	$field = mysql_field_name($struktur, 0);
	$panjang = mysql_field_len($struktur, 0);

	$qry = mysql_query("SELECT max(" . $field . ") FROM " . $tabel);
	$row = mysql_fetch_array($qry);
	if ($row[0] == "") {
		$angka = 0;
	} else {
		$angka = substr($row[0], strlen($inisial));
	}

	$angka++;
	$angka = strval($angka);
	$tmp = "";
	for ($i = 1; $i <= ($panjang - strlen($inisial) - strlen($angka)); $i++) {
		$tmp = $tmp . "0";
	}
	return $inisial . $tmp . $angka;
}
?>
            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">

                        <h2> Data Master Barang Peripheral</h2>

                    </div>
                </div>

                <hr />


				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<button class="btn btn-primary" data-toggle="modal" data-target="#newReg">
									Tambah
								</button>
							</div>
							<div class="panel-body">
								<div class="table-responsive" style='overflow: scroll;'>
									<table class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th>Nomor</th>
												<th>ID Perangkat</th>
												<th>Nama Perangkat</th>
												<th>Tipe</th>
												<th>User</th>
												<th>Divisi</th>
												<th>Edit</th>
												<th>Hapus</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql = mysql_query("SELECT * FROM peripheral ORDER BY tipe");
											if (mysql_num_rows($sql) > 0) {
												while ($data = mysql_fetch_array($sql)) {
													$nomor = $data['nomor'];
													$id_perangkat = $data['id_perangkat'];
													$perangkat = $data['perangkat'];
													$user = $data['user'];
													$tipe = $data['tipe'];
													$divisi = $data['divisi'];
											?>
													<tr class="gradeC">
														<td><?php echo $nomor; ?></td>
														<td><?php echo $id_perangkat; ?></td>
														<td><?php echo $perangkat; ?></td>
														<td><?php echo strtoupper($tipe); ?></td>
														<td><?php echo strtoupper($user); ?></td>
														<td><?php echo $divisi; ?></td>
														<td class="center">
															<button class="btn btn-primary" value='<?php echo $nomor; ?>' data-toggle="modal" data-target="#newReggg" onclick="new sendRequest(this.value)">
																Edit
															</button>
														</td>
														<td class="center">
															<form action="aplikasi/deleteperipheral.php" method="post">
																<input type="hidden" name="nomor" value="<?php echo $nomor; ?>" />
																<button name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
															</form>
														</td>
													</tr>
											<?php
												}
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
     
	 <!-- popup modal tambah data -->
	<div class="col-lg-12">
		<div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="H4">Tambah Master Barang</h4>
					</div>
					<div class="modal-body">
						<form action="aplikasi/simpanPeripheral.php" method="post" enctype="multipart/form-data" name="postform2">
							<div class="form-group">
								<input class="form-control" type="hidden" name="nomor" value="<? echo kdauto('peripheral', ''); ?>" readonly>
							</div>
							<div class="form-group">
								ID Perangkat
								<input class="form-control" type="text" name="id_perangkat" placeholder="ID Perangkat">
							</div>
							<div class="form-group">
								Nama Perangkat
								<input class="form-control" type="text" name="perangkat" placeholder="Nama Perangkat">
							</div>
							<div class="form-group">
								Tipe
								<select class="form-control" name="tipe" required="required">
									<option value="Switch/Router">Switch / Router</option>
									<option value="kabel jaringan">Kabel Jaringan</option>
									<option value="server">Server</option>
									<option value="ups">UPS</option>
									<option value="access point">Access Point</option>
									<option value="proyektor">Proyektor</option>
									<option value="NVR/DVR">NVR / DVR</option>
									<option value="kamera">Kamera</option>
									<option value="fingerspot">Fingerspot</option>
									<option value="tablet">Tablet</option>
								</select>
							</div>
							<div class="form-group">
								Brand
								<input class="form-control" type="text" name="brand" placeholder="Brand">
							</div>
							<div class="form-group">
								Model
								<input class="form-control" type="text" name="model" placeholder="Model">
							</div>
							<div class="form-group">
								Pembelian Dari
								<input class="form-control" type="text" name="pembelian_dari" placeholder="Pembelian Dari">
							</div>
							<div class="form-group">
								Serial Number
								<input class="form-control" type="text" name="sn" placeholder="Serial Number">
							</div>
							<div class="form-group">
								Nama User
								<input class="form-control" type="text" name="nama_user" placeholder="Nama User">
							</div>
							<div class="form-group">
								Lokasi
								<input class="form-control" type="text" name="lokasi" placeholder="Lokasi">
							</div>
							<div class="form-group">
								Keterangan
								<input class="form-control" type="text" name="keterangan" placeholder="Keterangan">
							</div>
							<div class="form-group">
								Tanggal Perawatan
								<input class="form-control" type="date" name="tgl_perawatan">
							</div>
							<div class="form-group">
								Bulan Perawatan
								<select class="form-control" name="bulan">
									<option value=<? echo $id_bulan; ?>><? echo $namabulan; ?></option>
									<? $s2 = mysql_query("SELECT * FROM bulan");
									if (mysql_num_rows($s2) > 0) {
										while ($datas2 = mysql_fetch_array($s2)) {
											$id_bulan = $datas2['id_bulan'];
											$bulan = $datas2['bulan']; ?>
											<option value="<? echo $id_bulan; ?>"><? echo $bulan; ?></option>
									<? }
									} ?>
								</select>
							</div>
							<div class="form-group">
								Divisi
								<select class="form-control" name="divisi" required="required">
									<option value="GARMENT">GARMENT</option>
									<option value="TEXTILE">TEXTILE</option>
								</select>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="Submit" class="btn btn-danger" name="tombol">Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
					
	<!-- popup modal edit data -->		
	<div class="col-lg-12">
		<div class="modal fade" id="newReggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="H4">Edit Master</h4>
					</div>
					<div class="modal-body">
						<form action="aplikasi/updatePeripheral.php" method="post" enctype="multipart/form-data" name="postform2">
							<div class="form-group">
								<input class="form-control" type="hidden" name="nomor" id="nomor" readonly>
							</div>
							<div class="form-group">
								ID Perangkat
								<input class="form-control" type="text" name="id_perangkat" id="id_perangkat">
							</div>
							<div class="form-group">
								Perangkat
								<input class="form-control" type="text" name="perangkat" id="perangkat" placeholder="ID Perangkat">
							</div>
							<div class="form-group">
								Tipe
								<select class="form-control" name="tipe" id="tipe" required="required">
									<option value="Switch/Router">Switch / Router</option>
									<option value="kabel jaringan">Kabel Jaringan</option>
									<option value="server">Server</option>
									<option value="ups">UPS</option>
									<option value="access point">Access Point</option>
									<option value="proyektor">Proyektor</option>
									<option value="NVR/DVR">NVR / DVR</option>
									<option value="kamera">Kamera</option>
									<option value="fingerspot">Fingerspot</option>
									<option value="tablet">Tablet</option>
								</select>
							</div>
							<div class="form-group">
								Brand
								<input class="form-control" type="text" name="brand" id="brand" placeholder="Brand">
							</div>
							<div class="form-group">
								Model
								<input class="form-control" type="text" name="model" id="model" placeholder="Model">
							</div>
							<div class="form-group">
								Pembelian Dari
								<input class="form-control" type="text" name="pembelian_dari" id="pembelian_dari" placeholder="Pembelian Dari">
							</div>
							<div class="form-group">
								Serial Number
								<input class="form-control" type="text" name="sn" id="sn" placeholder="Serial Number">
							</div>
							<div class="form-group">
								Nama User
								<input class="form-control" type="text" name="user" id="user" placeholder="Nama User">
							</div>
							<div class="form-group">
								Lokasi
								<input class="form-control" type="text" name="lokasi" id="lokasi" placeholder="Lokasi">
							</div>
							<div class="form-group">
								Keterangan
								<input class="form-control" type="text" name="keterangan" id="keterangan" placeholder="Keterangan">
							</div>
							<div class="form-group">
								Tanggal Perawatan
								<input class="form-control" type="date" name="tgl_perawatan" id="tgl_perawatan">
							</div>
							<div class="form-group">
								Bulan Perawatan
								<select class="form-control" name="bulan" id="bulan" required="required">
									<option value=""></option>
									<option value="01">JANUARI</option>
									<option value="02">FEBRUARI</option>
									<option value="03">MARET</option>
									<option value="04">APRIL</option>
									<option value="05">MEI</option>
									<option value="06">JUNI</option>
									<option value="07">JULI</option>
									<option value="08">AGUSTUS</option>
									<option value="09">SEPTEMBER</option>
									<option value="10">OKTOBER</option>
									<option value="11">NOVEMBER</option>
									<option value="12">DESEMBER</option>
									<option value="00">ALL BULAN</option>
								</select>
							</div>
							<div class="form-group">
								Divisi
								<select class="form-control" name="divisi" id="divisi" required="required">
									<option value="GARMENT">GARMENT</option>
									<option value="TEXTILE">TEXTILE</option>
								</select>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-danger" name="tombol">Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
