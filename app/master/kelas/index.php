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
                            Manage Class
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Manage Class
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<?php
					$res = $con->query("SELECT * FROM kmn_levelkelas");
					
					if(isset($_POST['delete'])){
						$sql = "DELETE FROM kmn_levelkelas WHERE ID_LEVELKELAS=?";
						$delete = $con->prepare($sql);
						$delete->bind_param("s", $_POST['idlevel']);
												
						if ($delete->execute()) {
							echo "<div class=\"row\">";
							echo "<div class=\"col-lg-12\">";
							echo "<div class=\"alert alert-success\">";
							echo "<p style=\"font-style:italic;\"><strong>The data has been deleted</strong></p>";
							echo "</div>";
							echo "</div>";
							echo "</div>";
																				
							$res = $con->query("SELECT * FROM kmn_levelkelas");
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
                    <div class="col-lg-12">
                        <a type="button" class="btn btn-success" href="register.php" style="margin-bottom: 20px;">New Class</a>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Level</th>
                                        <th>Mata Pelajaran</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
										
										while($row = $res->fetch_array())
										{
									?>
                                    <tr>
                                        <td><?php echo $row['ID_LEVELKELAS']; ?></td>
                                        <td><?php echo $row['NAMA_LEVEL']; ?></td>
										<td><?php echo $row['MATA_PELAJARAN']; ?></td>
										<td><a href="edit.php?id=<?php echo $row['ID_LEVELKELAS']; ?>" type="button" class="btn btn-sm btn-primary" name="edit">Edit</a>&nbsp;<a href="#confirm-delete" data-id="<?php echo $row['ID_LEVELKELAS']; ?>" type="button" class="open-DeleteDialog btn btn-sm btn-danger" name="delete" data-toggle="modal">Delete</a></td>
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
															<input class="form-control" id="idlevel" name="idlevel" type="hidden" value="">
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
	$(document).on("click", ".open-DeleteDialog", function () {
		 var idlevel = $(this).data('id');
		 $("#idlevel").val( idlevel );
		$('#confirm-delete').modal('show');
	});
	</script>

<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>