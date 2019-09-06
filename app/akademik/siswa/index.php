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
if($user === "" || $role !== "KUR0002"){	
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
                            Manage Siswa
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Manage Siswa
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<?php
					if(isset($_POST['cari'])){
						if(isset($_POST['namasiswa'])){
							$readsiswa = $con->query("SELECT * FROM kmn_siswa WHERE NAMA LIKE '%" . $_POST['namasiswa'] . "%'");
						}
						elseif(isset($_POST['kelassiswa'])){
							$readsiswa = $con->query("SELECT * FROM kmn_siswa WHERE KELAS LIKE '%" . $_POST['kelassiswa'] . "%'");
						}
						else{
							$readsiswa = $con->query("SELECT * FROM kmn_siswa");
						}
					}elseif(isset($_POST['reset'])){
						$readsiswa = $con->query("SELECT * FROM kmn_siswa");
					}else{
						$readsiswa = $con->query("SELECT * FROM kmn_siswa");
					}
					
					if(isset($_POST['delete'])){
						$deletesiswa = "DELETE FROM kmn_siswa WHERE ID_PENGGUNA = '".$_POST['idpengguna']."'";
						$deleteuser = "DELETE FROM kmn_user WHERE ID_PENGGUNA = '".$_POST['idpengguna']."'";
												
						if ($con->query($deletesiswa) == TRUE && $con->query($deleteuser) == TRUE) {
							echo "<div class=\"row\">";
							echo "<div class=\"col-lg-12\">";
							echo "<div class=\"alert alert-success\">";
							echo "<p style=\"font-style:italic;\"><strong>The data has been deleted</strong></p>";
							echo "</div>";
							echo "</div>";
							echo "</div>";
																				
							$readsiswa = $con->query("SELECT * FROM kmn_siswa");
						}else{
							echo "<div class=\"row\">";
							echo "<div class=\"col-lg-12\">";
							echo "<div class=\"alert alert-danger\">";
							echo "<p style=\"font-style:italic;\"><strong>The data cannot be deleted</strong>. Read error message below :</p><br/>";
							echo "Error: " . $con->error;
							echo "Error: " . $con->error;
							echo "</div>";
							echo "</div>";
							echo "</div>";
						}
					}
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
												<div class="radio">
													<label>
														<input type="radio" onclick="document.getElementById('namasiswa').disabled = false; document.getElementById('kelassiswa').disabled = true; document.getElementById('kelassiswa').value = '';" name="opsiSearch" id="optionsRadios1" value="option1">Nama Siswa
													</label>
												</div>
												<input class="form-control" name="namasiswa" id="namasiswa" disabled="disabled" placeholder="Enter nama siswa">
											</div>
											
											<div class="form-group">
												<div class="radio">
													<label>
														<input type="radio" onclick="document.getElementById('namasiswa').disabled = true; document.getElementById('kelassiswa').disabled = false; document.getElementById('namasiswa').value = '';" name="opsiSearch" id="optionsRadios1" value="option1">Kelas Siswa
													</label>
												</div>
												<input class="form-control" name="kelassiswa" id="kelassiswa" disabled="disabled" placeholder="Enter kelas siswa">
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
                    <div class="col-lg-12">
                        <a type="button" class="btn btn-success" href="register.php" style="margin-bottom: 20px;">Register Siswa</a>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">ID</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Nama</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Kelas</th>
										<th rowspan="2" style="vertical-align: middle;text-align: center;">Sekolah</th>
										<th rowspan="2" style="vertical-align: middle;text-align: center;">Alamat</th>
										<th colspan="2" style="vertical-align: middle;text-align: center;">Current Level</th>
										<th rowspan="2" style="vertical-align: middle;text-align: center;">Action</th>
                                    </tr>
									<tr>
                                        <th style="vertical-align: middle;text-align: center;">Math</th>
                                        <th style="vertical-align: middle;text-align: center;">EFL</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
										while($datasiswa = $readsiswa->fetch_array())
										{
									?>
                                    <tr>
                                        <td><?php echo $datasiswa['ID_SISWA']; ?></td>
                                        <td><?php echo $datasiswa['NAMA']; ?></td>
										<td><?php echo $datasiswa['KELAS']; ?></td>
										<td><?php echo $datasiswa['SEKOLAH']; ?></td>
										<td><?php echo $datasiswa['ALAMAT']; ?></td>
										<?php
											$mathlevel = explode(',',$datasiswa['MATH_LEVEL']); $curmath = max($mathlevel);
											$readlevelmath = $con->query("SELECT * FROM kmn_levelkelas WHERE ID_LEVELKELAS = '" . $curmath . "'");
											$getlevelmath = $readlevelmath->fetch_array();
										?>
										<td><?php echo $getlevelmath['NAMA_LEVEL'];  ?></td>
										<?php
											$efllevel = explode(',',$datasiswa['EFL_LEVEL']); $curefl = max($efllevel);
											$readlevelefl = $con->query("SELECT * FROM kmn_levelkelas WHERE ID_LEVELKELAS = '" . $curefl . "'");
											$getlevelefl = $readlevelefl->fetch_array();
										?>
										<td><?php echo $getlevelefl['NAMA_LEVEL'];  ?></td>
										<td><a href="edit.php?id=<?php echo $datasiswa['ID_PENGGUNA']; ?>" type="button" class="btn btn-sm btn-primary" name="edit">Edit</a>&nbsp;<a href="#confirm-delete" data-id="<?php echo $datasiswa['ID_PENGGUNA']; ?>" type="button" class="open-DeleteDialog btn btn-sm btn-danger" name="delete" data-toggle="modal">Delete</a></td>
										<!-- Modal HTML -->
										<div id="confirm-delete" class="modal fade">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														<h4 class="modal-title">Confirmation</h4>
													</div>
													<div class="modal-body">
														<p>Are you sure you want to delete this data?</p>
														<p class="text-warning"><small>This action cannot be undone.</small></p>
													</div>
													<div class="modal-footer">
														<form role="form" action="" method="post">
															<input class="form-control" id="idpengguna" name="idpengguna" type="hidden" value="">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="submit" name="delete" class="btn btn-danger">Delete</a>
														</form>
													</div>
												</div>
											</div>
										</div>
										<!-- End of Modal HTML -->
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
	$(document).on("click", ".open-DeleteDialog", function () {
		 var idpengguna = $(this).data('id');
		 $("#idpengguna").val( idpengguna );
		$('#confirm-delete').modal('show');
	});
	</script>

<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>