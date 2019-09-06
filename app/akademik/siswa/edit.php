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
                            Edit Siswa
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/akademik/siswa/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Edit Siswa
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-12">
				
						<?php
						
							require($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
							
							$id = $_GET['id'];
							
							if(isset($_POST['edit'])){
								$username = $_POST['username'];
								$password = $_POST['password'];
								$updateddate = date('Y-m-d h:i:s');
								$idsiswa = $_POST['idsiswa'];
								$nama = $_POST['namasiswa'];
								$kelas = $_POST['kelassiswa'];
								$sekolah = $_POST['sekolahsiswa'];
								$alamat = $_POST['alamatsiswa'];
								$mathlevel = implode(',', $_POST['mathlevel']);
								$efllevel = implode(',', $_POST['efllevel']);

								$updatesiswa = "UPDATE kmn_siswa SET ID_SISWA='".$idsiswa."', NAMA='".$nama."', KELAS='".$kelas."', SEKOLAH='".$sekolah."', ALAMAT='".$alamat."', MATH_LEVEL='".$mathlevel."', EFL_LEVEL='".$efllevel."' WHERE ID_PENGGUNA = '".$id."'";								
								if($password != ""){
									$updateuser = "UPDATE kmn_user SET USERNAME='".$username."', PASSWORD='".md5($password)."', ID_LEVELPENGGUNA='".$level."', TGL_UBAHDATA='".$updateddate."' WHERE ID_PENGGUNA = '".$id."'";
								}
								else{
									$updateuser = "UPDATE kmn_user SET USERNAME='".$username."', TGL_UBAHDATA='".$updateddate."' WHERE ID_PENGGUNA = '".$id."'";
								} 
								
								if ($con->query($updatesiswa) == TRUE && $con->query($updateuser) == TRUE) {
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

					$readsiswa = "SELECT * FROM kmn_siswa WHERE ID_PENGGUNA = '" . $id . "'";
					$readuser = "SELECT * FROM kmn_user WHERE ID_PENGGUNA = '" . $id . "'";
					$datasiswa = $con->query($readsiswa);
					$datauser = $con->query($readuser);
					$getrowsiswa = $datasiswa->fetch_array();
					$getrowuser = $datauser->fetch_array();

					//$con->close();
					
				?>

                <div class="row">
                    <div class="col-lg-4">

                        <form role="form" action="" method="post">

                            <div class="form-group">
                                <label>ID Siswa</label>
                                <input class="form-control" name="idsiswa" value="<?php echo $getrowsiswa['ID_SISWA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Username</label>
                                <input class="form-control" name="username" value="<?php echo $getrowuser['USERNAME']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Password</label>
                                <input class="form-control" name="password" type="password" placeholder="New password to replace or left it blank">
                            </div>
							
					
					</div>
					<div class="col-lg-4">
					
							<div class="form-group">
                                <label>Nama</label>
                                <input class="form-control" name="namasiswa" type="text" value="<?php echo $getrowsiswa['NAMA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Kelas</label>
                                <input class="form-control" name="kelassiswa" type="text" value="<?php echo $getrowsiswa['KELAS']; ?>">
                            </div>
					
							<div class="form-group">
                                <label>Sekolah</label>
                                <input class="form-control" name="sekolahsiswa" type="text" value="<?php echo $getrowsiswa['SEKOLAH']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamatsiswa" ><?php echo $getrowsiswa['ALAMAT']; ?></textarea>
                            </div>
							
							
					</div>
					<div class="col-lg-4">
							
							<div class="form-group">
                                <label>Level</label>
								<?php
									$mathlev = explode(',', $getrowsiswa['MATH_LEVEL']);
									$efllev = explode(',', $getrowsiswa['EFL_LEVEL']);
								?>
                            </div>
							
							<div class="form-group">
                                <label>Mathematic</label>
                                
									<?php
										
										$mlv = $con->query("SELECT * FROM kmn_levelkelas WHERE MATA_PELAJARAN='Mathematic'");
										while($mathv = $mlv->fetch_array())
										{
									?>
									<div class="checkbox">
                                    <label><input type="checkbox" name="mathlevel[]" value="<?php echo $mathv['ID_LEVELKELAS']; ?>" <?php foreach($mathlev as $levmath){echo ($mathv['ID_LEVELKELAS']==$levmath ? 'checked' : '');}?> /><?php echo $mathv['NAMA_LEVEL'] ; ?></label>
									</div>
									<?php
										}
									?>
                                
                            </div>
							
							<div class="form-group">
                                <label>English Foreign Language</label>
                                
									<?php
										
										$elv = $con->query("SELECT * FROM kmn_levelkelas WHERE MATA_PELAJARAN='EFL'");
										while($eflv = $elv->fetch_array())
										{
									?>
									<div class="checkbox">
                                    <label><input type="checkbox" name="efllevel[]" value="<?php echo $eflv['ID_LEVELKELAS']; ?>" <?php foreach($efllev as $levefl){echo($eflv['ID_LEVELKELAS']==$levefl ? 'checked' : '');}?> /><?php echo $eflv['NAMA_LEVEL'] ; ?></label>
									</div>
									<?php
										}
									?>
                                
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