<?php require($_SERVER['DOCUMENT_ROOT'].'/config/database.php'); ?>
<?php require($_SERVER['DOCUMENT_ROOT'].'/function.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sistem Informasi Akademik - {SCHOOL NAME}</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<link rel="icon" type="image/png" href="/assets/images/favicon.png" />	

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
           <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Sistem Informasi Akademik - {SCHOOL NAME}</a>
            </div>
			<ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php if(isset($_SESSION['login_user'])){echo $_SESSION['login_user'];}else{echo "Tidak ada user terdaftar";} ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/index.php?session=logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
						</li>
                    </ul>
                </li>
            </ul>
			<?php
				if(isset($_SESSION['role'])){
					$role = $_SESSION['role'];
				}else{
					$role = "";
				}
			?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li><a href="/app/"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
					<?php
						if($role == "KUR0001"){
							echo "<li><a href=\"javascript:;\" data-toggle=\"collapse\" data-target=\"#master\"><i class=\"fa fa-fw fa-table\"></i> Master Data <i class=\"fa fa-fw fa-caret-down\"></i></a>";
							echo "<ul id=\"master\" class=\"collapse\">";
							echo "<li><a href=\"/app/master/kelas/\"><i class=\"fa fa-fw fa-table\"></i> Manage Kelas</a></li>";
							echo "<li><a href=\"/app/master/user/\"><i class=\"fa fa-fw fa-table\"></i> Manage User</a></li>";
							echo "<li><a href=\"/app/master/role/\"><i class=\"fa fa-fw fa-table\"></i> Manage Role</a></li>";
							echo "</ul></li>";
							echo "<li><a href=\"/app/pembayaran/admin/report.php\"><i class=\"fa fa-fw fa-table\"></i> Lap. Pembayaran</a></li>";
							echo "<li><a href=\"/app/akademik/hasil/report.php\"><i class=\"fa fa-fw fa-table\"></i> Lap. Akademik</a></li>";
						}elseif($role == "KUR0002"){
							echo "<li><a href=\"/app/akademik/siswa/\"><i class=\"fa fa-fw fa-table\"></i> Data Siswa</a></li>";
							echo "<li><a href=\"/app/akademik/hasil/\"><i class=\"fa fa-fw fa-table\"></i> Hasil Belajar</a></li>";
							echo "<li><a href=\"/app/akademik/bahan/\"><i class=\"fa fa-fw fa-table\"></i> Bahan Pelajaran</a></li>";
							echo "<li><a href=\"#\"><i class=\"fa fa-fw fa-table\"></i> Pengumuman</a></li>";
						}elseif($role == "KUR0003"){
							echo "<li><a href=\"/app/pembayaran/admin/\"><i class=\"fa fa-fw fa-table\"></i> Data Pembayaran</a></li>";
						}elseif($role == "KUR0004"){
							echo "<li><a href=\"javascript:;\" data-toggle=\"collapse\" data-target=\"#pembayaran\"><i class=\"fa fa-fw fa-table\"></i> Pembayaran <i class=\"fa fa-fw fa-caret-down\"></i></a>";
							echo "<ul id=\"pembayaran\" class=\"collapse\">";
							echo "<li><a href=\"/app/pembayaran/siswa/register.php\"><i class=\"fa fa-fw fa-table\"></i> Konfirmasi</a></li>";
							echo "<li><a href=\"/app/pembayaran/siswa/\"><i class=\"fa fa-fw fa-table\"></i> Data Pembayaran</a></li>";
							echo "</ul></li>";
							echo "<li><a href=\"javascript:;\" data-toggle=\"collapse\" data-target=\"#akademik\"><i class=\"fa fa-fw fa-table\"></i> Akademik <i class=\"fa fa-fw fa-caret-down\"></i></a>";
							echo "<ul id=\"akademik\" class=\"collapse\">";
							echo "<li><a href=\"/app/akademik/siswa/view.php\"><i class=\"fa fa-fw fa-table\"></i> Data Siswa</a></li>";
							echo "<li><a href=\"/app/akademik/hasil/data.php\"><i class=\"fa fa-fw fa-table\"></i> Hasil Belajar</a></li>";
							echo "<li><a href=\"/app/akademik/bahan/view.php\"><i class=\"fa fa-fw fa-table\"></i> Bahan Pelajaran</a></li>";
							echo "</ul></li>";
						}else{
							echo "";
						}
					?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>