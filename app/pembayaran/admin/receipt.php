<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/database.php');

if(isset($_GET['nobayar'])){
	$nobayar = $_GET['nobayar'];
	
	$readbayar = $con->query("SELECT * FROM kmn_pembayaran WHERE NO_PEMBAYARAN = '" . $nobayar . "'");
	$databayar = $readbayar->fetch_array();
	
	$readsiswa = $con->query("SELECT * FROM kmn_siswa WHERE ID_SISWA = '" . $databayar['ID_SISWA'] . "'");
	$datasiswa = $readsiswa->fetch_array();
}
 // Define relative path from this script to mPDF
$nama_dokumen='Receipt-'.$nobayar; //Beri nama file PDF hasil.
include_once($_SERVER['DOCUMENT_ROOT'].'/assets/plugin/mpdf/mpdf.php');
$mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0); // Create new mPDF Document
 
//Beginning Buffer to save PHP variables and HTML tags
ob_start(); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Print Kwitansi <?= $nobayar; ?></title>
	<link rel="icon" type="image/png" href="/assets/images/favicon.png" />	
    <style>
        *
        {
            margin:0;
            padding:0;
            font-family:Arial;
            font-size:10pt;
            color:#000;
        }
        body
        {
            width:100%;
            font-family:Arial;
            font-size:10pt;
            margin:0;
            padding:0;
        }
         
        p
        {
            margin:0;
            padding:0;
        }
         
        #wrapper
        {
            width:180mm;
            margin:0 15mm;
        }
         
        .page
        {
            height:297mm;
            width:210mm;
            page-break-after:always;
        }
 
        table
        {
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
             
            border-spacing:0;
            border-collapse: collapse; 
             
        }
         
        table td 
        {
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 2mm;
        }
         
        table.heading
        {
            height:50mm;
        }
         
        h1.heading
        {
            font-size:14pt;
            color:#000;
            font-weight:normal;
        }
         
        h2.heading
        {
            font-size:9pt;
            color:#000;
            font-weight:normal;
        }
         
        hr
        {
            color:#ccc;
            background:#ccc;
        }
         
        #invoice_body
        {
            height: 149mm;
        }
         
        #invoice_body , #invoice_total
        {   
            width:100%;
        }
        #invoice_body table , #invoice_total table
        {
            width:100%;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
     
            border-spacing:0;
            border-collapse: collapse; 
             
            margin-top:5mm;
        }
         
        #invoice_body table td , #invoice_total table td
        {
            text-align:center;
            font-size:9pt;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding:2mm 0;
        }
         
        #invoice_body table td.mono  , #invoice_total table td.mono
        {
            font-family:monospace;
            text-align:right;
            padding-right:3mm;
            font-size:10pt;
        }
         
        #footer
        {   
            width:180mm;
            margin:0 15mm;
            padding-bottom:3mm;
        }
        #footer table
        {
            width:100%;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
             
            background:#eee;
             
            border-spacing:0;
            border-collapse: collapse; 
        }
        #footer table td
        {
            width:25%;
            text-align:center;
            font-size:9pt;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>
<div id="wrapper">
     
    <p style="text-align:center; font-weight:bold; padding-top:5mm;">KWITANISI <?= $nobayar; ?></p>
    <br />
    <table class="heading" style="width:100%;">
        <tr>
            <td style="width:80mm;">
                <h1 class="heading">{SCHOOL NAME}</h1>
                <h2 class="heading">
                    123 Happy Street<br />
                    CoolCity - Pincode<br />
                    Region , Country<br />
                     
                    Website : www.website.com<br />
                    E-mail : info@website.com<br />
                    Phone : +1 - 123456789
                </h2>
            </td>
            <td rowspan="2" valign="top" align="right" style="padding:3mm;">
                <table>
                    <tr><td>Receipt No : </td><td><?= $nobayar; ?></td></tr>
                    <tr><td>Dated : </td><td><?php echo date('d F Y'); ?></td></tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <b>Atas nama siswa :<br />
                <?= $databayar['NO_PEMBAYARAN']; ?><br />
				<?= $datasiswa['NAMA']; ?><br />
				Kelas : <?= $datasiswa['KELAS']; ?><br />
                Asal Sekolah : <?= $datasiswa['SEKOLAH']; ?><br />
            </td>
        </tr>
    </table>
         
         
    <div id="content">
         
        <div id="invoice_body">
            <table>
            <tr style="background:#eee;">
                <td style="width:8%;"><b>No.</b></td>
                <td><b>Deskripsi</b></td>
                <td style="width:15%;"><b>Total</b></td>
            </tr>
            </table>
             
            <table>
            <tr>
                <td style="width:8%;">1</td>
                <td style="text-align:left; padding-left:10px;">Pembayaran untuk bulan <?php echo date("F", mktime(0, 0, 0, $databayar['BULAN'], 1)); ?> tahun <?= $databayar['TAHUN']; ?></td>
                <td style="width:15%;" class="mono"><?= $databayar['JUMLAH']; ?></td>
            </tr>         
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
             
            <tr>
                <td></td>
                <td>Total :</td>
                <td class="mono"><?= $databayar['JUMLAH']; ?></td>
            </tr>
        </table>
        </div>
        <br />
        <hr />
        <br />
         
        <table style="width:100%; height:35mm;">
            <tr>
                <td style="width:65%;" valign="top">
                    Receipt Information:<br />
                    This receipt is printed only by<br />
                    <b>{SCHOOL NAME}</b>
                    <br /><br />
                    Alamat {SCHOOL NAME}.<br /><br />
                </td>
                <td>
                <div id="box">
                    E &amp; O.E.<br />
                    For ABC Corp<br /><br /><br /><br />
                    Authorised Signatory
                </div>
                </td>
            </tr>
        </table>
    </div>
     
    <br />
     
    </div>
     
    <htmlpagefooter name="footer">
        <hr />
        <div id="footer"> 
            <table>
                <tr><td>Software Solutions</td><td>Mobile Solutions</td><td>Web Solutions</td></tr>
            </table>
        </div>
    </htmlpagefooter>
    <sethtmlpagefooter name="footer" value="on" />
     
</body>
</html>
<?php
$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output($nama_dokumen.".pdf" ,'I');
exit;
?>