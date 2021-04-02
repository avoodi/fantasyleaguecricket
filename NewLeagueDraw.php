<?

session_start();
	$username=$_SESSION['username'];
	$team=$_SESSION['teamname'];
	$teamowner = $_SESSION['username'];
	$leaguename= $_SESSION['leaguename'];
	//echo "user name is ". $_SESSION['username'] . " and pass is " . $_SESSION['pwd']. " and team name is " . $_SESSION['teamname']."and league ". $_SESSION['leaguename'] ;

	include "dbConnect.php";
	global $conn;

	// Create connection
//	$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
	// Check connection
	if ($conn == false) {
		echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
	}


$sql    = "select teamname from leagueteamsdetails where leaguename = '$leaguename' order by teamname asc";
$sql2    = "select teamname from leagueteamsdetails where leaguename = '$leaguename' order by teamname asc";

//echo $sql ."</br> ";
//echo $sql2 ."</br> ";
$i=0;

$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$i=$i+1;
	$arr1[$i]=$row[0];
}

//echo "count is ". $i ;
//foreach($arr1 as $team){
//	echo "fromarray " . $team . "</br>";
//}

mysqli_free_result( $result);

$j=1;
$result= mysqli_query($conn,$sql2);
while( $row = mysqli_fetch_array( $result ) )
{
$arr2[$j]=$row[0];
	$j=$j+1;
}

if (($i%2 )==1) {
	// add one element to both arrays
	$arr1[$i+1]='bye';
	$arr2[$i+1]='bye';
	$i++;
}
//echo "now count is ". $j;
//foreach($arr2 as $team){
//	echo "fromarray2 " . $team . "</br>";
//}
mysqli_free_result( $result);

$totalRows=$i;//i has increased one more time in the first loop hence this
$reverseCnt=$totalRows;

// how many matches this league should have; depends on when the league is starting ; find out diff in dates from 7apr (actual ipl start) to today

//$ab=date_default_timezone_get();
date_default_timezone_set('Asia/Kolkata');
$today=date("z"); //if we put draws before the tournament actual start date(testing) then we need to add that many days to this count

//echo "helo today is " . $today ;
$startofIPL = 262; // ipl starting on 19th sep of the year
$startofOurLeague = ($today-$startofIPL)+1;
$endofIPL =307; // the ipl league matches end on 3rd nov which is 125th day
$daysforOurLeague=$endofIPL-$today;
//echo "and diff is ". $startofOurLeague . "and " . $daysforOurLeague ." </br>";

//$days=14;
$iplmatchnum=$startofOurLeague;
$ourmatchnum=1;
echo "tota rows " . $totalRows . "revers is " . $reverseCnt ." </br>";

for ($cnt=1; $cnt<=$daysforOurLeague ;$cnt++ ) {
  $reverseCnt=$totalRows;
  for ($cnt2=1 ; $cnt2<=$totalRows/2; $cnt2++) {
  //       echo $arr1[$cnt2] ." vs " . $arr2[$reverseCnt] ." at " . $cnt ."</br>"  ;
				 /* very important ipmmatchnum needs to be set to the actual ipm match number when this
				 prog is going to be executed for this league ; which means the start of the number could be diff for each league */
				 $sql3= "insert into leaguedraw(leaguename, iplmatchnum, ourmatchnum, team1name, team2name)
				 				values('$leaguename',$iplmatchnum, $ourmatchnum,'$arr1[$cnt2]', '$arr2[$reverseCnt]' )" ;
					echo $sql3 ."</br>";
	/*			if(! mysqli_query($conn,$sql3) )
						{
							die('error sql3');
						}
	*/
//					$result = mysqli_query($conn,$sql3) ;
         $reverseCnt--;
				 $ourmatchnum++;
  }

	/*reshuffle array1 */
  $tmp= $arr1[1];
  $tmp2= $arr2[1];
	echo "before reshuffle ". $tmp ." and ". $tmp2 . "</br>";
  for ($reshuffle=1; $reshuffle<=$totalRows ; $reshuffle++){
    $arr1[$reshuffle] = $arr1[$reshuffle+1];
    $arr2[$reshuffle] = $arr2[$reshuffle+1];
		echo $arr1[$reshuffle] ." and ".$arr2[$reshuffle] ." </br>";
  }
  $arr1[$totalRows] =$tmp;
  $arr2[$totalRows] =$tmp2;
	echo "after reshuffle ". $arr1[$totalRows]. " and ". $arr2[$totalRows]."</br>";

echo "at the end of loop " . $reverseCnt. " and total rows is ". $totalRows. "for ipl match num " . $iplmatchnum . "our mt ". $ourmatchnum . "</br>";
	$iplmatchnum++; //important
}

/*
$sqlupdt="UPDATE leaguerules SET biddingstatus= 'Closed' WHERE leaguename = '$leaguename'  ";
if(! mysqli_query($conn,$sqlupdt) )
	{
		die('error sqlupdate');
	}

$sqlupdt="UPDATE league_mst SET drawdone= 'Y' WHERE leaguename = '$leaguename'  ";
	if(! mysqli_query($conn,$sqlupdt) )
		{
			die('error sqlupdate');
		}
*/
sqlsrv_close($conn);

?>
<html>
<head>
</head>
<body leftmargin="0" topmargin="0">
	<table width="950" border="0" cellspacing="0" cellpadding="0" align="Center" bgcolor="#FFFFFF">
	<tr>
		<td >
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="Center">
				<tr>
					<td align="left" height="130"><marquee scrollamount="03">
					<span style="font-size: 15pt;color:#FFFFFF">Welcome to the  </span><b><font size="5" color="#FFFFFF"> Fantasy</font></b><span style="font-size: 15pt;color:#FFFFFF;">
					Cricket league </span></marquee></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
	 echo '<script type="text/javascript">
          window.location = "./teamLandingPg.php"
	      </script>';
</body>
</html>
