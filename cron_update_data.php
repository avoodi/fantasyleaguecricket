<?php
require_once "updatePlayerMatchDetails.php";
include "dbConnect.php";
global $conn;
/**
$matches_url="http://cricapi.com/api/matches?&apikey=wEjKd5SIYLgDkKGUlW3LjXk66hE3";
$matchesRaw = file_get_contents($matches_url);
$matchesJson = json_decode($matchesRaw, true);
$matches=$matchesJson["matches"];

echo " before calling yeterday function" ;

function yesterdays_ttwenty_matches($match){
	$yesterdays_date=date('Y-m-d',strtotime("-1 days"));
    $actual_date=date('Y-m-d', strtotime($match["date"]));
    return ($match["type"]=="Twenty20" && $yesterdays_date==$actual_date);
}

$yesterdays_matches=array_filter($matches, "yesterdays_ttwenty_matches");
foreach($yesterdays_matches as $match){

 	$matchid=$match["unique_id"];

 	echo "Running script for matchid ".$matchid."<br>";
 	run($matchid);
 	echo "script completed for ".$matchid."<br>";
}
**/
// This is now pulling from iplschedule; the matchid must be populated there based on criapi database
// and this myst be run the next day of the match; if we miss it; or if we need to run it for specific matches
// then we need to commment below and uncomment the hardcoded matchid part.
$count=0;
$matchid=[];
$sql="select matchid,srno,matchstr,matchdate from iplschedule where matchdate=curdate()-1";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $matchid[$count]=$row[0];
}
//$matchid1=1237181;
//$matchid2=1216530;
foreach ($matchid as $value) {
  echo "Running script for matchid " . $value . "<br>";
  run($value);
  echo "script completed for ".$value . "<br>";
  echo " **********************************<br>";

}
/**
echo "Running script for matchid ".$matchid2."<br>";
run($matchid2);
echo "script completed for ".$matchid2."<br>";
echo " **********************************<br>";
**/
//run(1136608);
?>
