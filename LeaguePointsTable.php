<?
// points table and other common info for league
session_start();
	$username=$_SESSION['username'];
	$teamname=$_SESSION['teamname'];
	$teamowner = $_SESSION['username'];
	$leaguename= $_SESSION['leaguename'];

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

$i=0;
$sql="select teamname, teamownername,ifnull(numberofplayers,0),ifnull(totalteamscore,0),ifnull(matcheswon,0), matcheslost,matchesdrawn, points  from leagueteamsdetails where leaguename='$leaguename'";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $tname[$i]=$row[0];
  $townername[$i]=$row[1];
  $noofplayers[$i]=$row[2];
  $totalscore[$i]=$row[3];
  $matcheswon[$i]=$row[4];
  $matcheslost[$i]=$row[5];
  $matchesdrawn[$i]=$row[6];
  $points[$i]=$row[7];
  $i++;
}
mysqli_free_result($result);
$teamsinleague=$i;

?>
<html>
<head>
</head>
<body>
<table align="center" width=80% border="1">
<tr>
<td colspan=6 bgcolor="CCFFDD"> Points/League Standing table </td>
</tr>
<tr>
  <td>Teamname</td>
  <td>TeamOwner</td>
  <td>Points</td>
  <td># of Wins</td>
  <td># of Losses </td>
  <td># of draw </td>
</tr>
<?
for ($i=0;$i<$teamsinleague ; $i++) {
?>
  <tr >
    <td style="border-bottom: 2px solid #cdd0d4"><? echo $tname[$i];?> </td>
    <td style="border-bottom: 2px solid #cdd0d4"><? echo $townername[$i];?> </td>
    <td style="border-bottom: 2px solid #cdd0d4"><? echo $points[$i];?> </td>
    <td style="border-bottom: 2px solid #cdd0d4"><? echo $matcheswon[$i];?> </td>
    <td style="border-bottom: 2px solid #cdd0d4"><? echo $matcheslost[$i];?> </td>
    <td style="border-bottom: 2px solid #cdd0d4"><? echo $matchesdrawn[$i];?> </td>
  </tr>
<?
}
?>
</table>

</body>
</html>
