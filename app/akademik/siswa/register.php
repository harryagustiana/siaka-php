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
                            Register Class
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/akademik/siswa/">Dashboard</a>
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
						
							if(isset($_POST['register'])){
								$iduser = "KUS" . autoNumberUserSiswa('ID_PENGGUNA','kmn_user');
								$username = $_POST['username'];
								$password = md5($_POST['password']);
								$createddate = date('Y-m-d h:i:s');
								$idsiswa = $_POST['idsiswa'];
								$nama = $_POST['namasiswa'];
								$kelas = $_POST['kelassiswa'];
								$sekolah = $_POST['sekolahsiswa'];
								$alamat = $_POST['alamatsiswa'];
								$mathlevel = implode(',', $_POST['mathlevel']);
								$efllevel = implode(',', $_POST['efllevel']);

								$queryuser = "INSERT INTO kmn_user VALUES ('" . $iduser . "','" . $username . "','" . $password . "','KUR0004','" . $createddate . "','" . $createddate . "')";
								$querysiswa = "INSERT INTO kmn_siswa VALUES ('" . $iduser . "','" . $idsiswa . "','" . $nama . "','" . $kelas . "','" . $sekolah . "','" . $alamat . "','" . $mathlevel . "','" . $efllevel . "')";

								if ($con->query($queryuser) === TRUE && $con->query($querysiswa) === TRUE) {
									echo "<div class=\"alert alert-success\">";
									echo "<strong>New class</strong> created successfully";
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
                    <div class="col-lg-4">

                        <form role="form" action="" method="post">

                            <div class="form-group">
                                <label>ID Siswa</label>
                                <input class="form-control" name="idsiswa" placeholder="Enter ID Siswa">
                            </div>
							
							<div class="form-group">
                                <label>Username</label>
                                <input class="form-control" name="username" placeholder="Enter Username">
                            </div>
							
							<div class="form-group">
                                <label>Password</label>
                                <input class="form-control" name="password" type="password" placeholder="Enter Password">
                            </div>
							
					
					</div>
					<div class="col-lg-4">
					
							<div class="form-group">
                                <label>Nama</label>
                                <input class="form-control" name="namasiswa" type="text" placeholder="Enter Nama Siswa">
                            </div>
							
							<div class="form-group">
                                <label>Kelas</label>
                                <input class="form-control" name="kelassiswa" type="text" placeholder="Enter Kelas Siswa">
                            </div>
					
							<div class="form-group">
                                <label>Sekolah</label>
                                <input class="form-control" name="sekolahsiswa" type="text" placeholder="Enter Sekolah Siswa">
                            </div>
							
							<div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamatsiswa" placeholder="Enter Alamat Siswa"></textarea>
                            </div>
							
							
					</div>
					<div class="col-lg-4">
							
							<div class="form-group">
                                <label>Level</label>
                            </div>
							
							<div class="form-group">
                                <label>Mathematic</label>
                                
									<?php
										$res = $con->query("SELECT * FROM kmn_levelkelas WHERE MATA_PELAJARAN='Mathematic'");
										while($row = $res->fetch_array())
										{
									?>
									<div class="checkbox">
                                    <label><input type="checkbox" name="mathlevel[]" value="<?php echo $row['ID_LEVELKELAS']; ?>" /><?php echo $row['NAMA_LEVEL'] ; ?></label>
									</div>
									<?php
										}
									?>
                                
                            </div>
							
							<div class="form-group">
                                <label>EFL</label>
                                
									<?php
										$res = $con->query("SELECT * FROM kmn_levelkelas WHERE MATA_PELAJARAN='EFL'");
										while($row = $res->fetch_array())
										{
									?>
									<div class="checkbox">
                                    <label><input type="checkbox" name="efllevel[]" value="<?php echo $row['ID_LEVELKELAS']; ?>" /><?php echo $row['NAMA_LEVEL'] ; ?></label>
									</div>
									<?php
										}
									?>
                                
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