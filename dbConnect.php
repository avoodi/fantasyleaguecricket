<?php
// Connects to my Database
mysql_connect("your.hostaddress.com", "username", "password") or die(mysql_error());
mysql_select_db("Database_Name") or die(mysql_error());
?>
