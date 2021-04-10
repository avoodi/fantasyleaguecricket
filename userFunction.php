#!/usr/bin/php
<?
include "dbConnect.php";
//global $conn;
if ($conn == false) {
	$retmsg= "Sorry, we tried, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}
//echo "in find if league exixts" ;
function findUserExists($username) {
		global $conn;
		$count=0;
		$sql="SELECT count(*)  FROM leagueteamsdetails WHERE TEAMOWNEREMAIL='$username'  ";
		//echo $sql;
		$result = mysqli_query($conn,$sql) ;
		while( $row = mysqli_fetch_array( $result ) )
			{  $count=$row[0]; }
		mysqli_free_result($result);
		if ($count>0) { $retmsg=  "User Exists"; }
		if ($count==0) { $retmsg="User Does Not Exist";}
		return $retmsg;
}

function isUserIdPwdCorrect($usernamem,$pwd) {
		global $conn;
		$count=0;
		$sql="SELECT count(*)  FROM leagueteamsdetails WHERE TEAMOWNEREMAIL='$username' and TEAM_PASSWORD ='$pwd' ";
		//echo $sql;
		$result = mysqli_query($conn,$sql) ;
		while( $row = mysqli_fetch_array( $result ) )
			{  $count=$row[0]; }
		mysqli_free_result($result);
		if ($count>0) { $retmsg=  "Userid and pwd are correct"; }
		if ($count==0) { $retmsg="Userid and pwd combination Not matching. Pl Retry / contact us ";}
		return $retmsg;
}

function allLeaguesForUser($username) {
	  global $conn;
		$count=0;
		$sql="select distinct(leaguename) from leagueteamsdetails where teamowneremail='$username'";
		echo $sql;
		$result= mysqli_query($conn,$sql);
		while($row=mysqli_fetch_array($result))
		{
			$leaguename_array[$count]=$row[0];
			$count++;
		}
		return $leaguename_array;
}
?>
