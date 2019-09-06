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
if($user === "" || $role !== "KUR0001"){	
	$_SESSION['error_msg'] = "You should login to access the page";
	echo'<script>window.location="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '";</script>';
}else{

?>

<?php require($_SERVER['DOCUMENT_ROOT'].'/header.php'); ?>

<?php	
	$datasiswa = $con->query("SELECT COUNT(ID_SISWA) as TotalSiswa FROM kmn_siswa");
	$readsiswa = $datasiswa->fetch_array();
?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Report Pembayaran
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-bar-chart-o"></i> Report Pembayaran
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<?php
					$currentyear = date('Y');
					
					if(isset($_POST['cari'])){
						if(isset($_POST['tahun'])){
							for($i=1;$i<=12;$i++){
								$data[$i] = $con->query("SELECT COUNT(NO_PEMBAYARAN) as TotalBayar FROM kmn_pembayaran WHERE BULAN = '" . $i . "' AND TAHUN = '". $_POST['tahun'] . "' AND STATUS = '1'");
								$read[$i] = $data[$i]->fetch_array();
							}
							$tahun = $_POST['tahun'];
						}
						else{
							for($i=1;$i<=12;$i++){
								$data[$i] = $con->query("SELECT COUNT(NO_PEMBAYARAN) as TotalBayar FROM kmn_pembayaran WHERE BULAN = '" . $i . "' AND TAHUN = '". $currentyear . "' AND STATUS = '1'");
								$read[$i] = $data[$i]->fetch_array();
							}
							$tahun = 2016;
						}
					}elseif(isset($_POST['reset'])){
						for($i=1;$i<=12;$i++){
							$data[$i] = $con->query("SELECT COUNT(NO_PEMBAYARAN) as TotalBayar FROM kmn_pembayaran WHERE BULAN = '" . $i . "' AND TAHUN = '". $currentyear . "' AND STATUS = '1'");
							$read[$i] = $data[$i]->fetch_array();
						}
						$tahun = 2016;
					}else{
						for($i=1;$i<=12;$i++){
							$data[$i] = $con->query("SELECT COUNT(NO_PEMBAYARAN) as TotalBayar FROM kmn_pembayaran WHERE BULAN = '" . $i . "' AND TAHUN = '". $currentyear . "' AND STATUS = '1'");
							$read[$i] = $data[$i]->fetch_array();
						}
						$tahun = 2016;

					}
				?>
				
				<div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a data-toggle="collapse" href="#demo" id="filter" style="text-decoration: none; color: #000;"><h3 class="panel-title"><i class="fa fa-bars" aria-hidden="true"></i> Filter Data</h3></a>
                            </div>
                            <div class="panel-body collapse" id="demo" >
								<div class="row">
									<div class="col-sm-6">
									<form role="form" action="" method="post">
											<div class="form-group">
												<label>Tahun</label>
												<select class="form-control" name="tahun" id="tahun">
												<?php
													$firstyear = 2010;
													$currentyear = date('Y');
													while ($firstyear <= $currentyear){
												?>
													<option value="<?php echo $firstyear; ?>"><?php echo $firstyear; ?></option>
												<?php
														$firstyear++;
													}
												?>
												</select>
											</div>										
									</div>
									
								</div>
								
								<div class="row">
									<div class="col-sm-12">
											<button type="submit" class="btn btn-primary" name="cari" style="display: block; float: left;margin-right: 10px;">Cari</button>								
											<button type="submit" class="btn btn-default" name="reset" style="display: block; float: left;">Reset</button>											
									</div>
								</div>
								</form>
                            </div>
                        </div>
					</div>
				</div>



                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Report Pembayaran</h3>
                            </div>
                            <div class="panel-body">
                                <div id="chart" data-id="<?php echo $tahun; ?>"></div>
                                <div class="text-right" style="margin-top: 10px;">
                                    <a href="export.php?tahun=<?php echo $tahun; ?>">Export Data to Excel <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Highcharts Charts Highcharts -->
	<script src="/assets/highchart/highcharts.js"></script>
	<script src="/assets/highchart/modules/exporting.js"></script>
	
	<script>
	var tahun = <?php echo $tahun; ?>;
	$(function () {
		$('#chart').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: 'Pembayaran ' + tahun
			},
			xAxis: {
				categories: [
					'Jan',
					'Feb',
					'Mar',
					'Apr',
					'May',
					'Jun',
					'Jul',
					'Aug',
					'Sep',
					'Oct',
					'Nov',
					'Dec'
				],
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Jumlah Siswa'
				},
				max: <?php echo $readsiswa['TotalSiswa'] ?>
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'Total Pembayaran',
				data: [ <?php echo $read[1]['TotalBayar']; ?>,
						<?php echo $read[2]['TotalBayar']; ?>,
						<?php echo $read[3]['TotalBayar']; ?>,
						<?php echo $read[4]['TotalBayar']; ?>,
						<?php echo $read[5]['TotalBayar']; ?>,
						<?php echo $read[6]['TotalBayar']; ?>,
						<?php echo $read[7]['TotalBayar']; ?>,
						<?php echo $read[8]['TotalBayar']; ?>,
						<?php echo $read[9]['TotalBayar']; ?>,
						<?php echo $read[10]['TotalBayar']; ?>,
						<?php echo $read[11]['TotalBayar']; ?>,
						<?php echo $read[12]['TotalBayar']; ?>]

			}]
		});
	});
	</script>
	
<?php require($_SERVER['DOCUMENT_ROOT'].'/footer.php'); ?>
<?php
	}
?>