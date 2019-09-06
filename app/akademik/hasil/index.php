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
                            Manage Hasil Belajar
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Manage Hasil Belajar
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<?php
					if(isset($_POST['cari'])){
						if(isset($_POST['idsiswa'])){
							$res = $con->query("SELECT * FROM kmn_hasilbelajar WHERE ID_SISWA LIKE '%" . $_POST['idsiswa'] . "%'");
						}
						elseif(isset($_POST['levelkelas'])){
							$res = $con->query("SELECT * FROM kmn_hasilbelajar WHERE ID_LEVELKELAS LIKE '%" . $_POST['levelkelas'] . "%'");
						}
						else{
							$res = $con->query("SELECT * FROM kmn_hasilbelajar");
						}
					}elseif(isset($_POST['reset'])){
						$res = $con->query("SELECT * FROM kmn_hasilbelajar");
					}else{
						$res = $con->query("SELECT * FROM kmn_hasilbelajar");
					}
					
					if(isset($_POST['delete'])){
						$deletehasilbelajar = "DELETE FROM kmn_hasilbelajar WHERE NO_TEST = '".$_POST['notest']."'";
												
						if ($con->query($deletehasilbelajar) == TRUE) {
							echo "<div class=\"row\">";
							echo "<div class=\"col-lg-12\">";
							echo "<div class=\"alert alert-success\">";
							echo "<p style=\"font-style:italic;\"><strong>The data has been deleted</strong></p>";
							echo "</div>";
							echo "</div>";
							echo "</div>";
																				
							$res = $con->query("SELECT * FROM kmn_hasilbelajar");
						}else{
							echo "<div class=\"row\">";
							echo "<div class=\"col-lg-12\">";
							echo "<div class=\"alert alert-danger\">";
							echo "<p style=\"font-style:italic;\"><strong>The data cannot be deleted</strong>. Read error message below :</p><br/>";
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
                                <a data-toggle="collapse" href="#demo" id="filter" style="text-decoration: none; color: #000;"><h3 class="panel-title"><i class="fa fa-bars" aria-hidden="true"></i> Filter Data</h3></a>
                            </div>
                            <div class="panel-body collapse" id="demo" >
								<div class="row">
									<div class="col-sm-6">
										<form role="form" action="" method="post">
											<div class="form-group">
												<div class="radio">
													<label>
														<input type="radio" onclick="document.getElementById('idsiswa').disabled = false; 
															document.getElementById('levelkelas').disabled = true; 
															document.getElementById('levelkelas').selectedIndex = -1;" 
														name="opsiSearch" id="optionsRadios1" value="option1">ID Siswa
													</label>
												</div>
												<input class="form-control" name="idsiswa" id="idsiswa" disabled="disabled" placeholder="Enter ID siswa">
											</div>
											
											<div class="form-group">
												<div class="radio">
													<label>
														<input type="radio" onclick="document.getElementById('levelkelas').disabled = false; 
															document.getElementById('idsiswa').disabled = true; 
															document.getElementById('idsiswa').value = '';"
														name="opsiSearch" id="optionsRadios1" value="option1">Level
													</label>
												</div>
												<select class="form-control" name="levelkelas" id="levelkelas" disabled="disabled" >
												<?php
													$readlevel = $con->query("SELECT * FROM kmn_levelkelas");
													while($rowlevel = $readlevel->fetch_array())
													{
												?>
												<option value="<?php echo $rowlevel['ID_LEVELKELAS']; ?>"><?php echo $rowlevel['MATA_PELAJARAN'] . " - " . $rowlevel['NAMA_LEVEL']; ?></option>
												<?php
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
                        <a href="#confirm-register" type="button" class="btn btn-success" name="confirmregister" data-toggle="modal" style="margin-bottom: 20px;">New Hasil Belajar</a>
                        <!-- Modal HTML -->
						<div id="confirm-register" class="modal fade">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title">Confirmation</h4>
									</div>
									<div class="modal-body">
										<form role="form" action="register.php" method="post">

											<div class="form-group">
												<label>Input ID Siswa</label>
												<input class="form-control" name="siswa" placeholder="Enter ID Siswa">
											</div>
											
											<button type="submit" class="btn btn-primary" name="input">Register</button>
 
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- End of Modal HTML -->
						<div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Siswa</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
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
                                        <td><?php echo $row['ID_SISWA']; ?></td>
										<?php
											$siswa = $con->query("SELECT * FROM kmn_siswa WHERE ID_SISWA = '". $row['ID_SISWA'] ."'");
											while($rowsiswa = $siswa->fetch_array())
											{
										?>
                                        <td><?php echo $rowsiswa['NAMA']; ?></td>
										<td><?php echo $rowsiswa['KELAS']; ?></td>
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
										<td><a href="edit.php?id=<?php echo $row['NO_TEST']; ?>" type="button" class="btn btn-sm btn-primary" name="edit">Edit</a>&nbsp;<a href="#confirm-delete" data-id="<?php echo $row['NO_TEST']; ?>" type="button" class="open-DeleteDialog btn btn-sm btn-danger" name="delete" data-toggle="modal">Delete</a></td>
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
															<input class="form-control" id="notest" name="notest" type="hidden" value="">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-danger" name="delete">Delete</a>
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
	$('#confirm-register').on('show.bs.modal', function(e) {});
	
	document.getElementById("levelkelas").selectedIndex = -1;
	
	$(document).on("click", ".open-DeleteDialog", function () {
		 var notest = $(this).data('id');
		 $("#notest").val( notest );
		$('#confirm-delete').modal('show');
	});
	</script>
	
<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>