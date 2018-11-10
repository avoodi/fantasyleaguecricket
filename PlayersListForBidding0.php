<html>
<head>
<?
  session_start();
    $username=$_SESSION['username'];
    $team=$_SESSION['teamname'];
    $teamowner = $_SESSION['username'];
    $leaguename= $_SESSION['leaguename'];

echo "all session " . $username . " and team " . $team . " and owner " . $teamowner . " and league ". $leaguename . "<br/>";
    $serverName = "sg1-wsq1.a2hosting.com";
    $connectionInfo = array( "Database"=>"fantas10_mssql", "UID"=>"fantas10_avad", "PWD"=>"FLeague@2018");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
//is null for virtual purchase power is to be removed
    $sql1="select isnull(t.virtualpurchasepower,0), isnull(t.currentbidamount,0) currentbidamount , t.numberofplayers from leagueteamsdetails T where t.teamname= '$team' and t.leaguename='$leaguename' ";
echo $sql1 . "<br/>";
  $result = sqlsrv_query($conn,$sql1) ;
  while( $row = sqlsrv_fetch_array( $result ) )
  {
    $virtualpurchasepower=$row[0];
    $currentbidamount=$row[1];
    $numberofplayers=$row[2];
  }
  sqlsrv_free_stmt($result);

    $sql2 = "select biddingstatus from leaguerules  where leaguename='$leaguename'";
    $result = sqlsrv_query($conn,$sql2) ;
    while( $row = sqlsrv_fetch_array( $result ) )
    {
      $biddingstatus=$row[0];
    }
    sqlsrv_free_stmt($result);

?>
<style>
/* Sortable tables */
table.sortable thead {
    FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #333333; FONT-FAMILY: "Trebuchet MS"
}
</style>
<!--SCRIPT LANGUAGE="JAVASCRIPT" SRC="images/sorttable.js"></SCRIPT -->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>: Cricket : </title>

</head>
<body leftmargin="0" topmargin="0" style="background-repeat: repeat-x;" bgcolor="#F1F1F1" ><br/><br/>
<table width="950" border="0" cellspacing="0" cellpadding="0" align="Center" bgcolor="#FFFFFF">
	<tr>
		<td >
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="Center">
				<tr>
					<td align="left" height="130">
					<span style="font-size: 15pt;color:#FFFFFF">Welcome to the </span>
          <b><font size="5" color="#FFFFFF"> Fantasy</font></b>
					Cricket league </td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<? 	if ($biddingstatus =="Closed") {?>
		<h3 > Bidding IS OVER For This League , Pl check your players page. For AUTO ALLOCATION oF REMAINING PLAyERs Contact League Creator...</h3>
<? } ;?>
<?	if ($biddingstatus=="Yet To Start") { ?>
		<H3> Bidding for your league is not activated yet.. pl contact league Creator..  </h3>
<? } ;?>
<? if ($biddingstatus=="Started-InProgress") { ?>
	    <H2>Happy Bidding </H2>
<? } ;?>

<table width="950" border="0" class="text" cellspacing="0" cellpadding="0" align="Center">
		<tr>
		<td height="30" align="center" class="text" ></td>
		<td  align="center" class="text"></td>
	</tr>

	<tr>
		<!-- <td width="40%" align="center" class="text"><a href="teamplayerdetails.asp"><b>Team Players Information</b></a></td> -->
		<td width="40%" align="center" class="text"><a href="teamLandingPg.php"><b>Main Team Page</b></a></td>
	</tr>
	<tr>
		<td height="30" align="center" class="text" ></td>
		<td  align="center" class="text"></td>
	</tr>
</table>
<!-- nneed to show league name , team name in same tablea as purchase power -->
	<table width="950" border="0" align="center">
    <tr>
    		<td width="353">
				<table  width="347" border="1" align="center" bordercolor="#00FFFF" bgcolor="#CCFF00" class="pagenav" >
				  <tr>
					       <td width="218"><h4 align="center">Virtual Purchase Power :</h4></td>
					       <td width="128"><div align="right"><font face="Tahoma, Geneva, sans-serif" size="2"><? echo $virtualpurchasepower ?> </div></td>
				  </tr>
				  <tr>
					       <td><h4 align="center">Current Bid Amount Total :</h4></td>
					       <td><div align="right"><font face="Tahoma, Geneva, sans-serif" size="2"><? echo $currentbidamount ?> </div></td>
				  </tr>
			</table>
		</td>
	  </tr>
	</table>

<table border="1" width="65%" ALIGN="center" class="header3" cellspacing="1" cellpadding="1" bordercolor="#FFFFCC">
<form name="frmcricket" action="PlayersListForBidding.php" method="post">
	<tr height="20" class="header4" bgcolor="#FFFFCC">
		<td align="center" class="Header1">Sr.No</td>
		<td class="Header1">Player Name</td>
		<td class="Header1">Speciality</td>
		<td class="Header1">IPL Team</td>
		<td align="center" >Reserve  Price</td>
		<td align="center" >Current higest Bid</td>
		<td class="Header1">Highest Bidder </td>
		<td class="Header1">Your bid</td>
	</tr>

<!-- entire while loop to show all rows -->

<?

$i=1;
$sql="select x.playername,x.iplteam,x.speciality, x.reserveprice,isnull(t.currenthighestbid,x.reserveprice)currenthighestbid, t.ownerteam from LEAGUEAUCTIONRESULTS T, PLAYERMST X where t.playername = x.playername and (isnull(t.leaguename,'X')='$leaguename'  or t.leaguename is null)  and isnull(t.bidsoldyn,'N')='N' ";
echo $sql . "<br/>";
$result = sqlsrv_query($conn,$sql) ;
while( $row = sqlsrv_fetch_array( $result ) )
{
echo "Values are " . $row[0] ." and ". $row[1]." and ". $row[2]." and ". $row[3]." and ". $row[4]." and ". $row[5] . "<br\>";
}
?>


<input type="hidden" name='numberofplayers' value="<? echo $numberofplayers ?>" >
<input type="hidden" name='nm' value="" >
</form>
</table>
<table width="950" align="center">
<tr>
		<td >
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="Center">
				<tr>
					<td align="left" height="30"></td>
				</tr>
			</table>
		</td>
	</tr>
		<tr><td align="Right" class="text">&copy 2011 All Rights Reserved.</td></tr>
</table>
</body>
</html>
<script language="javascript">
function valid(id)
	{

		if(parseInt(document.frmcricket.numberofplayers.value) >=15 )
		{
			 alert("Sorry you already have enough players in your rooster, you may not bid more at this time.");
			 //document.frmcricket.currbid.focus();
			 return false;
		}
		else
		{
			//alert(id);
		window.document.frmcricket.target = "_self";
		window.document.frmcricket.action = 'addurbid.php';
		document.all("nm").value	= id;
		window.document.frmcricket.submit();
		}
	}
/* function chkval(id)
	{
	 var i
	 for(i=0; i<document.frmcricket.elements.length;i++)
	 {
		alert(document.frmcricket.elements[0].value);
	 }

	if((document.frmcricket.urbid[id].value) <= (document.frmcricket.currbid[id].value)) ;
		{
			 alert('HI');
		}
	} */
</script>
