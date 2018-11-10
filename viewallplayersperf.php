<?
session_start();
$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$pass=$_SESSION['pass'];
$teamname=$_SESSION['teamname'];

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
$i=0;
  $sql1="select pid, playername,iplteam,score,numberof4,numberof6,numberofcatches,numberofrunouts,manofthematch,
  wickets,points,speciality from playermst order by score desc, overs desc";
  //echo $sql1."</br>";
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

  $i++;
  }
  mysqli_free_result($result);
$playercount=$i;
//echo $playercount ;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>All IPL Players Performance Details</title>
</head>
<body leftmargin="0" topmargin="0" ><br/><br/>
<table>
  <tr>
  <td width="40%" align="center" class="text"><a href="teamLandingPg.php"><b>Main Team Page</b></a>
  </td>
  </tr>
</table>
<table width="950" border="1" cellspacing="2" cellpadding="0" align="Center" bgcolor="#FFFFFF">
  <tr >
    <td colspan="13" align="center" bgcolor="#CCCFFF" ><strong>  All IPL Players Performance  </strong></td>
  </tr>
  <tr>
    <td> SrNo</td>
    <td>PlayerName</td>
    <td>Speciality</td>
    <td>Plays for</td>
    <td>Total Runs</td>
    <td>Total 4s</td>
    <td>Total 6s</td>
    <td>Total Wickets</td>
    <td>Total Catches</td>
    <td>Total Runouts</td>
    <td>Total manofthematch</td>
  </tr>
  <?
  for ($i=0 ; $i<$playercount ; $i++) {
    $srno=$i+1;
  ?>
  <tr>
    <td> <? echo $srno ; ?></td>
    <td><? echo $PM_playername[$i]; ?></td>
    <td><? echo $PM_speciality[$i]; ?></td>
    <td><? echo $PM_iplteam[$i]; ?></td>
    <td align="center" ><? echo $PM_score[$i]; ?></td>
    <td align="center"><? echo $PM_numberof4[$i]; ?></td>
    <td align="center"><? echo $PM_numberof6[$i]; ?></td>
    <td align="center"><? echo $PM_wickets[$i]; ?></td>
    <td align="center"><? echo $PM_numberofcatches[$i]; ?></td>
    <td align="center"><? echo $PM_umberofrunouts[$i]; ?></td>
      <td align="center"><? echo $PM_manofthematch[$i]; ?></td>
    </tr>
<? } ?>
</table>
</body>
</html>
