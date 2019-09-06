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
                            Manage Role
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Manage Role
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<?php
					$res = $con->query("SELECT * FROM kmn_levelpengguna");
					
					if(isset($_POST['delete'])){
						$sql = "DELETE FROM kmn_levelpengguna WHERE ID_LEVELPENGGUNA=?";
						$delete = $con->prepare($sql);
						$delete->bind_param("s", $_POST['idrole']);
						
						if ($delete->execute()) {
							echo "<div class=\"row\">";
							echo "<div class=\"col-lg-12\">";
							echo "<div class=\"alert alert-success\">";
							echo "<p style=\"font-style:italic;\"><strong>The data has been deleted</strong></p>";
							echo "</div>";
							echo "</div>";
							echo "</div>";
																				
							$res = $con->query("SELECT * FROM kmn_levelpengguna");
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
                        <a type="button" class="btn btn-success" href="register.php" style="margin-bottom: 20px;">New Role</a>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Role</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
										
										while($row = $res->fetch_array())
										{
									?>
                                    <tr>
                                        <td><?php echo $row['ID_LEVELPENGGUNA']; ?></td>
                                        <td><?php echo $row['ROLE']; ?></td>
                                        <td><?php echo $row['KETERANGAN']; ?></td>
										<td><a href="edit.php?id=<?php echo $row['ID_LEVELPENGGUNA']; ?>" type="button" class="btn btn-sm btn-primary" name="edit">Edit</a>&nbsp;<a href="#confirm-delete" data-id="<?php echo $row['ID_LEVELPENGGUNA']; ?>" type="button" class="open-DeleteDialog btn btn-sm btn-danger" name="delete" data-toggle="modal">Delete</a></td>
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
															<input class="form-control" id="idrole" name="idrole" type="hidden" value="">
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
		 var idrole = $(this).data('id');
		 $("#idrole").val( idrole );
		$('#confirm-delete').modal('show');
	});
	</script>

<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>