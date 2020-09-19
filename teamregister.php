#!/usr/bin/php
<?
//echo $_POST['teamname']. " and " . $_POST['OwnerName'] . " and " . $_POST['OwnerEmail'] . " and " . $_POST['leaguename']. " and pass is ". $_POST['Pass'];
$teamname=$_POST['teamname'];
$ownername=$_POST['OwnerName'];
$owneremail=$_POST['OwnerEmail'];


include "dbConnect.php";
global $conn;

//set session vars
session_start();
$_SESSION['username']=$ownername;
$_SESSION['$owneremail']=$owneremail;
$_SESSION['pwd']=$_POST['Pass'];
$_SESSION['teamname'] = $teamname;


$password=$_POST['Pass'];


// Create connection
//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if ($conn == false) {
	echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}
$count=0;
if (isset($_POST['selLeagueName']) )
{
	$leaguename = $_POST['selLeagueName'];
	$_SESSION['leaguename']=$leaguename;
	// if user selected existing league then stop him from creating team with same name
	$sql="select count(*) from leagueteamsdetails where leaguename='$leaguename' and teamname='$teamname' ";
	//	echo $sql;
	$result = mysqli_query($conn,$sql) ;
	while( $row = mysqli_fetch_array( $result ) )
	{
		$count=$row[0];
	}
	mysqli_free_result($result);
	if ($count>0) {
		echo '<script type="text/javascript">alert("sorry teamname already exists in same league!"); window.location = "./teamlogin.php" </script>';
	}
	if ($leaguename='Select league')
	{
		echo '<script type="text/javascript">alert("Please select correct league name from the dropdown!"); window.location = "./teamlogin.php" </script>';
	}
}
else {
	$leaguename=$_POST['leaguename'];

 	$existingleague="no";
 	// check if user tried to enter league name that is already in db
	$sql="select count(*) from league_mst where leaguename='$leaguename' ";
//	echo $sql;
	$result = mysqli_query($conn,$sql) ;
	while( $row = mysqli_fetch_array( $result ) )
	{
		$count=$row[0];
	}
	mysqli_free_result($result);
	if ($count>0) {
		echo '<script type="text/javascript">alert("sorry leaguename already exists!"); window.location = "./teamlogin.php" </script>';
	}


}

//echo " the session vars are  " . $_SESSION['teamname'] . " and " . $_SESSION['leaguename']  ."<br/>" ;

if ($existingleague=="no" && $count==0){
// this means its a new league - and then we have to set it up by inserting into 3 tables
// lets first set this user as leaguecreator
$_SESSION['teamownername']=$ownername;
$_SESSION['leaguename']=$leaguename;

	$sql = "insert into league_mst (leaguename,leaguecreatorname) values ('$leaguename','$ownername')";
//	$var=array($leaguename, $ownername);
	//echo $sql ;

	if(! mysqli_query($conn,$sql) )
		{
			die('error sql1');
		}

	//	echo " record added to league mst now add to leaguerules ";
	$sql2 = "insert into leaguerules (leaguename, maxteams, maxtrades, runpoints,catchpoints,wicketpoints,runoutpoints, MAIDENOVERPOINTS, boundrypoints, SIXERPOINTS, purchasepower, biddingstatus) values ('$leaguename',14,24,1,2,3,3,3,4,6,15000000,'Started-InProgress')";
		if(! mysqli_query($conn,$sql2) )
			{
				die('error sql2');
			}

 //echo " now taking all players list and inserting into LEAGUEAUCTIONRESULTS for this league" ;
			$i=0;

			$sql4="select PLAYERNAME,RESERVEPRICE,ifnull(PID,0) from playermst";

//	echo $sql4;

			$result = mysqli_query($conn,$sql4) ;
			while( $row = mysqli_fetch_array( $result ) )
			{
				$pname[$i]=$row[0];
				$rprice[$i]=$row[1];
					$pid[$i]=$row[2];

				$i=$i+1;
			}
			mysqli_free_result($result);
//echo "after creating playermst array  i is  " . $i;

	for ($j=0; $j<$i; $j++) {
				$sql5="insert into  leagueauctionresults  (leaguename,playername,currenthighestbid,pid) values ('$leaguename','$pname[$j]',$rprice[$j],$pid[$j]);";
//		echo $sql5;
				if(! mysqli_query($conn,$sql5) )
				{
					die('error sql5');
				}
		$sql5="";
			}

	}

if ($count ==0 && $leaguename != 'Select league') {
// need to insert team details to leagueteamdetails
	$sql3= "insert into leagueteamsdetails (teamname, leaguename, teamownername, teamowneremail,team_password, purchasepower, numberofplayers, totalteamscore, matcheswon, matcheslost, matchesdrawn, averagescore, currentbidamount, virtualpurchasepower, points, averagestrikerate) values('$teamname','$leaguename','$ownername','$owneremail','$password',15000000,0,0,0,0,0,0,0,15000000,0,0)";
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
		<td align="center"><strong>Thanks</strong>For Team Registration.</td>
	</tr>
	<tr>
		<td align="center">You can continue by visting your team page link given below :</td>
	</tr>
	<tr>
		<td align="center">Login URL :<a href="teamLandingPg.php"><strong>Click Here?</strong></a> </td>
	</tr>	<tr>
			<td align="center"> If you have any questions please write to avoodi@gmail.com </td>
		</tr>
</table>

</body>
</html>
