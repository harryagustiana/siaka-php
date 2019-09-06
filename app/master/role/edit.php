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
                            Edit Role
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/master/role/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Edit Role
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-12">
				
						<?php
						
							$id = $_GET['id'];
							
							if(isset($_POST['edit'])){
								$role = $_POST['role'];
								$keterangan = $_POST['keterangan'];

								$sql = "UPDATE kmn_levelpengguna SET ROLE=?, KETERANGAN=? WHERE ID_LEVELPENGGUNA=?";
								$update = $con->prepare($sql);
								$update->bind_param("sss", $role, $keterangan, $id);

								if ($update->execute()) {
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

					$sqlread = "SELECT ROLE, KETERANGAN FROM kmn_levelpengguna WHERE ID_LEVELPENGGUNA = '" . $id . "'";
					$read = $con->query($sqlread);
					$getROW = $read->fetch_array();

					$con->close();
					
				?>

                <div class="row">
                    <div class="col-lg-6">

                        <form role="form" action="" method="post">

                            <div class="form-group">
                                <label>Role</label>
                                <input class="form-control" name="role" value="<?php echo $getROW['ROLE']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows="3"><?php echo $getROW['KETERANGAN']; ?></textarea>
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