#!/usr/bin/php
<?
//echo $_POST['teamname']. " and " . $_POST['OwnerName'] . " and " . $_POST['OwnerEmail'] . " and " . $_POST['leaguename']. " and pass is ". $_POST['Pass'];
$uname=$_POST['uname'];
$userpassword=$_POST['userpassword'];
$groupname=$_POST['groupname'];
$grouppwd=$_POST['grouppwd'];

//echo $uname;

include "dbConnect.php";
global $conn;
//echo " now user name ".$uname;
//set session vars
session_start();
$_SESSION['uname']=$uname;
$_SESSION['userpassword']=$userpassword;
$_SESSION['grouppwd'] = $grouppwd;
// Check connection
if ($conn == false) {
	echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}
$count=0;
if (isset($_POST['selGroupName']) )
{
	$groupname = $_POST['selGroupName'];
	$_SESSION['groupname']=$groupname;
	// if user selected existing league then stop him from creating team with same name
	$sql="select count(*) from leagueteamsdetails where leaguename='$groupname' and teamname='$uname' ";
	//	echo $sql;
	$result = mysqli_query($conn,$sql) ;
	while( $row = mysqli_fetch_array( $result ) )
	{
		$count=$row[0];
	}
	mysqli_free_result($result);
	if ($count>0) {
		echo '<script type="text/javascript">alert("sorry username already exists in same league!"); window.location = "./DQteamlogin.php" </script>';
	}

}
else {
	$groupname=$_POST['groupname'];

 	$existinggroup="no";
 	// check if user tried to enter league name that is already in db
	$sql="select count(*) from league_mst where leaguename='$groupname' ";
	//echo "in new group ". $sql;
	$result = mysqli_query($conn,$sql) ;
	while( $row = mysqli_fetch_array( $result ) )
	{
		$count=$row[0];
	}
	mysqli_free_result($result);
	if ($count>0) {
		echo '<script type="text/javascript">alert("sorry groupname already exists!"); window.location = "./DQteamlogin.php" </script>';
	}


}

//echo " the session vars are  " . $_SESSION['teamname'] . " and " . $_SESSION['leaguename']  ."<br/>" ;

if ($existinggroup=="no" && $count==0){
// this means its a new league - and then we have to set it up by inserting into 3 tables
// lets first set this user as leaguecreator
$_SESSION['groupname']=$groupname;
$_SESSION['grouppwd']=$grouppwd;
	$sql = "insert into league_mst (leaguename,leaguecreatorname, biddingstatus) values ('$groupname','$uname','NotApplicable')";
//	$var=array($leaguename, $ownername);
	//echo $sql ;
	if(! mysqli_query($conn,$sql) )
		{
			die('error sql1');
		}
	//	echo " record added to league mst now add to leaguerules ";
			$i=0;
$sql_1="insert into DQMaster (question, qId, groupname, qPoints) values ('who will win today(Match1)', 1, '$groupname',10)";
$sql_2="insert into DQMaster (question, qId, groupname, qPoints) values ('who will be the man of the match((Match1- pl copy/paste from list below))', 2, '$groupname',10)";
$sql_3="insert into DQMaster (question, qId, groupname, qPoints) values ('how many sixers will be hit(Match1)', 3, '$groupname',10)";
$sql_4="insert into DQMaster (question, qId, groupname, qPoints) values ('who will win today(Match2)', 4, '$groupname',10)";
$sql_5="insert into DQMaster (question, qId, groupname, qPoints) values ('who will be the man of the match((Match2- pl copy/paste from list below))', 5, '$groupname',10) ";
$sql_6="insert into DQMaster (question, qId, groupname, qPoints) values ('how many sixers will be hit(Match2)', 6, '$groupname',10)";

if(! mysqli_query($conn,$sql_1) )
	{
		die('error sql_1');
	}
if(! mysqli_query($conn,$sql_2) )
	{
		die('error sql_2');
	}
if(! mysqli_query($conn,$sql_3) )
	{
		die('error sql_3');
	}
if(! mysqli_query($conn,$sql_4) )
	{
		die('error sql_4');
	}
if(! mysqli_query($conn,$sql_5) )
	{
		die('error sql_5');
	}
if(! mysqli_query($conn,$sql_6) )
	{
		die('error sql_6');
	}

}

if ($count ==0 ) {
// need to insert team details to leagueteamdetails
	$sql3= "insert into leagueteamsdetails (teamname, leaguename, teamownername, teamowneremail,team_password, purchasepower, numberofplayers, totalteamscore, matcheswon, matcheslost, matchesdrawn, averagescore, currentbidamount, virtualpurchasepower, points, averagestrikerate) values('$uname','$groupname','$uname','$grouppwd','$userpassword',0,0,0,0,0,0,0,0,0,0,0)";
//echo $sql3 ."\n";
	if(! mysqli_query($conn,$sql3) )
	{
		die('error sql3');
	}
}
//echo " record added to teamdetails \n";

// after all this the last step to setup the league is to enter all players list into LEAGUEAUCTIONRESULTS table


?>
<html>
<head></head>

<body>
<link rel="stylesheet" type="text/css" href="images/dat.css">

<br/><br/><br/>
<table border="1" cellpadding="0" cellspacing="0" width="50%" class="pagenav" align="center" bgcolor="#FFFFCC" bordercolordark="#CCCCCC" bordercolorlight="#FFFFCC">
	<tr>
		<td align="center"><strong>Thanks</strong>For Registration.</td>
	</tr>
	<tr>
		<td align="center">You can continue by visting your team page link given below :</td>
	</tr>
	<tr>
		<td align="center">Login URL :<a href="DQLandingPg.php"><strong>Click Here?</strong></a> </td>
	</tr>	<tr>
			<td align="center"> If you have any questions please write to avoodi@gmail.com </td>
		</tr>
</table>

</body>
</html>
