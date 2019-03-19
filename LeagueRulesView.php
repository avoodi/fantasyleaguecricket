<?
session_start();
$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$pass=$_SESSION['pass'];
$teamname=$_SESSION['teamname'];
$teamownername=$_SESSION['teamownername'];

//echo "ownername is ".$teamownername;

include "dbConnect.php";
global $conn;

	// Create connection
	//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
	// Check connection
	if ($conn == false) {
	  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
	}

$isOwner='No';
//find out if the user is leaguecreator
$sql="select leaguecreatorname from league_mst where leaguename='$leaguename'";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$isOwner=$row[0];
}
//echo "league is " .$leaguename. " and teamowner is ". $isOwner;

//if ($isOwner == $teamownername)
//{
//	echo "yes it matches ";

//}

$sql="select MAXTEAMS,BIDSTARTDATE,BIDENDDATE,MAXTRADES,RUNPOINTS,CATCHPOINTS, WICKETPOINTS, RUNOUTPOINTS,MAIDENOVERPOINTS, BOUNDRYPOINTS,SIXERPOINTS,PURCHASEPOWER,BIDDINGSTATUS,FiveWicketInMatch,Hatrik from LeagueRules where leaguename='$leaguename'";
//echo "before " .$MAXTEAMS ;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$MAXTEAMS= $row['MAXTEAMS'];
	$BIDSTARTDATE= $row['BIDSTARTDATE'];
	$BIDENDDATE= $row['BIDENDDATE'];
	$MAXTRADES= $row['MAXTRADES'];
	$RUNPOINTS= $row['RUNPOINTS'];
	$CATCHPOINTS= $row['CATCHPOINTS'];
	$WICKETPOINTS= $row['WICKETPOINTS'];
	$RUNOUTPOINTS= $row['RUNOUTPOINTS'];
	$MAIDENOVERPOINTS= $row['MAIDENOVERPOINTS'];
	$BOUNDRYPOINTS= $row['BOUNDRYPOINTS'];
	$SIXERPOINTS= $row['SIXERPOINTS'];
	$PURCHASEPOWER= $row['PURCHASEPOWER'];
	$BIDDINGSTATUS =$row['BIDDINGSTATUS'];
	$FiveWicketInMatch=$row['FiveWicketInMatch'];
	$Hatrik=$row['Hatrik'];
}
mysqli_free_result($result);

	/* we need to insert code here to update leaguemst if any changes to the values in the form */
?>
<html>

<head>
<title>Welcome</title>
</head>

<body leftmargin="0" topmargin="0" ><br/><br/>
	<table>
  <tr>
  <td width="40%" align="center" class="text"><a href="teamLandingPg.php"><b>Main Team Page</b></a></td>
  </tr>
</table>

<table width="950" border="0" cellspacing="0" cellpadding="0" align="Center" bgcolor="#FFFFFF">
	<tr>
		<td >
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="Center">
				<tr>
					<td align="left" height="130">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table width="950" border="0" cellspacing="0" cellpadding="0" align="Center" bgcolor="#FFFFFF">
	<tr>
		<td>

		<p align="center"><b><font size="5">League name is : <? echo $leaguename?></font></b></p>
		<table border="2" width="85%" id="table2" ALIGN="center" class="header3" cellspacing="1" cellpadding="2" bordercolor="#F1F1F1">
			<tr>
				<td colspan="2" bgcolor="#FFFFCC" class="text1" height="30">
					<? if ($isOwner == $teamownername) { ?>
						<b>Welcome : As a league creator , you will be able to edit any rules ; be careful :) </b>
					<? } ?>
				 <? if ($isOwner !== $teamownername) { ?>
				<b>Welcome : These are the rules for your league ; You are Not the league creator so you will not be able to edit them</b>
			<? } ?>
				</td>
			</tr>
			<tr>
				<td width="50%" align="Right">How many Teams should be in the league :</td>
				<td width="40%"><input type="text" name="T12" size="20" value="<? echo $MAXTEAMS?>"></td>
			</tr>
			<tr>
				<td width="50%" align="Right">Trades allowed per team :</td>
				<td width="46%"><input type="text" name="T9" size="20" value="<? echo $MAXTRADES?>"></td>
			</tr>
			<tr>
				<td width="50%" align="Right">Purchase Power Per Team :</td>
				<td width="46%"><input type="text" name="T13" size="20" value="<? echo $PURCHASEPOWER?>"></td>
			</tr>
			<tr>
				<td colspan="2" bgcolor="#FFFFCC">
				<p align="left"><b>Rules for Points calculations</b></td>
			</tr>
			<tr>
				<td width="50%" align="Right">Points per Run :</td>
				<td width="46%"><input type="text" name="T1" size="20" value="<? echo $RUNPOINTS?>"></td>
			</tr>
			<tr>
				<td width="50%" align="Right">Points per Wicket :</td>
				<td width="46%"><input type="text" name="T2" size="20" value="<? echo $WICKETPOINTS?>"></td>
			</tr>
			<tr>
				<td width="50%" align="Right">Extra Points Per Boundry (4's) :</td>
				<td width="46%"><input type="text" name="T3" size="20" value="<? echo $BOUNDRYPOINTS?>"></td>
			</tr>
			<tr>
				<td width="50%" align="Right">Extra Points Per Sixer (6's) :</td>
				<td width="46%"><input type="text" name="T4" size="20" value="<? echo $SIXERPOINTS?>"></td>
			</tr>
			<tr>
				<td width="50%" align="Right">Points per Catch :</td>
				<td width="46%"><input type="text" name="T5" size="20" value="<? echo $CATCHPOINTS?>"></td>
			</tr>
			<tr>
				<td width="50%" align="Right">Points per Runout / Stump Out :</td>
				<td width="46%"><input type="text" name="T6" size="20" value="<? echo $RUNOUTPOINTS?>"></td>
			</tr>
			<tr>
				<td width="50%" align="Right">Points per Maiden Over :</td>
				<td width="46%"><input type="text" name="T7" size="20" value="<? echo $MAIDENOVERPOINTS?>"></td>
			</tr>
			<tr>
			<td width="50%" align="right">Points per 5 Wicket(in a match)</td>
			<td width="26%"><input type="text" name="T14" size="20" value="<? echo $FiveWicketInMatch?>"></td>
		</tr>
        <tr>
			<td width="50%" align="right">Points per Hatrik</td>
			<td width="26%"><input type="text" name="T15" size="20" value="<? echo $Hatrik?>"></td>
		</tr>
			<tr>
				<td width="50%" align="Right"><strong>Current Bidding Status :<? echo $BIDDINGSTATUS ?> </strong>To change, use the dropdown</td>
				<td width="46%"><select size="1" name="D1" >
					<option >Yet To Start</option>
				 <option >Started-InProgress</option>
				 <option >Closed</option>
				</select>
			</td>
			</tr>
            <tr>
				<td colspan="2">Please note: "Selected" Captain in your team will always get double points :)

				</td>
            </tr>
		</table>
	</td>
</tr>
</table>
		<br/>
		<table width="100%">
				<tr>
					<td >
						<table width="98%" border="0" cellspacing="0" cellpadding="0" align="Center">
							<tr>
								<td align="left" height="30"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

</body>

</html>
