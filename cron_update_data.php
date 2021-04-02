<?php
require_once "updatePlayerMatchDetails.php";
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
// This is to be changed everyday till we pass it as param
$matchid1=1237181;
//$matchid2=1216530;

echo "Running script for matchid ".$matchid1."<br>";
run($matchid1);
echo "script completed for ".$matchid1."<br>";
echo " **********************************<br>";
/**
echo "Running script for matchid ".$matchid2."<br>";
run($matchid2);
echo "script completed for ".$matchid2."<br>";
echo " **********************************<br>";
**/
//run(1136608);
?>
