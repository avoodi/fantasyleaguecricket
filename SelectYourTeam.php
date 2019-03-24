<?

session_start();
$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$pass=$_SESSION['pass'];
$teamname=$_SESSION['teamname'];
$iplday=$_GET['mnum'];
$ourmatchnum=$_GET['omn'];
echo "ipl day is ".$iplday . "and our mt is ".$ourmatchnum ;
include "dbConnect.php";
global $conn;

// Create connection
//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if ($conn == false) {
  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}

$playercount=0;
$sql="select pid, playername from leagueauctionresults where leaguename='$leaguename' and ownerteam='$teamname' ";
//echo $sql . "</br>";
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
wickets,points from playermst where pid=$pid[$i] ";
  //echo $sql1 ."</br>";
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

  }
  mysqli_free_result($result);
}
// get todays actual ipl matchup to display as header using $iplday
$sql="select distinct(matchstr) from iplschedule where iplday=$iplday";
//echo $sql . "</br>" ;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $todayIPLmatch=$row[0];
  //echo " in here " .$todayIPLmatch;
}
mysqli_free_result($result);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Team Details</title>
</head>
<body leftmargin="0" topmargin="0" ><br/><br/>
  <a href="teamLandingPg.php"><b>Main Team Page</b></a>
  <Form name="LAYOUTFORM" action="SaveTeamPlayer.php" method="POST">

    <h3 class="w3_inner_tittle two">
    <p> Players from IPL teams (<? echo $todayIPLmatch ;?>) have allready been preselected below ;    </p>
    <p> All you need to do is, select Captain and submit the team(important); you can change it anytime before the match. </p>

<table width="950" border="1" cellspacing="2" cellpadding="0" align="Center" bgcolor="#FFFFFF">
  <tr >
    <td colspan="14" align="center" bgcolor="#CCCFFF" ><strong> Todays IPL matchup is :<? echo $todayIPLmatch ; ?> </strong></td>

  </tr>

  <tr >
    <td colspan="12" align="center" bgcolor="#CCCFFF" ><strong> Select your team </strong></td>
  </tr>
  <tr>
    <td> SrNo</td>
    <td>PID</td>
    <td>PlayerName</td>
    <td>is captain</td>
    <!--<td>Speciality</td> -->
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
    $showcheck='No';
    if (strpos($todayIPLmatch,$PM_iplteam[$i])!== false) {
      $showcheck='Yes';
    }
  ?>
  <tr>
    <td> <? echo $i+1 ; ?></td>
    <td> <? echo $pid[$i] ; ?> </td>
    <?  if ($showcheck=='Yes'){ ?>
    <td><input type="checkbox" name="chkSelGroup[]" VALUE="<? echo $pid[$i]; ?>" checked onClick="document.LAYOUTFORM.btnSave.disabled=false;count(this);">
    <? } ; ?>
  <? if ($showcheck=='No') { ?>
<td><input type="checkbox" name="chkSelGroup[]" VALUE="<? echo $pid[$i]; ?>" unchchecked onClick="document.LAYOUTFORM.btnSave.disabled=false;count(this);">
<? }; ?>
      <? echo $playername[$i]; ?></td>
    <td><input type="radio" name="iscaptain" value="<? echo $pid[$i]; ?>">
    <!-- <td>-</td> -->
    <td><? echo $PM_iplteam[$i] ;?></td>
    <td><? echo $PM_points[$i] ;?></td>
    <td><? echo $PM_score[$i]; ?></td>
    <td><? echo $PM_numberof4[$i]; ?></td>
    <td><? echo $PM_numberof6[$i]; ?></td>
    <td><? echo $PM_wickets[$i]; ?></td>
    <td><? echo $PM_numberofcatches[$i]; ?></td>
    <td><? echo $PM_umberofrunouts[$i]; ?></td>
  </tr>
<? } ?>
<tr bgcolor="#CCCCCC" >
      <td colspan="14" align="center">
<input type="submit" align="center" name="btnSave" value="SubmitTeam" onClick="return callforsave(<? echo $i ;?>);">
<input type ="hidden" name ="iplday" value="<? echo $iplday; ?>">
<input type ="hidden" name ="ourmatchnum" value="<? echo $ourmatchnum; ?>">
</td>
</tr>
</table>
</form>
</body>
</html>
<script language="javascript">
var cnt =0;
  var iFlag =0;
  var ichkFlag =0;

	function callforsave(selcount)
	{
 //return false;
    alert("Team Saved ");
    alert("captain is "+ document.LAYOUTFORM.iscaptain.value);
		if(iFlag ==1)
		{
			alert("Max. 11 Players has to be allowed for one Match");
			return false;
		}

		document.LAYOUTFORM.specialaction.value="save";
		document.LAYOUTFORM.method = "POST";
		document.LAYOUTFORM.action = "SaveTeamPlayer.php";
		document.LAYOUTFORM.submit();
		return true;
	}

	function getCaptain(strVar)
	{
		document.LAYOUTFORM.Captain.value = strVar;
	}

	function count(str)
	{
	  var iSel = <? echo $i-1 ; ?>;


	   if(iSel ==0)
		{
		 cnt =0;
		}
		else if(iSel!=0 && ichkFlag==0)
		 {
		 cnt= iSel;
		 ichkFlag = 1;
		 }

	   if(str.checked == true)
		   cnt ++;
	   else
		  cnt--;
		if(cnt > 11)
		 {
		// alert("Max. 11 Players has to be allowed for one Match");
		 iFlag = 1;
		 return false;
		 }
		else
		{
		iFlag =0;
		}

	}
</script>
