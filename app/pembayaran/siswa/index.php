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
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Manage Pembayaran
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Manage Pembayaran
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<?php
					$datauser = $con->query("SELECT * FROM kmn_user WHERE USERNAME='" . $user . "'");
					$readuser = $datauser->fetch_array();
					
					$datasiswa = $con->query("SELECT * FROM kmn_siswa WHERE ID_PENGGUNA='" . $readuser['ID_PENGGUNA'] . "'");
					$readsiswa = $datasiswa->fetch_array();
					$idsiswa = $readsiswa['ID_SISWA'];
					
					if(isset($_POST['cari'])){
						if(isset($_POST['bulan'])){
							$res = $con->query("SELECT * FROM kmn_pembayaran WHERE BULAN LIKE '%" . $_POST['bulan'] . "%' AND ID_SISWA = '" . $idsiswa . "'");
						}
						elseif(isset($_POST['tahun'])){
							$res = $con->query("SELECT * FROM kmn_pembayaran WHERE TAHUN LIKE '%" . $_POST['tahun'] . "%' AND ID_SISWA = '" . $idsiswa . "'");
						}
						else{
							$res = $con->query("SELECT * FROM kmn_pembayaran WHERE ID_SISWA = '" . $idsiswa . "'");
						}
					}elseif(isset($_POST['reset'])){
						$res = $con->query("SELECT * FROM kmn_pembayaran WHERE ID_SISWA = '" . $idsiswa . "'");
					}else{
						$res = $con->query("SELECT * FROM kmn_pembayaran WHERE ID_SISWA = '" . $idsiswa . "'");
					}
					
				?>
				
				<div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a data-toggle="collapse" href="#demo" id="filter" style="text-decoration: none; color: #000;"><h3 class="panel-title"><i class="fa fa-bars" aria-hidden="true"></i> Filter Data</h3></a>
                            </div>
                            <div class="panel-body collapse" id="demo" >
								<div class="row">
									<div class="col-sm-6">
										<form role="form" action="" method="post">
											
											<div class="form-group">
												<div class="radio">
													<label>
														<input type="radio" onclick="document.getElementById('bulan').disabled = false; 
															document.getElementById('tahun').disabled = true; 
															document.getElementById('tahun').selectedIndex = -1;"
														name="opsiSearch" id="optionsRadios1" value="option1">Bulan
													</label>
												</div>
												<select class="form-control" name="bulan" id="bulan" disabled="disabled">
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
												<div class="radio">
													<label>
														<input type="radio" onclick="document.getElementById('tahun').disabled = false; 
															document.getElementById('bulan').disabled = true; 
															document.getElementById('bulan').selectedIndex = -1;"
														name="opsiSearch" id="optionsRadios1" value="option1">Tahun
													</label>
												</div>
												<select class="form-control" name="tahun" id="tahun" disabled="disabled">
												<?php
													$firstyear = 2010;
													$currentyear = date('Y');
													while ($firstyear <= $currentyear){
												?>
													<option value="<?php echo $firstyear; ?>"><?php echo $firstyear; ?></option>
												<?php
														$firstyear++;
													}
												?>
												</select>
											</div>
										
									</div>
									
								</div>
								
								<div class="row">
									<div class="col-sm-12">
											<button type="submit" class="btn btn-primary" name="cari">Cari</button>
											
											<button type="submit" class="btn btn-default" name="reset">Reset</button>
									</div>
								</div>
								
								</form>
                            </div>
                        </div>
					</div>
				</div>
				
                <div class="row">
                    <div class="col-lg-12">
                        <a href="register.php?siswa=<?php echo $idsiswa; ?>" type="button" class="btn btn-success" name="confirmregister" data-toggle="modal" style="margin-bottom: 20px;">Konfirmasi Pembayaran</a>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
										<th>Bulan</th>
										<th>Tahun</th>
										<th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
										
										while($row = $res->fetch_array())
										{
									?>
                                    <tr>
                                        <td><?php echo date("F", mktime(0, 0, 0, $row['BULAN'], 1)); ?></td>
										<td><?php echo $row['TAHUN']; ?></td>
										<td>
										<?php 
											$status = ($row['STATUS'] == 1) ? "Lunas" : "Pending"; echo $status;
										?>
										</td>
                                    </tr>
									<?php
										}
									?>
                                </tbody>
                            </table>
							
							
                        </div>
                    </div>
                </div>
                <!-- /.row -->				

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

	<script>
	
	document.getElementById("bulan").selectedIndex = -1;
	document.getElementById("tahun").selectedIndex = -1;
	</script>

<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>