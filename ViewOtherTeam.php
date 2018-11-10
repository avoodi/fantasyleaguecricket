<?

session_start();
$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$pass=$_SESSION['pass'];
$teamname=$_SESSION['teamname'];
$otherteam=$_GET['nm'];

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

$playercount=0;
$sql="select pid, playername from leagueauctionresults where leaguename='$leaguename' and ownerteam='$otherteam' ";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $pid[$playercount]=$row[0];
  $playername[$playercount]=$row[1];

  $playercount++;
}
mysqli_free_result($result);
//for the above players get details from playermst

for ($i=0 ; $i<$playercount ; $i++){

  $sql1="select pid, playername,iplteam,score,numberof4,numberof6,numberofcatches,numberofrunouts,manofthematch,
  wickets,points,speciality from playermst where pid=$pid[$i] ";
  $result = mysqli_query($conn,$sql1) ;
  while( $row = mysqli_fetch_array( $result ) )
  {
  $PM_pid[$i]=$row[0];
  $PM_playername[$i]=$row[1];
  $PM_iplteam[$i]=$row[2];
  $PM_score[$i]=$row[3];
  $PM_numberof4[$i]=$row[4];
  $PM_numberof6[$i]=$row[5];
  $PM_numberofcatches[$i]=$row[6];
  $PM_umberofrunouts[$i]=$row[7];
  $PM_manofthematch[$i]=$row[8];
  $PM_wickets[$i]=$row[9];
  $PM_points[$i]=$row[10];
  $PM_speciality[$i]=$row[11];

  }
  mysqli_free_result($result);
}
mysqli_free_result($result);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Team Details</title>
</head>
<body leftmargin="0" topmargin="0" ><br/><br/>
<table>
  <tr>
  <td width="40%" align="center" class="text"><a href="teamLandingPg.php"><b>Main Team Page</b></a></td>
  </tr>
</table>
<table width="950" border="1" cellspacing="2" cellpadding="0" align="Center" bgcolor="#FFFFFF">
  <tr >
    <td colspan="13" align="center" bgcolor="#CCCFFF" ><strong> Teams Members of <?echo $otherteam; ?> </strong></td>
  </tr>
  <tr>
    <td> SrNo</td>
    <td>PlayerName</td>
    <td>Speciality</td>
    <td>Plays for</td>
    <td>Total Points</td>
    <td>Total Runs</td>
    <td>Total 4s</td>
    <td>Total 6s</td>
    <td>Total Wickets</td>
    <td>Total Catches</td>
    <td>Total Runouts</td>
  </tr>
  <?
  for ($i=0 ; $i<$playercount ; $i++) {
  ?>
  <tr>
    <td> <? echo $i+1 ; ?></td>
    <td><? echo $playername[$i]; ?></td>
    <td><?echo $PM_speciality[$i]; ?></td>
    <td><?echo $PM_iplteam[$i]; ?></td>
    <td><? echo $PM_points[$i]; ?></td>
    <td><? echo $PM_score[$i]; ?></td>
    <td><? echo $PM_numberof4[$i]; ?></td>
    <td><? echo $PM_numberof6[$i]; ?></td>
    <td><? echo $PM_wickets[$i]; ?></td>
    <td><? echo $PM_numberofcatches[$i]; ?></td>
    <td><? echo $PM_umberofrunouts[$i]; ?></td>
  </tr>
<? } ?>
</table>
</body>
</html>
