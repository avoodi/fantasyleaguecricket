<?
// assuming the criapi has given us the scores of the matches on the day and data has been inserted in table rawscoreupdate
// we need to
// (0) get raw data and update playermst
// a)run this logic for all leagues which have bidding closed
// b) find out which  teams played in our league (team1 and team2)
// c) from leagueauctionresults find out how many players are selected by all the teams in this league (max would be 22 or 44)
// d) get leaguerules for the leagues
// e) insert into playermatchdetails the rawscores and points (as per league rules)
// f) find out aggregated scores for each team in leagues
// g) read leaguedraw and find out who won - update the leaguedraws and  teamleaguedetils accordingly
// h) copy rawscoreupdate into rawscoreupdate_archive table and then delete rawscoreupdate

$leaguename=$_POST['leaguename']; //very important how thisis passed
$iplday=$_POST['iplday']; // this should be supplied to this program
$matchid=$_POST['matchid'];
$isrunearlier=$_POST['firstrun'];

echo $leaguename . " ". $iplday ." " . $matchid;
// lets read from the rawscoreupdate

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

//change below when we have 2 matches scores
//$sql="select pid,matchid,playername,ifnull(runs_scored,0),ifnull(balls_played,0),ifnull(fours_hit,0),ifnull(sixes_hit,0),ifnull(catches_taken,0),ifnull(runouts,0),ifnull(wickets_taken,0),ifnull(overs_bowled,0),ifnull(maiden_overs,0),ifnull(runs_given,0),ifnull(mom,0) from player_details_per_match where matchid=$matchid" ;
$sql="select pid,matchid,playername,ifnull(runs_scored,0),ifnull(balls_played,0),ifnull(fours_hit,0),ifnull(sixes_hit,0),ifnull(catches_taken,0),ifnull(runouts,0),ifnull(wickets_taken,0),ifnull(overs_bowled,0),ifnull(maiden_overs,0),ifnull(runs_given,0),ifnull(mom,0) from player_details_per_match where matchid in (1136578,1136579)" ;

echo $sql;
$i=0;
$result= mysqli_query($conn,$sql);
while($row=mysqli_fetch_array($result))
{
// store all values of rawscoreupdt in Here
$raw_pid[$i]=$row[0];
$raw_matchid=$row[1];
$raw_playername[$i]=$row[2];
$raw_runsscored[$i]=$row[3];
$raw_ballsplayed[$i]=$row[4];
$raw_fours[$i]=$row[5];
$raw_sixes[$i]=$row[6];
$raw_catches[$i]=$row[7];
$raw_runout[$i]=$row[8];
$raw_wicketstaken[$i]=$row[9];
$raw_overs[$i]=$row[10];
$raw_maiden[$i]=$row[11];
$raw_runsgiven[$i]=$row[12];
$raw_mom[$i]=$row[13];
$i++;
}

$countofplayerstoday=$i;

mysqli_free_result($result);
echo "Raw data collected for ". $countofplayerstoday ." and is run earlier ". $isrunearlier . "</br>";
//lets first add to playermst only if its first time (dont need to update playermst for each league)

if ($isrunearlier=='Y'){
for ($i=0 ; $i<$countofplayerstoday; $i++){

$sqlupdt="update playermst SET  score=score+$raw_runsscored[$i], numberof4=numberof4+$raw_fours[$i], numberof6=$raw_sixes[$i], numberofcatches=numberofcatches+$raw_catches[$i], numberofrunouts=numberofrunouts+$raw_runout[$i], manofthematch=manofthematch+$raw_mom[$i], wickets=wickets+$raw_wicketstaken[$i], overs=overs+$raw_overs[$i],
 runsconsided=runsconsided+$raw_runsgiven[$i], ballsfaced=ballsfaced+$raw_ballsplayed[$i],maidenover=maidenover+$raw_maiden[$i] where pid=$raw_pid[$i]";
echo $sqlupdt."</br>";
 if(! mysqli_query($conn,$sqlupdt) )
   {
     die('error sqlupdate');
   }

}
echo "updated playermst </br>";
}
// lets do (b)
$teamsinleague=0;
$sql="select team1name, team2name, ourmatchnum from leaguedraw where iplmatchnum=$iplday and leaguename='$leaguename'";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $playingteam1[$teamsinleague]=$row[0];
  $playingteam2[$teamsinleague]=$row[1];
  $ourmatchnum[$teamsinleague]=$row[2];
  $teamsinleague++;
} // with this we would have array of 2 or 4 IPL teams playing that day
mysqli_free_result($result);

echo " all team names and ourmatch number collected ". $teamsinleague ."</br>";

// now lets do (c)
$playercount=0;
//$sql2="select playername, ownerteam, ccaptainyn,pid from leagueauctionresults where leaguename='$leaguename'  and inplaying11='Y' ";
$sql2="select pid, playername, ownerteam, iscaptain from selectedplayers where leaguename='$leaguename' and iplday=$iplday";
$result = mysqli_query($conn,$sql2) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $playername[$playercount]=$row[1];
  $ownerteam[$playercount]=$row[2];
  $ccaptainyn[$playercount]=$row[3];
  $Sel_pid[$playercount]=$row[0];
  $playercount++;
}
mysqli_free_result($result);

echo " all the players from all teams in our league who are in playing11 have been collected ". $playercount ." </br>";

//now lets do (d)
$sql3="select runpoints,catchpoints,wicketpoints,runoutpoints,maidenoverpoints, boundrypoints, sixerpoints, mompoints from leaguerules where leaguename='$leaguename'  ";
$result = mysqli_query($conn,$sql3) ;
while( $row = mysqli_fetch_array( $result ) )
{
                       $LR_runpoints=$row[0];
                       $LR_catchpoints=$row[1];
                       $LR_wicketpoints=$row[2];
                       $LR_runoutpoints=$row[3];
                       $LR_maidenoverpoint=$row[4];
                       $LR_boundrypoints=$row[5];
                       $LR_sixerpoints=$row[6];
                       $LR_mompoints=$row[7];
}
mysqli_free_result($result);

echo "league rules collected </br>";

//lets do (e)
$i=0;
for ($i=0; $i<$playercount ; $i++){
//insert into playermatchdetails ; calculate totals as well

$runpoints=0;
$catchpoints=0;
$wicketpoints=0;
$runpoints=0;
$maidenoverpoints=0;
$boundrypoints=0;
$sixerpoints=0;
$mompoints=0;

//echo $Sel_pid[$i]. " vs ". print_r($raw_pid) ;
$key=array_search($Sel_pid[$i],$raw_pid);
if ($key !== false){
  //means player was in playing 11, so count the points based on league rules and insert into playersmatchdetails
  $runpoints=$raw_runsscored[$key] * $LR_runpoints;
  $catchpoints=$raw_catches[$key] * $LR_catchpoints;
  $wicketpoints=$raw_wicketstaken[$key] * $LR_wicketpoints;
  $runoutpoints=$raw_runout[$key] * $LR_runpoints;
  $maidenoverpoints=$raw_maiden[$key] * $LR_maidenoverpoint;
  $boundrypoints=$raw_fours[$key] * $LR_boundrypoints;
  $sixerpoints=$raw_sixes[$key] * $LR_sixerpoints;
  if($raw_mom[$key]=='Y'){
    //please CHECK WHAT VALUE FOR MOM IS GETTING FROM JSON TO RAW TABLE
    $mompoints=$LR_mompoints;
  }

  if($ccaptainyn[$key]=='Y'){
    $totalpoints= ($runpoints + $catchpoints + $wicketpoints + $runoutpoints + $maidenoverpoints + $boundrypoints + $sixerpoints + $mompoints)*2;
  }
  else {
    $totalpoints= $runpoints + $catchpoints + $wicketpoints + $runoutpoints + $maidenoverpoints + $boundrypoints + $sixerpoints + $mompoints ;
  }
    // now insert into playersmatchdetails table
    $sqlins = "insert into playersmatchdetails (leaguename, ownerteamname, playername, iplmatchnum, ourmatchnum, runs, wickets, catches, runoutstumpout, hit4, hit6, overs, runsconsided, inplaying11, mom, howout, points, ballsfaced, maidenovers,iscaptainyn) Values ";
    $sqlins = $sqlins. "('$leaguename','$ownerteam[$i]','$playername[$i]',$iplday,0,$raw_runsscored[$key],$raw_wicketstaken[$key],$raw_catches[$key],$raw_runout[$key],$raw_fours[$key],$raw_sixes[$key],$raw_overs[$key],$raw_runsgiven[$key],'Y','$raw_mom[$key]','',$totalpoints,$raw_ballsplayed[$key], $raw_maiden[$key],'$ccaptainyn[$key]' ) ";

    echo $sqlins."</br>";

    if(! mysqli_query($conn,$sqlins) )
      {
        die('error sqlins');
      }
}
else {
  // the player in playing11 was not playing that day
  echo "do nothing ";
}
}

echo " for each player points calculated and inserted into playersmatchdetails </br>";

// now lets aggregate the scores at team level and find out who won , then update leaguedraw and teamleaguedetils accordingly
for ($i=0; $i<$teamsinleague ; $i++) {

  $team1totalpoints=0;
  $team2totalpoints=0;

  $sql1="select ifnull(sum(points),0) from playersmatchdetails where leaguename='$leaguename' and ownerteamname='$playingteam1[$i]' and iplmatchnum=$iplday";

echo "sql for team1 ".$sql1."</br>";

  $result = mysqli_query($conn,$sql1) ;
  while( $row = mysqli_fetch_array( $result ) )
  {
    $team1totalpoints=$row[0];
  }
  mysqli_free_result($result);

  $sql2="select ifnull(sum(points),0) from playersmatchdetails where leaguename='$leaguename' and ownerteamname='$playingteam2[$i]' and iplmatchnum=$iplday ";

  echo "sql for team2 ".$sql2."</br>";

$result = mysqli_query($conn,$sql2) ;
  while( $row = mysqli_fetch_array( $result ) )
  {
    $team2totalpoints=$row[0];
  }

echo " both teams total scores/points calculated </br>";

  $matchscore="". $team1totalpoints ." - " .$team2totalpoints;

  mysqli_free_result($result);
  if($team1totalpoints > $team2totalpoints){
    $whowon=$playingteam1[$i];
    $sqlupdt2="update leagueteamsdetails set totalteamscore=totalteamscore+$team1totalpoints, matcheswon=matcheswon+1, points= points+2 where leaguename='$leaguename' and teamname='$playingteam1[$i]' ";
    $sqlupdt3="update leagueteamsdetails set totalteamscore=totalteamscore+$team1totalpoints, matcheslost=matcheslost+1 where leaguename='$leaguename' and teamname='$playingteam2[$i]' ";
  }
  if( $team1totalpoints < $team2totalpoints){
    $whowon=$playingteam2[$i];
    $sqlupdt2="update leagueteamsdetails set totalteamscore=totalteamscore+$team2totalpoints, matcheswon=matcheswon+1, points= points+2 where leaguename='$leaguename' and teamname='$playingteam2[$i]' ";
    $sqlupdt3="update leagueteamsdetails set totalteamscore=totalteamscore+$team1totalpoints, matcheslost=matcheslost+1 where leaguename='$leaguename' and teamname='$playingteam1[$i]' ";
  }
  if($team1totalpoints == $team2totalpoints){
    $whowon='Match Tied';
    $sqlupdt2="update leagueteamsdetails set totalteamscore=totalteamscore+$team2totalpoints, matchesdrawn=matchesdrawn+1, points= points+1 where leaguename='$leaguename' and teamname='$playingteam2[$i]' ";
    $sqlupdt3="update leagueteamsdetails set totalteamscore=totalteamscore+$team1totalpoints, matchesdrawn=matchesdrawn+1,points= points+1 where leaguename='$leaguename' and teamname='$playingteam1[$i]' ";
  }
  // update league draw and leagueteamdetails

echo "updt2 " . $sqlupdt2 . "</br>" ;
echo "updt3 " . $sqlupdt3 . "</br>" ;

  $sqlupdt="update leaguedraw set whowon='$whowon', score='$matchscore' where leaguename='$leaguename' and ourmatchnum=$ourmatchnum[$i]";
echo " updt leaguedraw is " . $sqlupdt . "</br>";
  if(! mysqli_query($conn,$sqlupdt) )
  	{
  		die('error sqlupdate');
  	}

  if(! mysqli_query($conn,$sqlupdt2) )
      {
        die('error $sqlupdt2');
      }

  if(! mysqli_query($conn,$sqlupdt3) )
          {
            die('error $sqlupdt2');
          }

}

?>
