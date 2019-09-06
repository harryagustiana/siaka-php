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
                            Register Bahan Pelajaran
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/app/akademik/bahan/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Register Bahan Pelajaran
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
								$idbahan = "KBM" . autoNumber('ID_MATAPELAJARAN','kmn_bahanpelajaran');
								$idlevel = $_POST['idlevel'];
								$keterangan = $_POST['keterangan'];

								$sql = "INSERT INTO kmn_bahanpelajaran VALUES ('" . $idbahan . "','" . $idlevel . "','" . $keterangan . "')";

								if ($con->query($sql) === TRUE) {
									echo "<div class=\"alert alert-success\">";
									echo "<strong>New bahan</strong> created successfully";
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
                                <label>Level</label>
                                <select class="form-control chosen-select" name="idlevel">
									<?php
										$res = $con->query("SELECT * FROM kmn_levelkelas");
										while($row = $res->fetch_array())
										{
									?>
                                    <option value="<?php echo $row['ID_LEVELKELAS']; ?>"><?php echo $row['MATA_PELAJARAN'] . " - " . $row['NAMA_LEVEL']; ?></option>
									<?php
										}
									?>
                                </select>
                            </div>
				
					</div>
				</div>
							
				<div class="row">
                    <div class="col-lg-12">
							
							<div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control" name="keterangan" placeholder="Enter keterangan"></textarea>
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
	
	<link rel="stylesheet" href="/assets/plugin/chosen/bootstrap-chosen.css" type="text/css">
	
	<script src="/assets/plugin/chosen/chosen.jquery.js"></script>
	<script>
		$(function() {
		$('.chosen-select').chosen();
		});
	</script>

<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>