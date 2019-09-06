<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/database.php');

if(isset($_POST['dari']) && isset($_POST['ke'])){
	if(!empty($_POST['dari']) && !empty($_POST['ke'])){
		$datahasil = $con->query("SELECT * FROM kmn_hasilbelajar WHERE TGL_TEST BETWEEN '" . $_POST['dari'] . "' AND '" . $_POST['ke'] . "'");
	}else{
		$datahasil = $con->query("SELECT * FROM kmn_hasilbelajar");
	}
}else{
	$datahasil = $con->query("SELECT * FROM kmn_hasilbelajar");
}
// The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=report.xls");
 
// Add data table

?>

<table border="1">
    <tr>
    	<th>ID Siswa</th>
		<th>Nama</th>
		<th>Lulus Level</th>
		<th>Tanggal</th>
		<th>Skor</th>
		<th>Waktu</th>
	</tr>
	
		<?php
		while($readdata = $datahasil->fetch_array()){
		?>
		<tr>
		<td><?php echo $readdata['ID_SISWA']; ?></td>
		<?php
			$datasiswa = $con->query("SELECT * FROM kmn_siswa WHERE ID_SISWA = '" . $readdata['ID_SISWA'] . "'");
			$readsiswa = $datasiswa->fetch_array();
		?>
		<td><?php echo $readsiswa['NAMA']; ?></td>
		<?php
			$datalevel = $con->query("SELECT * FROM kmn_levelkelas WHERE ID_LEVELKELAS = '" . $readdata['ID_LEVELKELAS'] . "'");
			$readlevel = $datalevel->fetch_array();
		?>
		<td><?php echo $readlevel['MATA_PELAJARAN'] . " - " .$readlevel['NAMA_LEVEL']; ?></td>
		<td><?php echo $readdata['TGL_TEST']; ?></td>
		<td><?php echo $readdata['SKOR']; ?></td>
		<td><?php echo $readdata['WAKTU']; ?></td>
		</tr>
		<?php
		}
		?>
	
</table>