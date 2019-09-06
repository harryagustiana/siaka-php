<?php

 $host    = "localhost"; 
 $username = ""; 
 $pass   = "";
 $db  = "ciaka_db";
 
 $con = mysqli_connect($host,$username,$pass,$db);
 
 if (mysqli_connect_errno())
 {
	trigger_error("Tidak Dapat Terkoneksi Dengan Database");
 }
 
?> 