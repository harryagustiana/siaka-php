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

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Edit Pembayaran
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/pembayaran/admin/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Edit Pembayaran
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-12">
				
						<?php
						
							require($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
							
							$id = $_GET['id'];
							
							if(isset($_POST['edit'])){
								$bulan = $_POST['bulan'];
								$tahun = $_POST['tahun'];
								$tanggal = $_POST['tanggal'];
								$jam = $_POST['jam'] . ":" . $_POST['menit'];
								$bayar = $_POST['bayar'];
								$status = $_POST['status'];
																
								//handling bukti
								if(isset($_FILES['buktitf']) && $_FILES['buktitf']['size'] > 0){
									//echo $_FILES['buktitf']['type'];
									$filename = $id."_".$_FILES['buktitf']['name'];
									$path = 'http://localhost/assets/uploads/';
									move_uploaded_file($_FILES['buktitf']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/'.$id."_".$_FILES['buktitf']['name']);
									$bukti = $path.$filename;
									
									$sqlupdate = "UPDATE kmn_pembayaran SET BULAN='".$bulan."', TAHUN='".$tahun."', TGL_BAYAR='".$tanggal."', JAM_BAYAR='".$jam."', JUMLAH='".$bayar."', STATUS='".$status."', FOTO_BUKTI='".$bukti."' WHERE NO_PEMBAYARAN = '".$id."'";
								
								}else{
									$sqlupdate = "UPDATE kmn_pembayaran SET BULAN='".$bulan."', TAHUN='".$tahun."', TGL_BAYAR='".$tanggal."', JAM_BAYAR='".$jam."', JUMLAH='".$bayar."', STATUS='".$status."' WHERE NO_PEMBAYARAN = '".$id."'";
								}
								
								
								if ($con->query($sqlupdate) == TRUE) {
									echo "<div class=\"alert alert-success\">";
									echo "<strong>Data</strong> has been updated";
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

					$sqlread = "SELECT * FROM kmn_pembayaran WHERE NO_PEMBAYARAN = '" . $id . "'";
					$read = $con->query($sqlread);
					$getROW = $read->fetch_array();
					
					$sqlsiswa = "SELECT * FROM kmn_siswa WHERE ID_SISWA = '" . $getROW['ID_SISWA'] . "'";
					$readsiswa = $con->query($sqlsiswa);
					$getROWsiswa = $readsiswa->fetch_array();

					$con->close();
					
				?>

                <div class="row">
                    <div class="col-lg-4">

                        <form role="form" action="" method="post" enctype="multipart/form-data">
							
							<div class="form-group">
                                <label>ID Siswa</label>
                                <input class="form-control" name="idsiswa" type="text" readonly="readonly" style="background-color: #fff;" value="<?php echo $getROW['ID_SISWA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Nama</label>
                                <input class="form-control" name="nama" type="text" readonly="readonly" style="background-color: #fff;" value="<?php echo $getROWsiswa['NAMA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Kelas</label>
                                <input class="form-control" name="kelas" type="text" readonly="readonly" style="background-color: #fff;" value="<?php echo $getROWsiswa['KELAS']; ?>">
                            </div>
							
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
													$m == $getROW['BULAN']? $selected = "selected=\"selected\"" : $selected = "";
											?>
												<option value="<?= $m ?>" <?= $selected ?>><?= $month ?></option>
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
													$firstyear == $getROW['TAHUN']? $selected = "selected=\"selected\"" : $selected = "";
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
                                <input type="text" class="form-control" style="width: 50%;" name="tanggal" value="<?php echo $getROW['TGL_BAYAR']; ?>" />
							</div>
							
							<div class="form-group">
								<label>Jam</label>
								<div class="form-inline">
								<select class="form-control" name="jam"  style="width:auto;">
									<?php for($i = 0; $i < 24; $i++){  
											$i < 10 ? $jam = "0" . $i : $jam = $i;
											$jam == substr($getROW['JAM_BAYAR'],0,2)? $selectedjam = "selected=\"selected\"" : $selectedjam = "";
									?>
											<option value="<?= $i; ?>" <?php echo $selectedjam; ?>><?= $jam ?></option>
									<?php } ?>
								</select>
								<select class="form-control" name="menit"  style="width:auto;">
									<?php for($i = 0; $i < 60; $i++){  
											$i < 10 ? $menit = "0" . $i : $menit = $i;
											$menit == substr($getROW['JAM_BAYAR'],3,2)? $selectedmenit = "selected=\"selected\"" : $selectedmenit = "";
									?>
											<option value="<?= $menit; ?>" <?php echo $selectedmenit; ?>><?= $menit ?></option>
									<?php } ?>
								</select>
								</div>
							</div>
							
							<div class="form-group">
                                <label>Jumlah</label>
                                <input class="form-control" name="bayar" type="text" style="width: 50%;" value="<?php echo $getROW['JUMLAH']; ?>">
                            </div>
							
							<div class="form-group">
								<label>Status</label>
								<select class="form-control" name="status" style="width:auto;">
									<?php 
										if ($getROW['STATUS'] == 0) {
											echo "<option value=\"0\" selected=\"selected\">Pending</option>";
											echo "<option value=\"1\" >Lunas</option>";
										}else{
											echo "<option value=\"0\" >Pending</option>";
											echo "<option value=\"1\" selected=\"selected\">Lunas</option>";
										}
									?>
								</select>
							</div>
					
					</div>
	
					<div class="col-lg-4">
							
							<div class="form-group">
                                <label>Bukti Transfer</label>
								<?php
									if($getROW['FOTO_BUKTI'] != NULL) {
								?>
								<img src="<?php echo $getROW['FOTO_BUKTI']; ?>" width=100% height=auto />
								<?php
									}
									else{
										echo "<br/> Tidak ada bukti transfer";
									}
								?>
                                <input type="file" name="buktitf" style="margin-top: 10px;">
							</div>
							
							

                            <button type="submit" class="btn btn-primary" name="edit">Update</button>
                            

                        </form>

                    </div>
                    
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>