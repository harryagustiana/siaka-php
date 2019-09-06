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
                            Edit User
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/master/user/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Edit User
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
								$username = $_POST['username'];
								$password = $_POST['password'];
								$level = $_POST['level'];
								$updateddate = date("Y-m-d h:i:s");
								
								 if($password != ""){
									$sql = "UPDATE kmn_user SET USERNAME=?, PASSWORD=?, ID_LEVELPENGGUNA=?, TGL_UBAHDATA=? WHERE ID_PENGGUNA=?";
									$update = $con->prepare($sql);
									$update->bind_param("sssss", $username, $password, $level, $updateddate, $id);
								}
								else{
									$sql = "UPDATE kmn_user SET USERNAME=?, ID_LEVELPENGGUNA=?, TGL_UBAHDATA=? WHERE ID_PENGGUNA=?";
									$update = $con->prepare($sql);
									$update->bind_param("ssss", $username, $level, $updateddate, $id);
								} 
								
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

					$sqlread = "SELECT USERNAME, ID_LEVELPENGGUNA FROM kmn_user WHERE ID_PENGGUNA=?";
					$read = $con->prepare($sqlread);
					$read->bind_param("s", $id);
					$read->execute();
					$getROW = $read->fetch_array();

					$con->close();
					
				?>

                <div class="row">
                    <div class="col-lg-6">

                        <form role="form" action="" method="post">
							
							<div class="form-group">
                                <label>Username</label>
                                <input class="form-control" name="username" value="<?php echo $getROW['USERNAME']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Password</label>
                                <input class="form-control" name="password" type="password" placeholder="New password to replace or left it blank">
                            </div>
							
							<div class="form-group">
                                <label>Select Role</label>
                                <select class="form-control" name="level">
									<?php
										require($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
										$res = $con->query("SELECT * FROM kmn_levelpengguna");
										while($row = $res->fetch_array())
										{
											if($row['ID_LEVELPENGGUNA'] == $getROW['ID_LEVELPENGGUNA'])
											{
												$selected = "selected=\"selected\"";
											}
											else
											{
												$selected = "";
											}
									?>
                                    <option value="<?php echo $row['ID_LEVELPENGGUNA']; ?>" <?php echo $selected; ?>><?php echo $row['ROLE']; ?></option>
									<?php
										}
										
										$con->close();
									?>
                                </select>
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