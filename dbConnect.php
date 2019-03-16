<?php
// Connects to my Database
//mysql_connect("your.hostaddress.com", "username", "password") or die(mysql_error());
$servername = "localhost";
$dbusername = "fantaftp_avad";
$dbpassword = "FLeague@2019";
$dbname="fantaftp_avad";
// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if ($conn == false) {
  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}
mysql_select_db("Database_Name") or die(mysql_error());
?>
