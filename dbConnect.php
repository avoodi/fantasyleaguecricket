<?php
// Connects to my Database
//mysql_connect("your.hostaddress.com", "username", "password") or die(mysql_error());
// Connects to my Database

$servername = "119.18.54.125";
$username = "fantaycc_avad";
$password = "FCLipl@2020";
$dbname="fantaycc_2805";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time
: " . mysqli_connect_error());
}
//echo "Connected successfully"; ?>
