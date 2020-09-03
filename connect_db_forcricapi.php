<?php
function connect_db(){

	$servername = "103.21.58.5";
	$username = "fanta_avad";
	$password = "FCLipl@2020";
	$dbname="fantalht_5h";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	    die("Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time
	: " . mysqli_connect_error());
	}
	echo "Connected successfully";

	return $conn;
}
?>
