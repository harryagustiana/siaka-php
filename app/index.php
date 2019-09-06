<?php session_start(); ?>
<?php
	if(isset($_SESSION['login_user']) && isset($_SESSION['role'])){
		$user = $_SESSION['login_user'];
		$role = $_SESSION['role'];
	}else{
		$user = "";
		$role = "";
	}	
	
	if($user == ""){
		$_SESSION['error_msg'] = "";
		echo'<script>window.location="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '";</script>';
	}else{
?>
<?php require($_SERVER['DOCUMENT_ROOT'].'/header.php'); ?>

<div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header" style="text-align: center;">
                            Selamat Datang Di <br/>Aplikasi Sistem Informasi Akademik<br/> {SCHOOL NAME}
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
				
				

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

	
</body>

</html>

<?php
	}
?>