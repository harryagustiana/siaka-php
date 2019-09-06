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
                            Report Hasil Akademik
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Report Hasil Akademik
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
																		
					if(isset($_POST['cari'])){
						if(isset($_POST['matpel'])){
							$res = $con->query("SELECT * FROM kmn_hasilbelajar WHERE ID_SISWA='" . $readsiswa['ID_SISWA'] . "' AND ID_LEVELKELAS IN ('" . $_POST['matpel'] ."')");
						}
						else{
							$res = $con->query("SELECT * FROM kmn_hasilbelajar WHERE ID_SISWA='" . $readsiswa['ID_SISWA'] . "'");
						}
					}elseif(isset($_POST['reset'])){
						$res = $con->query("SELECT * FROM kmn_hasilbelajar WHERE ID_SISWA='" . $readsiswa['ID_SISWA'] . "'");
					}else{
						$res = $con->query("SELECT * FROM kmn_hasilbelajar WHERE ID_SISWA='" . $readsiswa['ID_SISWA'] . "'");
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
												<label>Mata Pelajaran</label>
												
												<select class="form-control" name="matpel">
													<option value="<?php echo $readsiswa['MATH_LEVEL']; ?>">Mathematic</option>
													<option value="<?php echo $readsiswa['EFL_LEVEL']; ?>">English Foreign Language</option>
												</select>
											</div>
										
									</div>	
								</div>
								
								<div class="row">
									<div class="col-sm-12">
											<button type="submit" class="btn btn-primary" name="cari" style="display: block; float: left;margin-right: 10px;">Cari</button>								
								</form>
								<form role="form" action="" method="post">
											<button type="submit" class="btn btn-default" name="reset" style="display: block; float: left;">Reset</button>
									</div>
								</div>
								</form>
                            </div>
                        </div>
					</div>
				</div>

                <div class="row">
                    <div class="col-lg-12">
						<div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Mata Pelajaran</th>
										<th>Level</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
										while($row = $res->fetch_array())
										{
									?>
                                    <tr>
										<?php
											$level = $con->query("SELECT * FROM kmn_levelkelas WHERE ID_LEVELKELAS = '". $row['ID_LEVELKELAS'] ."'");
											while($rowlevel = $level->fetch_array())
											{
										?>
                                        <td><?php echo $rowlevel['MATA_PELAJARAN'];?></td>
										<td><?php echo $rowlevel['NAMA_LEVEL']; ?></td>
										<?php
											};
										?>
										<td><a target="_blank" href="hasil.php?notest=<?php echo $row['NO_TEST']; ?>" class="btn btn-default" >Print</a></td>
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
	
	<link rel="stylesheet" href="/assets/plugin/datepicker/css/jquery-ui.css" type="text/css">
	
	<script src="/assets/plugin/datepicker/js/jquery-ui.js"></script>
	<script>
		$('#tanggal1').datepicker({
			dateFormat: "yy-mm-dd",
			changeMonth: true,
			changeYear: true
		});
		$('#tanggal2').datepicker({
			dateFormat: "yy-mm-dd",
			changeMonth: true,
			changeYear: true
		});
	</script>
	

<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>