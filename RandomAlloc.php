<?
// this prog will randomly allocate players
// the bidding needs to set to close while doing this
session_start();
$leaguename=$_SESSION['leaguename'];
echo "in here" .$leaguename ;

include "dbConnect.php";
global $conn;

$sql1="select teamname,virtualpurchasepower,numberofplayers from leagueteamsdetails where leaguename='$leaguename' and virtualpurchasepower >25000 and ifnull(numberofplayers,0)<22 ";


$sql2="SELECT leaguename, playername, currenthighestbid, ownerteam, bidsoldyn, inplaying11, ccaptainyn, pid from leagueauctionresults where leaguename='$leaguename' and ownerteam is null";
echo $sql2;
// Create connection
//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if ($conn == false) {
	echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}

$availplayers=0;
$result = mysqli_query($conn,$sql2) ;
$myrandomarray=[];
echo "in here" ;

while( $row = mysqli_fetch_array( $result ) )
{
//echo "in here" ;

	//$myrandomtemp=mt_rand(1,250);  //assuming #of players in tournament dont exceed 250!
	//echo $myrandomtemp;
// if ( ! in_array($myrandomtemp, $myrandomarray) ){
     $myrandomarray[$availplayers]=$myrandomtemp;
 	 //$sql3="INSERT INTO leaguerandomalloc (leaguename, playername, reserveprice, currenthighestbid, ownerteam, bidsoldyn, speciality, actualteam, randomnumber,pid)  VALUES('$leaguename', '$row[1]', 0, 0, '', '', '', '', $myrandomarray[$availplayers],$row[7]) ";
	// echo $sql3;
	 // if(! mysqli_query($conn,$sql3) )
    //{
    //  die('error sqlins');
    //}
    $randomplayerarray[$availplayers]=$row[1];
    $randompidarray[$availplayers]=$row[7];
    $randomplaycost[$availplayers]=$row[2];
    $randomplayergone[$availplayers]='N';
  $availplayers++;
  //}

}

mysqli_free_result($result);

$teamcount=0;
echo "</br> </br> sql1 is ". $sql1 ."</br>";
$result = mysqli_query($conn,$sql1) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $teamsarray[$teamcount]=$row[0];
  $teamvirpp[$teamcount]=$row[1];
  $teamnumberofplayer[$teamcount]=$row[2];
  $teamcount++;
}
mysqli_free_result($result);

echo "tems are ".$teamcount;

 for ($i=0; $i<$teamcount; $i++) {
/**  for ($j=0; $j<$availplayers ; $j++) {

    if (($teamvirpp[$i]+$randomplaycost[$j])>25000 && $teamnumberofplayer[$i] <22 && $randomplayergone[$j]=='N')
    {
      $sqlupdt="update leagueauctionresults set ownerteam='$teamsarray[$i]' , bidsoldyn='Y' where leaguename='$leaguename' and pid=$randompidarray[$j]";
      if(! mysqli_query($conn,$sqlupdt) )
        {
          die('error sqlupdate');
        }
      //  echo $sqlupdt . "</br>";
      $teamvirpp[$i]=$teamvirpp[$i] - $randomplaycost[$j];
      $teamnumberofplayer[$i]=$teamnumberofplayer[$i]+1;
      $randomplayergone[$j]='Y';
      $sqlupdt="";
    }
    //update leagueauctionresults
  }
	**/
	$maxPlayerInTeam=22;
	$playerCount=0;
	while ($playerCount < $maxPlayerInTeam)  {
	$random_key=array_rand($randompidarray,1);
		$random_pid=$randompidarray[$random_key];
	//	echo "random pid : ". $random_pid;
echo "available ply ".$availplayers ."<br>";
	 for ($findindex=0; $findindex<$availplayers; $findindex++) {
//    echo "find index " . $findindex ."<br>";
		if($randompidarray[$findindex]==$random_pid && $randomplayergone[$findindex]=='N') {
			echo "first if playercount" . $playerCount ;
			if(($teamvirpp[$i]+$randomplaycost[$findindex]) >25000 && $teamnumberofplayer[$i]<$maxPlayerInTeam) {
				$sqlupdt = "update leagueauctionresults set ownerteam='$teamsarray[$i]' ,bidsoldyn='Y' where leaguename='$leaguename' and pid=$randompidarray[$findindex] ";

				if(! mysqli_query($conn,$sqlupdt) ) {
					die('problem: random alloc 2');
				}
				$teamvirpp[$i] = $teamvirpp[$i] - $randomplaycost[$findindex];
				$teamnumberofplayer[$i] = $teamnumberofplayer[$i]+1;
				$randomplayergone[$findindex]='Y';
//echo "breaking now <br>";
				$sqlupdt="";
				$playerCount++;
			//	break 1;
			}
		}
	}
}

  //one team is over now update leagueteamdetails and move on to next team1
    $sqlupdt2="update leagueteamsdetails set numberofplayers=$teamnumberofplayer[$i] , virtualpurchasepower=$teamvirpp[$i] where leaguename='$leaguename' and teamname='$teamsarray[$i]'";
    if(! mysqli_query($conn,$sqlupdt2) )
      {
        die('error sqlupdate2');
      		}
    echo "leagueteamsdetails updt ".$sqlupdt2 . "</br>";
  }

  $sqlupdt3="update leaguerules set biddingstatus='Closed' where leaguename='$leaguename'";
  if(! mysqli_query($conn,$sqlupdt3) )
    {
      die('error sqlupdate3');
    }

?>
