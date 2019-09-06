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

if($user === '' || $role !== 'KUR0004'){
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
                            Bahan Pelajaran
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Data Pelajaran
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<?php
					$databahan = $con->query("SELECT * FROM kmn_bahanpelajaran WHERE ID_MATAPELAJARAN = 'KBM0001'");
										
					if(isset($_POST['cari'])){
						if(isset($_POST['idbahan'])){
							$databahan = $con->query("SELECT * FROM kmn_bahanpelajaran WHERE ID_LEVELKELAS = '" . $_POST['idbahan'] . "'");
						}
						else{
							$databahan = $con->query("SELECT * FROM kmn_bahanpelajaran WHERE ID_MATAPELAJARAN = 'KBM0001'");
						}
					}elseif(isset($_POST['reset'])){
						$databahan = $con->query("SELECT * FROM kmn_bahanpelajaran WHERE ID_MATAPELAJARAN = 'KBM0001'");
					}else{
						$databahan = $con->query("SELECT * FROM kmn_bahanpelajaran WHERE ID_MATAPELAJARAN = 'KBM0001'");
					}
					
					$readbahan = $databahan->fetch_array();
				?>
				<div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a data-toggle="collapse" href="#demo" style="text-decoration: none; color: #000;"><h3 class="panel-title">Filter Data</h3></a>
                            </div>
                            <div class="panel-body collapse" id="demo" >
								<div class="row">
									<div class="col-sm-6">
										<form role="form" action="" method="post">
											<div class="form-group">
												<label>Level</label>
												<select class="form-control chosen-select" name="idbahan">
													<?php
														$res = $con->query("SELECT * FROM kmn_levelkelas");
														while($row = $res->fetch_array())
														{
													?>
													<option value="<?php echo $row['ID_LEVELKELAS']; ?>"><?php echo $row['MATA_PELAJARAN'] . " - " . $row['NAMA_LEVEL']; ?></option>
													<?php
														}
													?>
												</select>
											</div>
											
											<button type="submit" class="btn btn-primary" name="cari">Cari</button>
											
											<button type="submit" class="btn btn-default" name="reset">Reset</button>
										</form>
									</div>
								</div>
                            </div>
                        </div>
					</div>
				</div>

				<div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Keterangan</h3>
                            </div>
                            <div class="panel-body" id="demo" >
								<div class="row">
									<div class="col-sm-12">
										<p><?php echo $readbahan['KETERANGAN']; ?></p>
									</div>
								</div>
                            </div>
                        </div>
					</div>
				</div>
				
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