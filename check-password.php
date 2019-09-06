<?php

session_start(); // Memulai Session
$message=''; // Variabel untuk menyimpan pesan error

if(empty($_SESSION['login_user'])){
	echo'<script>window.location="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '";</script>'; // Mengarahkan ke halaman profil
}

if(isset($_POST['clear'])){
	session_destroy();
	$message = "You should login to access the page";
}

if (isset($_POST['submit'])) {
	
	if (empty($_POST['username']) || empty($_POST['password'])) {
			$message = "Fill in all field";
	}
	else
	{
		// Variabel username dan password
		$user=$_POST['username'];
		$sandi=$_POST['password'];
		// Membangun koneksi ke database
		require_once($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
		// Mencegah MySQL injection 
		$user = stripslashes($user);
		$sandi = stripslashes($sandi);
		$user = mysqli_real_escape_string($con, $user);
		$sandi = mysqli_real_escape_string($con, $sandi);
		// Seleksi Database
		// SQL query untuk memeriksa apakah karyawan terdapat di database?
		$bacauser = "SELECT * FROM kmn_user WHERE USERNAME='" . $user . "' AND PASSWORD='" . md5($sandi) . "'";
		$readuser = $con->query($bacauser);
		$datauser = $readuser->fetch_array();
		if(!empty($datauser)){
			$_SESSION['login_user'] = $user; // Membuat Sesi/session
			echo'<script>window.location="//' . $_SERVER['SERVER_NAME'] . '/app/";</script>'; // Mengarahkan ke halaman profil
		} else {
			$message = "Username atau Password belum terdaftar";
		}
		$con->close();
	}
}

if (isset($_POST['loganother'])){
	session_destroy();
	echo'<script>window.location="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '";</script>';
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
            <img id="profile-img" src="/assets/images/login-logo.png" width=100% height=auto />
            <p id="profile-name" class="profile-name-card"></p>
			<?php
				if($message != NULL){
					echo "<div class=\"alert alert-danger\">";
					echo $message;
					echo "</div>";
				}
			?>
            <form class="form-signin" name="checkpass" action="" method="post">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo $_SESSION['login_user']; ?>" readonly="readonly" required>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autofocus>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="submit">Sign in</button>
            </form><!-- /form -->
			<form class="form-signin" name="checkpass" action="" method="post">
				<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="loganother">Log In As Another Account</button>
			</form>
            <a href="#" class="forgot-password">
				Forgot credential?
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
