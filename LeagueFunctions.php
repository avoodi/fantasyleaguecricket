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
			{  $count=$row[0]; }
		mysqli_free_result($result);
		if ($count>0) { $retmsg=  "sorry leaguename already exists!"; }
		if ($count==0) { $retmsg="good to go , leaguename is new, proceed to add";}
		return $retmsg;
}

// insert league function
function insertNewLeague($leaguename, $ownername){
	//all league checks done, so inserting league in key tables
		global $conn;
		$sql = "insert into league_mst (leaguename,leaguecreatorname) values ('$leaguename','$ownername')";
		if(! mysqli_query($conn,$sql) ) { die('error sql1'); }
		//	echo " record added to league mst now add to leaguerules ";
		$sql2 = "insert into leaguerules (leaguename, maxteams, maxtrades, runpoints,catchpoints,wicketpoints,runoutpoints, MAIDENOVERPOINTS, boundrypoints, SIXERPOINTS, purchasepower, biddingstatus) values ('$leaguename',14,24,1,2,3,3,3,4,6,15000000,'Started-InProgress')";
		if(! mysqli_query($conn,$sql2) ) { die('error sql2');}
 		//echo " now taking all players list and inserting into LEAGUEAUCTIONRESULTS for this league" ;
			$i=0;
			$sql4="select PLAYERNAME,RESERVEPRICE,ifnull(PID,0) from playermst";
			$result = mysqli_query($conn,$sql4) ;
		while( $row = mysqli_fetch_array( $result ) )	{
				$pname[$i]=$row[0];
				$rprice[$i]=$row[1];
				$pid[$i]=$row[2];
				$i=$i+1;
			}
		mysqli_free_result($result);
		//echo "after creating playermst array  i is  " . $i;
		for ($j=0; $j<$i; $j++) {
				$sql5="insert into  leagueauctionresults  (leaguename,playername,currenthighestbid,pid) values ('$leaguename','$pname[$j]',$rprice[$j],$pid[$j]);";
				if(! mysqli_query($conn,$sql5) ) { die('error sql5'); }
			}
}

	function leagueCleanUp($leaguename) {
		global $conn;
		$sql="delete from league_mst where leaguename='$leaguename'";
		$sql2="delete from leaguerules where leaguename='$leaguename'";
		$sql3="delete from leagueauctionresults where leaguename='$leaguename'";

		if(! mysqli_query($conn,$sql) ) { die('error del league_mst sql');}
		if(! mysqli_query($conn,$sql2) ) { die('error del leaguerules sql');}
		if(! mysqli_query($conn,$sql3) ) { die('error del leagueauctionresults sql');}

	}
?>
