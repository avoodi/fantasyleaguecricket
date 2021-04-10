#!/usr/bin/php
<?
include "dbConnect.php";
//global $conn;
if ($conn == false) {
	$retmsg= "Sorry, we tried, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}
//echo "in find if league exixts" ;
function findLeagueExists($leaguename) {
		global $conn;
		$retmsg="Invalid";
		$count=0;
		$sql="select count(*) from league_mst where leaguename='$leaguename' ";
		//echo $sql;
		$result = mysqli_query($conn,$sql) ;
	while( $row = mysqli_fetch_array( $result ) )
	{
	 $count=$row[0];
	}
		mysqli_free_result($result);
		if ($count>0) {
		 $retmsg=  "sorry leaguename already exists!";
		}
		if ($count==0) {
			$retmsg="good to go , leaguename is new, proceed to add";
		}
		return $retmsg;
}
//$msg=findLeagueExists("dumbo");
//echo $msg;
?>
