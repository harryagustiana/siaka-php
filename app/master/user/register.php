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
                            Register User
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/master/user/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Register User
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-12">
				
						<?php
						
							if(isset($_POST['register'])){
								$iduser = "KUA" . autoNumberUserAdmin('ID_PENGGUNA','kmn_user');
								$username = $_POST['username'];
								$password = md5($_POST['password']);
								$level = $_POST['level'];
								$createddate = date("Y-m-d h:i:s");
								$updateddate = date("Y-m-d h:i:s");

								$sql = "INSERT INTO kmn_user VALUES (?,?,?,?,?,?)";
								$save = $con->prepare($sql);
								$save->bind_param("ssssss", $iduser, $username, $password, $level, $createddate, $updateddate);

								if ($save->execute()) {
									echo "<div class=\"alert alert-success\">";
									echo "<strong>New user</strong> created successfully";
									echo "</div>";
								} 
								else {
									echo "<div class=\"alert alert-danger\">";
									echo "Error: " . $sql . "<br>" . $con->error;
									echo "</div>";
								}

								//$con->close();
							}
						?>
				
					</div>
                </div>

                <div class="row">
                    <div class="col-lg-6">

                        <form role="form" action="" method="post">

                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" name="username" placeholder="Enter username">
                            </div>
							
							<div class="form-group">
                                <label>Password</label>
                                <input class="form-control" name="password" type="password" placeholder="Enter password">
                            </div>
							
							<div class="form-group">
                                <label>Select Role</label>
                                <select class="form-control" name="level">
									<?php
										$res = $con->query("SELECT * FROM kmn_levelpengguna");
										while($row = $res->fetch_array())
										{
									?>
                                    <option value="<?php echo $row['ID_LEVELPENGGUNA']; ?>"><?php echo $row['ROLE']; ?></option>
									<?php
										}
									?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary" name="register">Register</button>
                            

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