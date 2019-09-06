<?php
if(isset($_GET['tahun'])){
	$tahun = $_GET['tahun'];
}
// The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=pembayaran-" . $tahun . ".xls");
 
// Add data table
require_once($_SERVER['DOCUMENT_ROOT'].'/config/database.php');

$databayar = $con->query("SELECT * FROM kmn_pembayaran WHERE TAHUN = '" . $tahun . "'");
?>

<table border="1">
    <tr>
    	<th>No Pembayaran</th>
		<th>ID Siswa</th>
		<th>Nama Siswa</th>
		<th>Jumlah Bayar</th>
		<th>Bulan</th>
		<th>Tahun</th>
		<th>Tanggal Pembayaran</th>
		<th>Status</th>
	</tr>
	
		<?php
		while($readbayar = $databayar->fetch_array()){
		?>
		<tr>
		<td><?php echo $readbayar['NO_PEMBAYARAN']; ?></td>
		<td><?php echo $readbayar['ID_SISWA']; ?></td>
		<?php
			$datasiswa = $con->query("SELECT * FROM kmn_siswa WHERE ID_SISWA = '" . $readbayar['ID_SISWA'] . "'");
			$readsiswa = $datasiswa->fetch_array();
		?>
		<td><?php echo $readsiswa['NAMA']; ?></td>
		<td><?php echo $readbayar['JUMLAH']; ?></td>
		<td><?php echo date("F", mktime(0, 0, 0, $readbayar['BULAN'], 1)); ?></td>
		<td><?php echo $readbayar['TAHUN']; ?></td>
		<td><?php echo $readbayar['TGL_BAYAR']; ?></td>
		<td><?php $readbayar['STATUS'] == 0 ? $status = "Pending" : $status = "Lunas"; echo $status; ?></td>
		</tr>
		<?php
		}
		?>
	
</table>