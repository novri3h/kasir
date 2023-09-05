<?php  
	include "../config/koneksi.php";
	include "../library/fungsi.php";
	@session_start();
	date_default_timezone_set("Asia/Jakarta");

	@$aksi = new oop();
	@$table = "qw_barang_masuk";
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
	<title>Cetak Pembelian Bulan <?php echo $bulaninitext." ".$thn; ?></title>
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
				 	<td colspan="7" align="center"><h3 align="center">Daftar Pembelian Barang - Bulan <?php echo @$bulaninitext." ".@$thn; ?></h3></td>
				</tr>

				<tr>
					<th width="5%"  style="border:1px solid black">No.</th>
					<th width="10%"  style="border:1px solid black">No.Pembelian</th>
					<th width="10%"  style="border:1px solid black">Tanggal</th>
					<th width="5%"  style="border:1px solid black">Kode Barang</th>
					<th width="5%"  style="border:1px solid black">Nama Barang</th>
					<th width="6%" style="border:1px solid black">Satuan</th>
					<th  style="border:1px solid black">Supplier</th>
					<th width="10%" style="border:1px solid black">Harga</th>
					<th  width="5%"  style="border:1px solid black">Jumlah</th>
					<th  width="17%"  style="border:1px solid black">Total Harga</th>
				</tr>
			</thead>
			<tbody>
				<?php  
					$sql = $aksi->tampil($table,$cari,"ORDER BY kd_barang_masuk DESC");
					@$no = 0;
					if ($sql =="") {
						echo "<tr><td align='center' colspan='10'><b>Data Tidak Ada</b></td></tr>";
					}else{
						foreach ($sql as $data) {
							$no++;
				?>
					<tr>
						<td align="center" style="border:1px solid black"><?php echo $no; ?>.</td>
						<td align="center" style="border:1px solid black"><?php echo $data[0]; ?></td>
						<td align="center" style="border:1px solid black"><?php echo $data[8]; ?></td>
						<td align="center" style="border:1px solid black"><?php echo $data[2]; ?></td>
						<td align="center" style="border:1px solid black"><?php echo $data[3]; ?></td>
						<td align="center" style="border:1px solid black"><?php echo $data[4]; ?></td>
						<td align="center" style="border:1px solid black"><?php echo $data[9]; ?></td>
						<td align="right" style="border:1px solid black"><?php echo number_format($data[5],0,'','.'); ?></td>
						<td align="right" style="border:1px solid black"><?php echo number_format($data[6],0,'','.'); ?></td>
						<td align="right" style="border:1px solid black"><?php echo number_format($data[7],0,'','.');?></td>
					</tr>
				<?php } } 
					@$ttl = mysql_query("SELECT SUM(total_harga) AS total_seluruh FROM qw_barang_masuk WHERE MONTH(tanggal)='$bln' AND YEAR(tanggal)='$thn'");
					@$tl = mysql_fetch_array($ttl);
					@$total = $tl['total_seluruh'];
				?>
				<tr>
					<td colspan="9" align="right" style="border:1px solid black"><b>Total Pembelian Barang :</b></td>
					<td align="right" style="border:1px solid black"><b>Rp. <?php echo number_format(@$total,0,'','.'); ?></b></td>
				</tr>
			</tbody>

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