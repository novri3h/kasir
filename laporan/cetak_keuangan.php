<?php  
	include "../config/koneksi.php";
	include "../library/fungsi.php";
	@session_start();
	date_default_timezone_set("Asia/Jakarta");
	

	@$aksi = new oop();
	@$table = "tbl_keuangan";
	@$bln = $_GET['bln'];
	@$thn = $_GET['thn'];

	@$cari="WHERE MONTH(tanggal)='$bln' AND YEAR(tanggal)='$thn'";
	switch ($bln) {
		case '1': @$bulaninitext="Januari"; break;
		case '2': @$bulaninitext="Februari"; break;
		case '3': @$bulaninitext="Maret"; break;
		case '4': @$bulaninitext="April"; break;
		case '5': @$bulaninitext="Mei"; break;
		case '6': @$bulaninitext="Juni"; break;
		case '7': @$bulaninitext="Juli"; break;
		case '8': @$bulaninitext="Agustus"; break;
		case '9': @$bulaninitext="September"; break;
		case '10': @$bulaninitext="Oktober"; break;
		case '11': @$bulaninitext="Novemmber"; break;
		case '12': @$bulaninitext="Desember"; break;
		default: @$bulaninitext=""; break;
	}

	$blnini=date("m");
	switch ($blnini) {
		case '1': @$blnskrg="Januari"; break;
		case '2': @$blnskrg="Februari"; break;
		case '3': @$blnskrg="Maret"; break;
		case '4': @$blnskrg="April"; break;
		case '5': @$blnskrg="Mei"; break;
		case '6': @$blnskrg="Juni"; break;
		case '7': @$blnskrg="Juli"; break;
		case '8': @$blnskrg="Agustus"; break;
		case '9': @$blnskrg="September"; break;
		case '10': @$blnskrg="Oktober"; break;
		case '11': @$blnskrg="Novemmber"; break;
		case '12': @$blnskrg="Desember"; break;
		default: @$blnskrg=""; break;
	}
	$hrini=date("N");
	switch ($hrini) {
		case '1': @$hrskrg="Senin"; break;
		case '2': @$hrskrg="Selasa"; break;
		case '3': @$hrskrg="Rabu"; break;
		case '4': @$hrskrg="Kamis"; break;
		case '5': @$hrskrg="Jumat"; break;
		case '6': @$hrskrg="Sabtu"; break;
		case '7': @$hrskrg="Minggu"; break;
		default: @$hrskrg=""; break;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, intial-scale=1">
	<title>Cetak Pemasukan dan Pengeluaran Keuangan - Bulan <?php echo $bulaninitext." ".$thn; ?></title>
	<link rel="icon" href="../img/logo1.png">
<body onload="window.print()" style="font-family:'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma,  sans-serif;width:21cm;">
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
			<thead>
				<tr>
				 	<td colspan="2"><img src="http://localhost/e-kasir/img/logo1.png" alt="logo" width="90" height="60"></td>
				 	<td colspan="5">
					 <h1 style="margin:0">e-KASIR</h1>
					 <h4 style="margin:0;margin-top:4px;">Jl. Alamat Toko Anda</h4>
				 	</td>
				</tr>
				
				<tr><td colspan="7"><hr></td></tr>
				
				<tr>
				 	<td colspan="7" align="center"><h3 align="center">Daftar Pemasukan dan Pengeluaran Keuangan - Bulan <?php echo @$bulaninitext." ".@$thn; ?></h3></td>
				</tr>

				<tr>
					<th width="5%"  style="border:1px solid black">No.</th>
					<th width="15%"  style="border:1px solid black">Tanggal</th>
					<th style="border:1px solid black">Jenis Keuangan</th>
					<th width="16%"  style="border:1px solid black">Masuk</th>
					<th width="16%"  style="border:1px solid black">Keluar</th>
					<th width="16%"  style="border:1px solid black">Saldo</th>
				</tr>
			</thead>
			<tbody>
				<?php  
					$sql = $aksi->tampil($table,$cari,"ORDER BY waktu ASC");
					@$no = 0;
					if ($sql =="") {
						echo "<tr><td align='center' colspan='6'><b>Data Tidak Ada</b></td></tr>";
					}else{
						foreach ($sql as $data) {
							$no++;
				?>
					<tr>
						<td align="center" style="border:1px solid black"><?php echo $no; ?>.</td>
						<td align="center" style="border:1px solid black"><?php echo $data[2]; ?></td>
						<td align="center" style="border:1px solid black"><?php echo $data[4]; ?></td>
						<td align="right" style="border:1px solid black;padding-right:10px"><?php echo number_format($data[5],0,'','.');?></td>
						<td align="right" style="border:1px solid black;padding-right:10px"><?php echo number_format($data[6],0,'','.');?></td>
						<td align="right" style="border:1px solid black;padding-right:10px">
							<?php 
								@$saldo = $saldo + $data['masuk']-$data['keluar'];
								echo number_format($saldo,0,'','.');
								@$m = mysql_fetch_array(mysql_query("SELECT SUM(masuk) as 'msk' FROM tbl_keuangan WHERE MONTH(tanggal)='$bln' AND YEAR(tanggal)='$thn'"));
								@$k = mysql_fetch_array(mysql_query("SELECT SUM(keluar) as 'klr' FROM tbl_keuangan WHERE MONTH(tanggal)='$bln' AND YEAR(tanggal)='$thn'"));
							?>
						</td>
					</tr>
				<?php } } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4" align="right" style="border:1px solid black"><b>Total Pemasukan :</b></td>
					<td colspan="2" align="right" style="border:1px solid black;padding-right:10px"><b>Rp. <?php echo number_format(@$m['msk'],0,'','.'); ?></b></td>
				</tr>
				<tr>
					<td colspan="4" align="right" style="border:1px solid black"><b>Total Pengeluaran :</b></td>
					<td colspan="2" align="right" style="border:1px solid black;padding-right:10px"><b>Rp. <?php echo number_format(@$k['klr'],0,'','.'); ?></b></td>
				</tr>
				<tr>
					<td colspan="4" align="right" style="border:1px solid black"><b>Saldo Akhir :</b></td>
					<td colspan="2" align="right" style="border:1px solid black;padding-right:10px"><b>Rp. <?php echo number_format(@$saldo,0,'','.'); ?></b></td>
				</tr>
			</tfoot>
		</table>
		<table align="right" style="margin-right:40px;">
			<tr><td rowspan="10" width="50px"></td><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td align="center"><?php echo $hrskrg.", ".date(" j ").$blnskrg.date(" Y "); ?></td>
			</tr>
			<tr>
				<td align="center">Hormat Saya,</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td align="center"><?php echo $_SESSION['nama']; ?></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
		</table>
</body>
</html>