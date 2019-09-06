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
if($user === "" || $role !== "KUR0001"){	
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
					$dari = "";
					$ke = "";
					if(isset($_POST['cari'])){
						if(isset($_POST['dari']) && isset($_POST['ke'])){
							$res = $con->query("SELECT * FROM kmn_hasilbelajar WHERE TGL_TEST BETWEEN '" . $_POST['dari'] . "' AND '" . $_POST['ke'] . "' ");
							$dari = $_POST['dari'];
							$ke = $_POST['ke'];
						}
						else{
							$res = $con->query("SELECT * FROM kmn_hasilbelajar");
							$dari = "";
							$ke = "";
						}
					}elseif(isset($_POST['reset'])){
						$res = $con->query("SELECT * FROM kmn_hasilbelajar");
						$dari = "";
						$ke = "";
					}else{
						$res = $con->query("SELECT * FROM kmn_hasilbelajar");
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
												<label>Dari Tanggal</label>
												<input type="text" class="form-control" name="dari" id="tanggal1" placeholder="Format : TTTT-BB-HH" required>
											</div>
											
											<div class="form-group">
												<label>Ke Tanggal</label>
												<input type="text" class="form-control" name="ke" id="tanggal2" placeholder="Format : TTTT-BB-HH" required>
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
                                        <th>ID Siswa</th>
                                        <th>Nama</th>
                                        <th>Lulus Level</th>
										<th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
										
										while($row = $res->fetch_array())
										{
									?>
                                    <tr>
                                        <td><?php echo $row['ID_SISWA']; ?></td>
										<?php
											$siswa = $con->query("SELECT * FROM kmn_siswa WHERE ID_SISWA = '". $row['ID_SISWA'] ."'");
											while($rowsiswa = $siswa->fetch_array())
											{
										?>
                                        <td><?php echo $rowsiswa['NAMA']; ?></td>
										<?php
											};
										?>
										<?php
											$level = $con->query("SELECT * FROM kmn_levelkelas WHERE ID_LEVELKELAS = '". $row['ID_LEVELKELAS'] ."'");
											while($rowlevel = $level->fetch_array())
											{
										?>
                                        <td><?php echo $rowlevel['MATA_PELAJARAN'] . " - " . $rowlevel['NAMA_LEVEL']; ?></td>
										<?php
											};
										?>
										<td><?php echo $row['TGL_TEST']; ?></td>
                                    </tr>
									<?php
										}
									?>
                                </tbody>
                            </table>
							<form role="form" action="export.php" method="post">
								<input type="hidden" value="<?php echo $dari; ?>" name="dari" />
								<input type="hidden" value="<?php echo $ke; ?>" name="ke" />
								<button type="submit" class="btn btn-success" style="margin-top: 20px;">Export Data Hasil Akademik</button>		
							</form>
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