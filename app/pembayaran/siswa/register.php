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
if($user === "" || $role !== "KUR0004"){	
	$_SESSION['error_msg'] = "You should login to access the page";
	echo'<script>window.location="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '";</script>';
}else{

?>
<?php require($_SERVER['DOCUMENT_ROOT'].'/header.php'); ?>

<?php

$datauser = $con->query("SELECT * FROM kmn_user WHERE USERNAME='" . $user . "'");
$readuser = $datauser->fetch_array();

$datasiswa = $con->query("SELECT * FROM kmn_siswa WHERE ID_PENGGUNA='" . $readuser['ID_PENGGUNA'] . "'");
$readsiswa = $datasiswa->fetch_array();

$id = $readsiswa['ID_SISWA'];
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
						
							if(isset($_POST['register'])){
								$nobayar = "KP" . autoNumberPembayaran('NO_PEMBAYARAN','kmn_pembayaran');
								$idsiswa = $_POST['idsiswa'];
								$akun = $_POST['akun'];
								$bulan = $_POST['bulan'];
								$tahun = $_POST['tahun'];
								$tanggal = $_POST['tanggal'];
								$jam = $_POST['jam'] . ":" . $_POST['menit'];
								$bayar = $_POST['bayar'];
								$tujuantf = $_POST['tujuantf'];
								$metodetf = $_POST['metodetf'];
								$catatan = $_POST['catatan'];
								
								//handling bukti
								if(isset($_FILES['buktitf'])){
								
								$filename = $nobayar."_".$_FILES['buktitf']['name'];
								$path = 'http://localhost/assets/uploads/';
								move_uploaded_file($_FILES['buktitf']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/'.$nobayar."_".$_FILES['buktitf']['name']);
								$bukti = $path.$filename;
								
								}

								$sql = "INSERT INTO kmn_pembayaran VALUES ('" . $idsiswa . "','" .$nobayar . "','" .$akun . "','" . $bayar . "','" . $tanggal . "','" . $jam . "','" . $tujuantf . "','" . $metodetf . "','" . $bulan . "','" . $tahun . "','" . $catatan . "','0','Siswa','" . $bukti . "')";

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

							}
						?>
				
					</div>
                </div>
				<?php
											
					if ($id != NULL){
					
						$readsiswa = "SELECT * FROM kmn_siswa WHERE ID_SISWA = '" . $id . "'";
						$datasiswa = $con->query($readsiswa);
						$getrowsiswa = $datasiswa->fetch_array();

					
				?>
                <div class="row">
                    <div class="col-lg-6">

                        <form role="form" action="" method="post" enctype="multipart/form-data">
														
							<div class="form-group">
                                <input class="form-control" name="idsiswa" type="hidden" readonly="readonly" style="background-color: #fff;" value="<?php echo $getrowsiswa['ID_SISWA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Nama Siswa</label>
                                <input class="form-control" name="nama" type="text" readonly="readonly" style="background-color: #fff;" value="<?php echo $getrowsiswa['NAMA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Nama Akun Bank</label>
                                <input class="form-control" name="akun" type="text">
                            </div>
							
							<div class="form-group">
                                <label>Jumlah</label>
                                <input class="form-control" name="bayar" type="text" style="width: 50%;" placeholder="Enter Jumlah Pembayaran">
                            </div>
							
							
							<div class="form-group" >
								<div id="pilihtanggal">
                                <label>Tanggal</label>
                                <input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="Format : TTTT-BB-HH" />
								</div>
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
                                <label>Transfer Ke</label>
                                <select class="form-control" name="tujuantf" style="width: auto;">
									<option value="1">BCA</option>
									<option value="2">Mandiri</option>
									<option value="3">BNI</option>
								</select>
							</div>
							
							
						
					</div>
					<div class="col-lg-6">
							
							<div class="form-group">
                                <label>Metode Transfer</label>
                                <select class="form-control" name="metodetf" style="width: auto;">
									<option value="1">Internet Banking</option>
									<option value="2">m-Banking</option>
									<option value="3">ATM</option>
									<option value="4">Setor Tunai</option>
								</select>
							</div>
							
							<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Untuk Pembayaran</h3>
                            </div>
                            <div class="panel-body collapse in" id="demo" >
								<div class="row">
									<div class="col-sm-6">
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
							
							<div class="form-group">
                                <label>Bukti Transfer</label>
                                <input type="file" name="buktitf">
                            </div>
							
							<div class="form-group">
                                <label>Catatan</label>
                                <textarea name="catatan" class="form-control" rows="3"></textarea>
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
	<link rel="stylesheet" href="/assets/plugin/chosen/bootstrap-chosen.css" type="text/css">
	
	<script src="/assets/plugin/datepicker/js/jquery-ui.js"></script>
	<script src="/assets/plugin/chosen/chosen.jquery.js"></script>
	<script>
		$('#tanggal').datepicker({
			dateFormat: "yy-mm-dd",
			changeMonth: true,
			changeYear: true
		});
		
		
		$(function() {
		$('.chosen-select').chosen();
		});
    
	</script>

<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>