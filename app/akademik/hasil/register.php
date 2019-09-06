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

<?php
if(isset($_POST['siswa'])){
	$id = $_POST['siswa'];
}else{
	$id = NULL;
}
?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Register Hasil Belajar
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/master/hasil/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Register Hasil Belajar
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
								$notest = "KTR" . autoNumberHasil('NO_TEST','kmn_hasilbelajar');
								$idsiswa = $_POST['idsiswa'];
								$tgltest = $_POST['tgltest'];
								$waktu = $_POST['waktu'];
								$skor = $_POST['skor'];
								$idlevel = $_POST['idlevel'];
								$catatan = $_POST['catatan'];

								$sql = "INSERT INTO kmn_hasilbelajar VALUES ('" . $notest . "','" . $idsiswa . "','" . $tgltest . "','" . $waktu . "','" . $skor . "','" . $idlevel . "','" . $catatan . "')";

								if ($con->query($sql) === TRUE) {
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
				<?php
						
					require($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
					
					if ($id != NULL){
					
						$readsiswa = "SELECT * FROM kmn_siswa WHERE ID_SISWA = '" . $id . "'";
						$datasiswa = $con->query($readsiswa);
						$getrowsiswa = $datasiswa->fetch_array();

						//$con->close();
					
				?>
                <div class="row">
                    <div class="col-lg-6">

						<form role="form" action="" method="post">						

                            <div class="form-group">
                                <label>ID Siswa</label>
                                <input class="form-control" name="idsiswa" readonly="readonly" style="background-color: #fff;" value="<?php echo $getrowsiswa['ID_SISWA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Nama</label>
                                <input class="form-control" name="nama" readonly="readonly" style="background-color: #fff;"  value="<?php echo $getrowsiswa['NAMA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Kelas</label>
                                <input class="form-control" name="kelas"  readonly="readonly" style="background-color: #fff;"  value="<?php echo $getrowsiswa['KELAS']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Tanggal Test</label>
                                <input class="form-control" name="tgltest" placeholder="Masukkan tanggal test">
                            </div>
							
							<div class="form-group">
                                <label>Waktu</label>
                                <input class="form-control" name="waktu" placeholder="Masukkan waktu test">
                            </div>
							
					</div>
					<div class="col-lg-6">
					
							<div class="form-group">
                                <label>Skor</label>
                                <input class="form-control" name="skor" placeholder="Masukkan Skor">
                            </div>
							
							
							
							<div class="form-group">
                                <div class="form-group">
                                <label>Level</label>
								<?php
									$mathlev = explode(',', $getrowsiswa['MATH_LEVEL']);
									$efllev = explode(',', $getrowsiswa['EFL_LEVEL']);
									
									$participate = array_merge($mathlev, $efllev);								
								?>
								<select class="form-control" name="idlevel" id="mathCheckbox">
									<?php
										foreach ($participate as $partic){
											$mlv = $con->query("SELECT * FROM kmn_levelkelas WHERE ID_LEVELKELAS = '" . $partic . "'");
											$mathv = $mlv->fetch_array();
									?>
									<option value="<?php echo $mathv['ID_LEVELKELAS']; ?>"><?php echo $mathv['MATA_PELAJARAN'] . " - " . $mathv['NAMA_LEVEL']; ?></option>
									<?php
										}
									?>
								</select>
                            </div>
                            
							<div class="form-group">
                                <label>Catatan</label>
                                <textarea class="form-control" name="catatan" placeholder="Masukkan Catatan"></textarea>
                            </div>
							
                            <button type="submit" class="btn btn-primary" name="register">Register</button>
                            

                        </form>

                    </div>
                    
                </div>
                <!-- /.row -->
				<?php
					}
					else{
				?>
				<div class="row">
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<p style="font-style:italic;"><strong>ID Siswa tidak ditemukan!</strong>. Silahkan pilih ID Siswa terlebih dahulu untuk menambah data baru. Klik <a href="/app/akademik/hasil/"><strong>di sini</strong></a> untuk menuju ke halaman utama Hasil Belajar</p>
						</div>
					</div>
					
				</div>
				<?php
					}
				?>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	
	<script type="text/javascript">

	function yesnoCheck() {
		if (document.getElementById('mathClicked').checked) {
			document.getElementById('mathCheckbox').style.display = 'block';
			document.getElementById('eflCheckbox').style.display = 'none';
		}
		else {
			document.getElementById('mathCheckbox').style.display = 'none';
			document.getElementById('eflCheckbox').style.display = 'block';
		}

	}

	</script>
	
	<script type="text/javascript" src="/assets/tinymce/js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
	tinymce.init({
		selector: 'textarea',  // change this value according to your HTML
		
		// ===========================================
		// INCLUDE THE PLUGIN
		// ===========================================
		
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste jbimages"
		],
		
		// ===========================================
		// PUT PLUGIN'S BUTTON on the toolbar
		// ===========================================
		
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
		
		// ===========================================
		// SET RELATIVE_URLS to FALSE (This is required for images to display properly)
		// ===========================================
		
		relative_urls: false
	});
	</script>

<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>