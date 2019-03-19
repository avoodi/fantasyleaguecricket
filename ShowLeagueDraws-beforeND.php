
<?
session_start();
	$username=$_SESSION['username'];
	$teamname=$_SESSION['teamname'];
	$teamowner = $_SESSION['username'];
	$leaguename= $_SESSION['leaguename'];
  $iplday=$_SESSION['iplday'];

	include "dbConnect.php";
	global $conn;

	// Create connection
	//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
	// Check connection
	if ($conn == false) {
	  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
	}

	$i=0;
	$sql = "select *  from leaguedraw where leaguename='$leaguename'  " ;
//echo $sql . " </br>" ;
	$result = mysqli_query($conn,$sql) ;
	while( $row = mysqli_fetch_array( $result ) )
	{
		$iplmatchnum[$i]=$row[1];
		$ourmatchnum[$i]=$row[2];
		$team1name[$i]=$row[3];
		$team2name[$i]=$row[4];
		$matchdate[$i]=$row[5];
		$score[$i]=$row[7];
		$whowon[$i]=$row[8];
		$actualiplmatch[$i]=$row[9];
		$prediction[$i]=$row[10];
		$team1vote[$i]=$row[11];
		$team2vote[$i]=$row[12];
		$i++;
	}
	mysqli_free_result($result);
	$leaguedrawrows=$i;
	$i=0;
	$sql="select iplday, matchstr from iplschedule where iplday>=$iplmatchnum[0]";
	$result = mysqli_query($conn,$sql) ;
	while( $row = mysqli_fetch_array( $result ) )
	{
		$iplmatchstr[$row[0]]=$row[1];
		$i++;
	}
	mysqli_free_result($result);

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>LEAGUE TEAMS DETAILS</title>
</head>
<body >
<table width="950" align="center">
<tr>
	<td width="40%"><a href="teamLandingPg.php"><b>Main Team Page</b></a></td>
</tr>
</table>

<table border="0" cellpadding="0" class="text" cellspacing="0" width="50%" align="center" bordercolordark="#FFFFFF" bordercolorlight="#FFFFCC">
	<tr>
		<td align="center" colspan="2" valign="top" bgcolor="#CCCCCC"><h3>Match Schedule for League <? echo $leaguename; ?></h3></td>
	</tr>
</table>
 <table border="1" cellpadding="0" cellspacing="0" width="66%"  align="center" bgcolor="#FFFFCC" bordercolordark="#CCCCCC" bordercolorlight="#FFFFCC">
	<tr bgcolor="#339999">
		<!--<th align="center">Match#</th> -->
		<th align="center">OurLeagueMatch#</th>
		<th align="center">Team1</th>
		<th align="center">Team2</th>
		<!--<th align="center">Date</th> -->
		<th align="center">Score</th>
		<th align="center">Winner</th>
				<th align="center">Matchup</th>
		<!--<th align="center">Prediction</th> -->
		<th align="center">IPL Matchup</th>

	</tr>
	<?
//	echo "rows are ". $leaguedrawrows ."</br>";
	for ($count=0; $count<=$leaguedrawrows ; $count++) {
//  echo "values are " . $iplmatchnum[$j] . " " .	$ourmatchnum[$j] . " " . $team1name[$j] . " ".	$team2name[$j] . " ". 	$matchdate[$j] . " ". $score[$j] . "</br> ";
//	echo "and also " . $whowon[$j] . " " . $actualiplmatch[$j] ." " . $prediction[$j] . " " . $team1vote[$j] . " " . $team2vote[$j] . "</br>";
?>
<tr bordercolor="#993300">
	 <!--<td align="center"><? echo $iplmatchnum[$count] ;?></td> -->
		<td align="center"><? echo $ourmatchnum[$count] ; ?></td>
		<? if ($team1name[$count] == $teamname) { ?>
		 <td align="center"> <a href="SelectYourTeam.php?mnum=<? echo $iplmatchnum[$count] ; ?>"><strong><? echo $team1name[$count]; ?></strong></a> </td>
		<td align="center"> <a href="ViewOtherTeam.php?nm=<? echo $team2name[$count] ?>&mnum=view"><? echo $team2name[$count] ;?></a> </td>
	<? } ?>
	<? if ($team2name[$count] == $teamname) { ?>
		<td align="center"> <a href="ViewOtherTeam.php?nm=<? echo $team1name[$count] ?>&mnum=view"><? echo $team1name[$count] ;?></a> </td>
	 <td align="center"> <a href="SelectYourTeam.php?mnum=<? echo $iplmatchnum[$count] ; ?>"><strong><? echo $team2name[$count]; ?></strong></a> </td>
 <? } ?>
 <? if ( ($team2name[$count] !== $teamname) && ($team1name[$count] !== $teamname)) { ?>
	 <td align="center"> <a href="ViewOtherTeam.php?nm=<? echo $team1name[$count] ?>&mnum=view"><? echo $team1name[$count] ;?></a> </td>
 <td align="center"> <a href="ViewOtherTeam.php?nm=<? echo $team2name[$count] ?>&mnum=view"><? echo $team2name[$count] ;?></a> </td>
<? } ?>

		<!--<td align="right"><? echo $matchdate[$count] ; ?></td> -->
		<td align="center">&nbsp;<? echo $score[$count] ; ?></td>
		<td align="center" bgcolor="#FFCC66"><strong><? echo $whowon[$count] ; ?></strong></td>
		<td align="center" bgcolor="#FFCC66">
	<!--a href="viewmatchup.php?t1=<? echo $team1name[$count] ?>&t2=<? echo $team2name[$count] ?>&t3=<<? echo $ourmatchnum[$count] ?>">
			  <strong>ViewMatchup</strong></a-->
				<!--<td align="center">&nbsp;<? echo $prediction[$count] ;?></td> -->
				<td align="center" bgcolor="#FFCC66"><?echo $iplmatchstr[$iplmatchnum[$count]] ;?></td>


   </tr>
<?
	}	?>


</table>

</body>
</html>
