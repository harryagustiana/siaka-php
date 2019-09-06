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
                            Edit Class
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/master/kelas/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Edit Class
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
								$namalevel = $_POST['namalevel'];
								$matpel = $_POST['matpel'];
								
								$sql = "UPDATE kmn_levelkelas SET NAMA_LEVEL=?, MATA_PELAJARAN=? WHERE ID_LEVELKELAS=?";
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

					$sqlread = "SELECT * FROM kmn_levelkelas WHERE ID_LEVELKELAS = '" . $id . "'";
					$read = $con->query($sqlread);
					$getROW = $read->fetch_array();

					$con->close();
					
				?>

                <div class="row">
                    <div class="col-lg-6">

                        <form role="form" action="" method="post">
							
							<div class="form-group">
                                <label>Nama Level</label>
                                <input class="form-control" name="namalevel" value="<?php echo $getROW['NAMA_LEVEL']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select class="form-control" name="matpel">
								<?php
									$listmatpel = $getROW['MATA_PELAJARAN'];
									if($listmatpel == "Mathematic"){
										echo "<option value=\"Mathematic\" selected=\"selected\">Mathematic</option>";
										echo "<option value=\"EFL\">English Foreign Language</option>";
									}
									else{
										echo "<option value=\"Mathematic\">Mathematic</option>";
										echo "<option value=\"EFL\" selected=\"selected\">English Foreign Language</option>";
									}
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