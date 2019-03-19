<?

session_start();
$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$teamname=$_SESSION['teamname'];
$iplday=$_SESSION['iplday'];

include "dbConnect.php";
global $conn;

//$serverName = "sg1-wsq1.a2hosting.com";
//$connectionInfo = array( "Database"=>"fantas10_mssql", "UID"=>"fantas10_avad", "PWD"=>"FLeague@2018");
//$conn = sqlsrv_connect( $serverName, $connectionInfo);

$selectedcount=0;

$sql2 = "select biddingstatus from leaguerules  where leaguename='$leaguename'";
$result = mysqli_query($conn,$sql2) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $biddingstatus=$row[0];
}
mysqli_free_result($result);

$action=$_POST['specialaction'];
if(!empty($_POST)) {
   if(count($_POST['chkSelGroup']) > 0 && !empty($_POST['chkSelGroup'][0])) {
       foreach($_POST['chkSelGroup'] as $key => $checked) {
          $id = $_POST['chkSelGroup'][$key];
        //  echo "id is ".$id." and key ".$key ."</br>";
          $pid[$selectedcount]=$id;
          $selectedcount++;
          // rest of the data and processings
       }
   }
   $costofsoldplayers=0;
   if ( $selectedcount >0) {
     //we need to adjust/increase the virtualpp and reduce the count ofplayers for this teams, set owner team to null bidsoldynto 'N' and also mark currenthighestbid to reserve Price
     for ($i=0; $i<$selectedcount ; $i++) {
        $sql="select currenthighestbid from leagueauctionresults where leaguename='$leaguename' and pid=$pid[$i]";
        $result = mysqli_query($conn,$sql) ;
        while( $row = mysqli_fetch_array( $result ) )
        {
          $costofsoldplayers=$costofsoldplayers+$row[0];
        }
        mysqli_free_result($result);
     }
     $sqlupdt="update leagueteamsdetails set numberofplayers=numberofplayers-$selectedcount , virtualpurchasepower=virtualpurchasepower+$costofsoldplayers where leaguename='$leaguename' and teamname='$teamname' ";
     //echo $sqlupdt;
     if(! mysqli_query($conn,$sqlupdt) )
       {
         die('error sqlupdt');
       }
      for ($i=0; $i<$selectedcount ; $i++) {
          $sqlupdt="update leagueauctionresults set bidsoldyn='N' , ownerteam = null where leaguename='$leaguename' and pid=$pid[$i]";

          if(! mysqli_query($conn,$sqlupdt) )
            {
              die('error sqlupdt 2');
            }
          $sqldel="delete from selectedplayers where leaguename='$leaguename' and pid=$pid[$i] and iplday>$iplday" ;
          if(! mysqli_query($conn,$sqldel) )
            {
              die('error sqldel');
            }
        }
   }
}

$playercount=0;
$sql="select pid, playername,currenthighestbid from leagueauctionresults where leaguename='$leaguename' and ownerteam='$teamname' ";
//echo $sql . "</br>";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $pid[$playercount]=$row[0];
  $playername[$playercount]=$row[1];
  $costofplayer[$playercount]=$row[2];

  $playercount++;
}
mysqli_free_result($result);
//for the above players get details from playermst

for ($i=0 ; $i<$playercount ; $i++){

  $sql1="select pid, playername,iplteam,score,numberof4,numberof6,numberofcatches,numberofrunouts,manofthematch,
wickets,points,speciality from playermst where pid=$pid[$i] ";
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
  $PM_speciality[$i]=$row[11];

  }
  mysqli_free_result($result);
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Team Details</title>
</head>
<body leftmargin="0" topmargin="0" ><br/><br/>
  <a href="teamLandingPg.php"><b>Main Team Page</b></a>
  <Form name="LAYOUTFORM" action="Sellplayer.php" method="POST">

<table width="950" border="1" cellspacing="2" cellpadding="0" align="Center" bgcolor="#FFFFFF">
  <tr >
    <td colspan="14" align="center" bgcolor="#CCCFFF" ><strong> Select the player you want to get rid off :<? echo $todayIPLmatch ; ?> </strong></td>

  </tr>

  <tr>
    <td> SrNo</td>
    <td>PID</td>
    <td>PlayerName</td>
    <td>Speciality</td>
    <td>You Paid</td>
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
    <td> <? echo $pid[$i] ; ?> </td>
    <td><input type="checkbox" name="chkSelGroup[]" VALUE="<? echo $pid[$i]; ?>" un-checked onClick="document.LAYOUTFORM.btnSave.disabled=false;count(this);">
      <? echo $playername[$i]; ?></td>
      <td> <? echo $PM_speciality[$i]; ?></td>
      <td> <? echo $costofplayer[$i]; ?></td>
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
<? if ($biddingstatus=="Closed") { ?>
  <tr bgcolor="#CCCCCC" >
      <td colspan="14" align="center">
            <input type="submit" align="center" name="btnSave" value="SubmitTeam" onClick="return callforsell(<? echo $i ;?>);">
</td>
</tr>
<tr>
    <td colspan="14" align="center">Simply select the players you want to sell</td>
</tr>
<? } ?>
<? if ($biddingstatus!=="Closed") { ?>
  <tr > <td colspan="14" ><strong>This page can be used only after Bidding is Complete </strong></td></tr>
<? } ?>

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
    alert("in here ");
		if(iFlag ==1)
		{
			alert("Max. 11 Players has to be allowed for one Match");
			return false;
		}
    alert("ok you have sold one of your players");
		document.LAYOUTFORM.specialaction.value="sell";
		document.LAYOUTFORM.method = "POST";
		document.LAYOUTFORM.action = "Sellplayer.php";
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
