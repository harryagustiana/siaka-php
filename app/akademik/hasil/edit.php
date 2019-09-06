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
                            Edit Hasil Belajar
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/akademik/hasil/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Edit Hasil Belajar
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
								$tgltest = $_POST['tgltest'];
								$waktu = $_POST['waktu'];
								$skor = $_POST['skor'];
								$idlevel = $_POST['idlevel'];
								$catatan = $_POST['catatan'];
								
								$sqlupdate = "UPDATE kmn_hasilbelajar SET TGL_TEST='".$tgltest."', WAKTU='".$waktu."', SKOR='".$skor."', CATATAN='".$catatan."' WHERE NO_TEST = '".$id."'";
								
								if ($con->query($sqlupdate) == TRUE) {
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

					$sqlread = "SELECT * FROM kmn_hasilbelajar WHERE NO_TEST = '" . $id . "'";
					$read = $con->query($sqlread);
					$getROW = $read->fetch_array();
					
					$sqlsiswa = "SELECT * FROM kmn_siswa WHERE ID_SISWA = '" . $getROW['ID_SISWA'] . "'";
					$readsiswa = $con->query($sqlsiswa);
					$getROWsiswa = $readsiswa->fetch_array();
					
					$sqllevel = "SELECT * FROM kmn_levelkelas WHERE ID_LEVELKELAS = '" . $getROW['ID_LEVELKELAS'] . "'";
					$readlevel = $con->query($sqllevel);
					$getROWlevel = $readlevel->fetch_array();

					$con->close();
					
				?>

                <div class="row">
                    <div class="col-lg-6">

                        <form role="form" action="" method="post">
							
							<div class="form-group">
                                <label>ID Siswa</label>
                                <input class="form-control" name="idsiswa" readonly="readonly" style="background-color: #fff;" value="<?php echo $getROW['ID_SISWA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Nama</label>
                                <input class="form-control" name="nama" readonly="readonly" style="background-color: #fff;"  value="<?php echo $getROWsiswa['NAMA']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Kelas</label>
                                <input class="form-control" name="kelas"  readonly="readonly" style="background-color: #fff;"  value="<?php echo $getROWsiswa['KELAS']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Tanggal Test</label>
                                <input class="form-control" name="tgltest" value="<?php echo $getROW['TGL_TEST']; ?>">
                            </div>
							
							<div class="form-group">
                                <label>Waktu</label>
                                <input class="form-control" name="waktu" value="<?php echo $getROW['WAKTU']; ?>">
                            </div>
							
					</div>
					<div class="col-lg-6">
					
							<div class="form-group">
                                <label>Skor</label>
                                <input class="form-control" name="skor" value="<?php echo $getROW['SKOR']; ?>">
                            </div>						
							
							<div class="form-group">
                                <label>Level</label>
                                <input class="form-control" name="idlevel" readonly="readonly" style="background-color: #fff;" value="<?php echo $getROWlevel['MATA_PELAJARAN'] . " - " . $getROWlevel['NAMA_LEVEL']; ?>">
                            </div>
                            
							<div class="form-group">
                                <label>Catatan</label>
                                <textarea class="form-control" name="catatan"><?php echo $getROW['CATATAN']; ?></textarea>
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