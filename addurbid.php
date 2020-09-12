<?
session_start();
//if($_SESSION['username'])
//{
//	echo "user name is ". $_SESSION['username'] . " and pass is " . $_SESSION['pass'] ."  and leagueis " . $_SESSION['leaguename'] . " and team is " . $_SESSION['teamname'] ;
//}
//echo " in addurbid page";
/* get the query for LEAGUEAUCTIONRESULTS here */

$leaguename=$_SESSION['leaguename'];
$teamname=$_SESSION['teamname'];
$playername=$_GET['nm'];
//echo $playername ." is the player name passed </br>";
include "dbConnect.php";
global $conn;

// Create connection
//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if ($conn == false) {
  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}

// following query needs playername
$sql="select x.playername, x.reserveprice,ifnull(t.currenthighestbid,x.reserveprice)currenthighestbid, t.ownerteam from leagueauctionresults t, playermst x where t.playername = x.playername and ifnull(t.leaguename,'X')='$leaguename' AND x.playername='$playername'";
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
//echo $sql2."</br>";
$result = mysqli_query($conn,$sql2) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$virtualpurchasepower=$row[0];
	$currentbidamount=$row[1];
	$numberofplayers=$row[2];
}
mysqli_free_result($result);

//echo $virtualpurchasepower ."</br>";
//echo "values are " . $playername . " " .$reserveprice . " " . $currenthighestbid . " " . $virtualpurchasepower . " " . $numberofplayers . " </br>" ;


//$SqlUpdt = "UPDATE leagueteamsdetails SET Currentbidamount= nvl(Currentbidamount,0)+ '$_POST('urBId')' , virtualpurchasepower= virtualpurchasepower- '$_POST('urBId')' , numberofplayers = numberofplayers+1 WHERE leaguename = '$leaguename' and teamname='$teamname' "


//echo '<script type="text/javascript">
  //         window.location = "./PlayersListForBidding.php?imsg=Records added"
  //    </script>';

?>
<!-- make sure the php file that calls addurbid , sets the above session vars -->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Submit Bid</title>
<link href="NewUI/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" type="text/css" href="NewUI/css/table-style.css" />
<link rel="stylesheet" type="text/css" href="NewUI/css/basictable.css" />
<link href="NewUI/css/component.css" rel="stylesheet" type="text/css" media="all" />
<link href="NewUI/css/style_grid.css" rel="stylesheet" type="text/css" media="all" />
<link href="NewUI/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- font-awesome-icons -->
<link href="NewUI/css/font-awesome.css" rel="stylesheet">
</head>
<body>
<br/><br/><br/><br/>

<form name="frmadd" action="PlayersListForBidding.php" method="post" onSubmit="return valid();">
  <div class="agile-tables">
    <div class="w3l-table-info agile_info_shadow">
      <h3 class="w3_inner_tittle two">

  <table id="table " >
    <!--border="1" cellpadding="2" class="text" cellspacing="2" width="60%" align="center" bordercolordark="#FFFFFF" bordercolorlight="#CCCCCC"> -->
		<TR>
			<td colspan="2" align="center" bgcolor="#FFFFCC" ><h3>Add Your Bid</h3></td>
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
			<TD align="right"><b>Your Bid :</b></TD>
			<TD><input type="text" name="urBId" value="">should be atleast >500 than current bid</TD>
		</TR>
		<TR>
			<td colspan="2" align="center" bgcolor="#FFFFCC"> <input type="submit" name="add" value="Add"  >
			</td>
		</TR>
		<tr><td><input type="hidden" name='virtualPP' value="<? echo $virtualpurchasepower ;?>" > </td>
		<td><input type="hidden" name='currentbidtotal' value="<? echo $currentbidamount ; ?>" > </td>
		<td><input type="hidden" name='numberofplayers' value="<? echo $numberofplayers ; ?>" > </td> </tr>
	</table>
</div>
</div>
  <button type="button" class="btn btn-xs btn-success " onClick="Javascript:window.location.href = 'PlayersListForBidding.php';" >Bidding</button>

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
		 alert("Please enter bid value.");
		 document.frmadd.urBId.focus();
		 return false;
		}

		if ( parseInt(document.frmadd.urBId.value) <= parseInt(document.frmadd.CurrentbID.value)+500)
		{
			alert ("Bid value must be greater then current Bid value + 500");
			document.frmadd.urBId.focus();
			return false;
		}

		alert (" ur purchase power is" + parseInt(document.frmadd.virtualPP.value));
		alert (" ur bid amt is " +parseInt(document.frmadd.urBId.value));

		if ((parseInt(document.frmadd.virtualPP.value) - parseInt(document.frmadd.urBId.value)) <=10000 )
		{
			alert ("your Purchase power is in danger zone, you can not bid this much");
			document.frmadd.urBId.focus();
			return false;
			}
		else {
			alert ("Your bid is accepted; Pl keep checking to see if you have been outbid; Pl note: Remaining purchase power is "+
				(parseInt(document.frmadd.virtualPP.value)-parseInt(document.frmadd.urBId.value))
				);

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
