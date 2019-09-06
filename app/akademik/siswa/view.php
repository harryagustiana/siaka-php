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

if($user === '' || $role !== 'KUR0004'){
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
                            Data Siswa
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="/">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Data Siswa
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				<?php
					$datauser = $con->query("SELECT * FROM kmn_user WHERE USERNAME='" . $user . "'");
					$readuser = $datauser->fetch_array();
					
					$datasiswa = $con->query("SELECT * FROM kmn_siswa WHERE ID_PENGGUNA='" . $readuser['ID_PENGGUNA'] . "'");
					$readsiswa = $datasiswa->fetch_array();
					
					$currentmath = max(explode(',',$readsiswa['MATH_LEVEL']));
					$currentefl = max(explode(',',$readsiswa['EFL_LEVEL']));
					
					$matlevel = $con->query("SELECT * FROM kmn_levelkelas WHERE ID_LEVELKELAS='" . $currentmath . "'");
					$readmat = $matlevel->fetch_array();
					
					$efllevel = $con->query("SELECT * FROM kmn_levelkelas WHERE ID_LEVELKELAS='" . $currentefl . "'");
					$readefl = $efllevel->fetch_array();
				?>
                <div class="row">
                    <div class="col-lg-1">
						<p>ID Siswa</p>
                    </div>
					<div class="col-lg-1">
						<p>:</p>
                    </div>
					<div class="col-lg-10">
						<p><?php echo $readsiswa['ID_SISWA']; ?></p>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-1">
						<p>Nama</p>
                    </div>
					<div class="col-lg-1">
						<p>:</p>
                    </div>
					<div class="col-lg-10">
						<p><?php echo $readsiswa['NAMA']; ?></p>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-1">
						<p>Kelas</p>
                    </div>
					<div class="col-lg-1">
						<p>:</p>
                    </div>
					<div class="col-lg-10">
						<p><?php echo $readsiswa['KELAS']; ?></p>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-1">
						<p>Asal Sekolah</p>
                    </div>
					<div class="col-lg-1">
						<p>:</p>
                    </div>
					<div class="col-lg-10">
						<p><?php echo $readsiswa['SEKOLAH']; ?></p>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-3">
						<p>Level Saat Ini</p>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-1">
						<p>Math</p>
                    </div>
					<div class="col-lg-1">
						<p>:</p>
                    </div>
					<div class="col-lg-10">
						<p><?php echo $readmat['NAMA_LEVEL']; ?></p>
                    </div>
                </div>
                <!-- /.row -->
				
				<div class="row">
                    <div class="col-lg-1">
						<p>EFL</p>
                    </div>
					<div class="col-lg-1">
						<p>:</p>
                    </div>
					<div class="col-lg-10">
						<p><?php echo $readefl['NAMA_LEVEL']; ?></p>
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