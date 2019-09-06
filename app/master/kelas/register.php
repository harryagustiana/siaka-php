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
                            Register Class
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/master/kelas/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Register Class
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-12">
				
						<?php
						
							require($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
							if(isset($_POST['register'])){
								$idkelas = "KG" . autoNumber('ID_LEVELKELAS','kmn_levelkelas');
								$namalevel = $_POST['namalevel'];
								$matpel = $_POST['matpel'];

								$sql = "INSERT INTO kmn_levelkelas VALUES (?,?,?)";
								$save = $con->prepare($sql);
								$save->bind_param("sss", $idkelas, $namalevel, $matpel);

								if ($save->execute()) {
									echo "<div class=\"alert alert-success\">";
									echo "<strong>New class</strong> created successfully";
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

                <div class="row">
                    <div class="col-lg-6">

                        <form role="form" action="" method="post">
							
							<div class="form-group">
                                <label>Nama Level</label>
                                <input class="form-control" name="namalevel" type="text" placeholder="Enter Nama Level">
                            </div>
							
							<div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select class="form-control" name="matpel">
                                    <option value="Mathematic">Mathematic</option>
									<option value="EFL">English Foreign Language</option>
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