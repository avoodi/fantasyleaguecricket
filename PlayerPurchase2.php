<?
session_start();

$leaguename=$_SESSION['leaguename'];
$teamname=$_SESSION['teamname'];
$playername=$_GET['nm'];
//echo $playername ." is the player name passed </br>";

$servername = "localhost:3306";
$dbusername = "fanta_avad";
$dbpassword = "FLeague@2018";
$dbname="fantas10_avad";
// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if ($conn == false) {
  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}


// following query needs playername
$sql="select x.playername, x.reserveprice,ifnull(t.currenthighestbid,x.reserveprice)currenthighestbid, t.ownerteam from LEAGUEAUCTIONRESULTS T, PLAYERMST X where t.playername = x.playername and ifnull(t.leaguename,'X')='$leaguename' AND x.playername='$playername'";
//echo $sql . "</br>";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$playername=$row[0];
	$reserveprice=$row[1];
	$currenthighestbid=$row[2];
	$prevowner=$row[3];
}
mysqli_free_result($result);


$sql2="select ltd.virtualpurchasepower, ltd.currentbidamount, ltd.numberofplayers from leagueteamsdetails ltd where ltd.leaguename='$leaguename' and ltd.teamname= '$teamname' ";
$result = mysqli_query($conn,$sql2) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$virtualpurchasepower=$row[0];
	$currentbidamount=$row[1];
	$numberofplayers=$row[2];
}
mysqli_free_result($result);


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Submit purchase amount</title>
</head>
<body>
<br/><br/><br/><br/>

<form name="frmadd" action="PlayerPurchaseAfterBiddingOver.php" method="post" onSubmit="return valid();">
	<table border="1" cellpadding="2" class="text" cellspacing="2" width="60%" align="center" bordercolordark="#FFFFFF" bordercolorlight="#CCCCCC">
		<TR>
			<td colspan="2" align="center" bgcolor="#FFFFCC" ><h3>Add Purchase amount</h3></td>
		</TR>
		<TR>
			<TD align="right"><b>Player Name :</b></TD>
			<TD><? echo $playername ; ?></TD>
		</TR>
		<TR>
			<TD align="right"><b>Reserve Price :</b></TD>
			<TD><? echo $reserveprice ;?></TD>
		</TR>
		<TR>
			<TD align="right"><b>Current higest Bid :</b></TD>
			<TD><input type="text" name="CurrentbID" value="<? echo $currenthighestbid ; ?>" readonly="true"></TD>
		</TR>
		<TR>
			<TD align="right"><b>Your Cost :</b></TD>
			<TD><input type="text" name="urBId" value=""></TD>
		</TR>
		<TR>
			<td colspan="2" align="center" bgcolor="#FFFFCC"> <input type="submit" name="add" value="Add"  >
			</td>
		</TR>
		<tr><td><input type="hidden" name='virtualPP' value="<? echo $virtualpurchasepower ;?>" > </td>
		<td><input type="hidden" name='currentbidtotal' value="<? echo $currentbidamount ; ?>" > </td>
		<td><input type="hidden" name='numberofplayers' value="<? echo $numberofplayers ; ?>" > </td> </tr>
	</table>
	<input type="hidden" name="nm" value="<? echo $playername ;?>">
	<input type="hidden" name="act" value="add">
	<input type="hidden" name="reserveprice" value="<? echo $reserveprice ;?>">
	<input type="hidden" name="prevowner" value="<? echo $prevowner ;?>">

</form>
</body>
</html>
<script language="javascript">


function valid()
	{

		if(document.frmadd.urBId.value == "")
		{
		 alert("Please enter purchase amount.");
		 document.frmadd.urBId.focus();
		 return false;
		}

		if ( parseInt(document.frmadd.urBId.value) <= parseInt(document.frmadd.CurrentbID.value)+500)
		{
			alert ("Purchase value must be greater then current Bid value + 500");
			document.frmadd.urBId.focus();
			return false;
		}


		if ((parseInt(document.frmadd.virtualPP.value) - parseInt(document.frmadd.urBId.value)) <=10000 )
		{
			alert ("your Purchase power is in danger zone, you can not bid this much");
			document.frmadd.urBId.focus();
			return false;
			}
		else {
			alert ("Your Purchase has been approved  ");

				if ( parseInt(document.frmadd.numberofplayers.value) == 21)
					{
						alert ("this is the 21st player in your team with max bid ; Your total rooster size can be 22 maximum");
						document.frmadd.urBId.focus();
					}

				if ( parseInt(document.frmadd.numberofplayers.value) == 22)
					{
						alert ("This is the LAST player(#22) in your team with max bid ; You will not be able to bid for more.");
						document.frmadd.urBId.focus();
					}
			return true;
			}
		/*return true; */
	}

</script>
