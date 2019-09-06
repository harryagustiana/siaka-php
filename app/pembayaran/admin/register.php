<?php
session_start();

if(isset($_SESSION['login_user'])){
	$user = $_SESSION['login_user'];
}else{
	$user = "";
}
if(isset($_SESSION['role'])){
	$role = $_SESSION['role'];
}else{
	$role = "";
}
if($user === "" || $role !== "KUR0003"){	
	$_SESSION['error_msg'] = "You should login to access the page";
	echo'<script>window.location="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '";</script>';
}else{

?>


<?php require($_SERVER['DOCUMENT_ROOT'].'/header.php'); ?>

<?php

if(isset($_GET['siswa'])){
	$id = $_GET['siswa'];
}else{
	$id = NULL;
}
?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Register Pembayaran
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/pembayaran/admin/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Register Pembayaran
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-12">
				
						<?php
						
							require($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
							if(isset($_POST['register'])){
								$nobayar = "KP" . autoNumberPembayaran('NO_PEMBAYARAN','kmn_pembayaran');
								$idsiswa = $_POST['idsiswa'];
								$bulan = $_POST['bulan'];
								$tahun = $_POST['tahun'];
								$tanggal = $_POST['tanggal'];
								$jam = $_POST['jam'] . ":" . $_POST['menit'];
								$bayar = $_POST['bayar'];

								$sql = "INSERT INTO kmn_pembayaran (ID_SISWA,NO_PEMBAYARAN,JUMLAH,TGL_BAYAR,JAM_BAYAR,BULAN,TAHUN,STATUS,JENIS_PEMBAYARAN) VALUES ('" . $idsiswa . "','" .$nobayar . "','" . $bayar . "','" . $tanggal . "','" . $jam . "','" . $bulan . "','" . $tahun . "','1','Admin')";

								if ($con->query($sql) === TRUE) {
									echo "<div class=\"alert alert-success\">";
									echo "<strong>New class</strong> created successfully";
									echo "</div>";
								} 
								else {
									echo "<div class=\"alert alert-danger\">";
									echo "Error: " . $sql . "<br>" . $con->error;
									echo "</div>";
								}

								$con->close();
							}
						?>
				
					</div>
                </div>
				<?php
						
					require($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
					
					if ($id != NULL){
					
						$readsiswa = "SELECT * FROM kmn_siswa WHERE ID_SISWA = '" . $id . "'";
						$datasiswa = $con->query($readsiswa);
						$getrowsiswa = $datasiswa->fetch_array();

						//$con->close();
					
				?>
                <div class="row">
                    <div class="col-lg-4">

                        <form role="form" action="" method="post">
							
							<div class="form-group">
                                <label>ID Siswa</label>
                                <input class="form-control" name="idsiswa" type="text" readonly="readonly" style="background-color: #fff;" value="<?php echo $getrowsiswa['ID_SISWA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Nama</label>
                                <input class="form-control" name="nama" type="text" readonly="readonly" style="background-color: #fff;" value="<?php echo $getrowsiswa['NAMA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Kelas</label>
                                <input class="form-control" name="kelas" type="text" readonly="readonly" style="background-color: #fff;" value="<?php echo $getrowsiswa['KELAS']; ?>">
                            </div>
					
					</div>
					<div class="col-lg-4">
						<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Untuk Pembayaran</h3>
                            </div>
                            <div class="panel-body collapse in" id="demo" >
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label>Bulan</label>
											<select class="form-control" name="bulan" style="width: auto;">
											<?php
												for($m = 1;$m <= 12; $m++){ 
													$month =  date("F", mktime(0, 0, 0, $m, 1));
											?>
												<option value="<?= $m ?>"><?= $month ?></option>
											<?php
												}
											?>
											</select>
										</div>
										
										<div class="form-group">
											<label>Tahun</label>
											<select class="form-control" name="tahun" style="width:auto;">
											<?php
												$firstyear = 2010;
												$currentyear = date('Y');
												while ($firstyear <= $currentyear){
													$firstyear == $currentyear? $selected = "selected=\"selected\"" : $selected = "";
											?>
												<option value="<?php echo $firstyear; ?>" <?php echo $selected; ?>><?php echo $firstyear; ?></option>
											<?php
													$firstyear++;
												}
											?>
											</select>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					
					</div>
					<div class="col-lg-4">
							
							<div class="form-group">
                                <label>Tanggal</label>
                                <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Format : TTTT-BB-HH" />
							</div>
							
							
							<div class="form-group">
								<label>Jam</label>
								<div class="form-inline">
								<select class="form-control" name="jam"  style="width:auto;">
									<?php for($i = 0; $i < 24; $i++){  
											$i < 10 ? $jam = "0" . $i : $jam = $i;
									?>
											<option value="<?= $i; ?>"><?= $jam ?></option>
									<?php } ?>
								</select>
								<select class="form-control" name="menit"  style="width:auto;">
									<?php for($i = 0; $i < 60; $i++){  
											$i < 10 ? $menit = "0" . $i : $menit = $i;
									?>
											<option value="<?= $menit; ?>"><?= $menit ?></option>
									<?php } ?>
								</select>
								</div>
							</div>
							
							<div class="form-group">
                                <label>Jumlah</label>
                                <input class="form-control" name="bayar" type="text" placeholder="Enter Jumlah Pembayaran">
                            </div>

                            <button type="submit" class="btn btn-primary" name="register">Register</button>
                            

                        </form>

                    </div>
                    
                </div>
                <!-- /.row -->
				<?php
					}
					else{
				?>
				<div class="row">
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<p style="font-style:italic;"><strong>ID Siswa tidak ditemukan!</strong>. Silahkan pilih ID Siswa terlebih dahulu. Klik <a href="/app/pembayaran/admin/"><strong>di sini</strong></a> untuk menuju ke halaman utama Pembayaran</p>
						</div>
					</div>
					
				</div>
				<?php
					}
				?>
				
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	
	<link rel="stylesheet" href="/assets/plugin/datepicker/css/jquery-ui.css" type="text/css">
	
	<script src="/assets/plugin/datepicker/js/jquery-ui.js"></script>
	<script>
		$('#tanggal').datepicker({
			dateFormat: "yy-mm-dd",
			changeMonth: true,
			changeYear: true
		});    
	</script>

<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>