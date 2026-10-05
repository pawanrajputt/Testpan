<?php 
 define("HOSTNAME", "Localhost");
 define("USERNAME", "root");
 define("PASSWORD", "Testpan@222");
 define("DATABASE", "testpan");
 


 
$conn = new mysqli(HOSTNAME,USERNAME,PASSWORD,DATABASE) or Die("Unable To Connect Database");

// date_default_timezone_set('Asia/Kolkata');
// $c_datetime=date('Y-m-d H:i:s');

 if ($conn->connect_error) {
 	die("Connection failed: " . $conn->connect_error);
 }
 
 $qry="insert into tt_cron set name='hello' "
$res=mysqli_query($conn,$qry) or die(mysql_error());
 
 
 
 
 ?>