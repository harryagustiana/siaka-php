<?php

session_start(); // Memulai Session
$message=''; // Variabel untuk menyimpan pesan error

if(isset($_SESSION['error_msg'])){
	$message = "You don't have right to access the page. Please log in as another account or click <a href=\"javascript:history.back()\"><strong>here</strong></a> to go back";
}

if(isset($_GET['session'])){
	if($_GET['session'] == 'logout'){
		$message = "You've been logged out";
		session_destroy();
		session_start();
	}
}

if (isset($_POST['submit'])) {
	
	if (isset($_POST['username'])){
		// Variabel username dan password
		$user=$_POST['username'];
		// Membangun koneksi ke database
		require($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
		// Mencegah MySQL injection 
		$user = stripslashes($user);
		$user = mysqli_real_escape_string($con, $user);
		// Seleksi Database
		// SQL query untuk memeriksa apakah karyawan terdapat di database?
		$bacauser = "SELECT * FROM kmn_user WHERE USERNAME='" . $user . "'";
		$readuser = $con->query($bacauser);
		$datauser = $readuser->fetch_array();
		if(!empty($datauser)){
			$_SESSION['login_user'] = $user;
			$_SESSION['role'] = $datauser['ID_LEVELPENGGUNA'];// Membuat Sesi/session
			echo'<script>window.location="//' . $_SERVER['SERVER_NAME'] . '/check-password.php";</script>'; // Mengarahkan ke halaman profil
		} else {
			$message = "Username tidak terdaftar atau salah!";
		}
		$con->close();
	}
}
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Sistem Informasi Akademik - {SCHOOL NAME}</title>
  <link rel="stylesheet" href="/assets/css/login.css">
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/custom.css" rel="stylesheet">
  <link href="/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link rel="icon" type="image/png" href="/assets/images/favicon.png" />	

  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <div class="container">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <center><h2>{SCHOOL NAME}</h2></center>
            <p id="profile-name" class="profile-name-card"></p>
			<?php
				if($message != NULL){
					echo "<div class=\"alert alert-danger\">";
					echo $message;
					echo "</div>";
				}
			?>
            <form class="form-signin" action="" method="post">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" name="username" id="username" class="form-control" placeholder="Input username" required autofocus>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="submit">Continue</button>
            </form><!-- /form -->
            <a href="#" class="forgot-password">
                Forgot the username or password?
            </a>
        </div><!-- /card-container -->
    </div><!-- /container -->
	
	<!--<script src="/assets/js/login.js"></script> -->
	
	<!-- jQuery -->
    <script src="/assets/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/assets/js/bootstrap.min.js"></script>
</body>
</html>
