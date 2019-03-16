<?php
// Connects to my Database
//mysql_connect("your.hostaddress.com", "username", "password") or die(mysql_error());
// Connects to my Database
$servername = "localhost";
$username = "fantaftp_avad";
$password = "FLeague@2019";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time
: " . $conn->connect_error);
}
echo "Connected successfully";
?>
