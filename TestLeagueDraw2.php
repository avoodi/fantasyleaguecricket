<?
include "dbConnect.php";
global $conn;
if ($conn == false) {
  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}
else { echo "all good with db";}

      # XXX check for int

  $teamnames='Indian Avengers|MM221080|UnitedIndia|Lord|My IPL team|winners';

//T1|T2|T3|T4|T5|T6';

  print show_fixtures(isset($_GET['teams']) ?  nums(intval($_GET['teams'])) : explode("|", trim($teamnames)));

function nums($n) {
    $ns = array();
    for ($i = 1; $i <= $n; $i++) {
        $ns[] = $i;
    }
    return $ns;
}

function show_fixtures($names) {
    $teams = sizeof($names);
    $leaguename="PMOLeague";
    global $conn;
    if ($conn == false) {
      echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
    }
    else { echo "all good with db";}
    // If odd number of teams add a "ghost".
    $ghost = false;
    if ($teams % 2 == 1) {
        $teams++;
        $ghost = true;
    }

    // Generate the fixtures using the cyclic algorithm.
    $totalRounds = $teams - 1;
    $matchesPerRound = $teams / 2;
    $rounds = array();
    for ($i = 0; $i < $totalRounds; $i++) {
        $rounds[$i] = array();
    }

//my for loop
date_default_timezone_set('Asia/Kolkata');
$today=date("z");

$startofIPL = 262; // ipl starting on 19th sep of the year
$startofOurLeague = ($today-$startofIPL)+1;
$endofIPL =307; // the ipl league matches end on 3rd nov which is 125th day
$daysforOurLeague=$endofIPL-$today;
$ourmatchnum=7;//for leagues starting new this should be 1 ,this needs to adjusted based on the league we are running this
echo $startofOurLeague ." and ".$daysforOurLeague ;
$iplmatchnum=$startofOurLeague;
$totalIPLDays=$endofIPL - $startofIPL;

 for ($cnt=1; $cnt<=$daysforOurLeague ;$cnt++) {

    for ($round = 0; $round < $totalRounds; $round++) {
        for ($match = 0; $match < $matchesPerRound; $match++) {
            $home = ($round + $match) % ($teams - 1);
            $away = ($teams - 1 - $match + $round) % ($teams - 1);
            // Last team stays in the same place while the others
            // rotate around it.
            if ($match == 0) {
                $away = $teams - 1;
            }
            $rounds[$round][$match] = team_name($home + 1, $names)
                . " v " . team_name($away + 1, $names);
        }
    }

    // Interleave so that home and away games are fairly evenly dispersed.
    $interleaved = array();
    for ($i = 0; $i < $totalRounds; $i++) {
        $interleaved[$i] = array();
    }

    $evn = 0;
    $odd = ($teams / 2);
    for ($i = 0; $i < sizeof($rounds); $i++) {
        if ($i % 2 == 0) {
            $interleaved[$i] = $rounds[$evn++];
        } else {
            $interleaved[$i] = $rounds[$odd++];
        }
    }
    $rounds = $interleaved;
    // Last team can't be away for every game so flip them
    // to home on odd rounds.
    for ($round = 0; $round < sizeof($rounds); $round++) {
        if ($round % 2 == 1) {
            $rounds[$round][0] = flip($rounds[$round][0]);
        }
    }
    // Display the fixtures
    for ($i = 0; $i < sizeof($rounds); $i++) {
  //      print "<hr><p>Round " . ($i + 1) . " and print day is ". $iplmatchnum . "</p>\n";

        foreach ($rounds[$i] as $r) {
        //  print $r .  $ourmatchnum ."<br />";
          $teamsforprint= explode(' v ', $r);
          // echo "team 1 " . $teamsforprint[1]  ." and team 2 " . $teamsforprint[0] ."<br />";
             $sql3= "insert into leaguedraw(leaguename, iplmatchnum, ourmatchnum, team1name, team2name) values('$leaguename',$iplmatchnum, $ourmatchnum,'$teamsforprint[0]', '$teamsforprint[1]' )" ;
          	if(! mysqli_query($conn,$sql3) )
            {
              die('error sql3');
            }
                     echo $sql3 ."</br>";
          $ourmatchnum++;
        }
        $iplmatchnum++;
        if ($iplmatchnum>$totalIPLDays) {  break; }
        print "<br />";
    }
    if($iplmatchnum>$totalIPLDays){break;}

//    print "<hr>Second half is mirror of first half";
    $round_counter = sizeof($rounds) + 1;
    for ($i = sizeof($rounds) - 1; $i >= 0; $i--) {
//        print "<hr><p>Round " . $round_counter . "</p>\n";
        //print "<hr><p>Round " . ($i + 1) . " and print day is ". $iplmatchnum . " and ourmatch ". $ourmatchnum . "</p>\n";
        $round_counter += 1;
        foreach ($rounds[$i] as $r) {
          //  print flip($r) . $ourmatchnum. "<br />";
            $teamsforprint = explode(' v ', flip($r));
        //     echo "team 1 " . $teams[1]  ." and team 2 " . $teams[0] ."<br />";
               $sql3= " insert into leaguedraw(leaguename, iplmatchnum, ourmatchnum, team1name, team2name) values('$leaguename',$iplmatchnum, $ourmatchnum,'$teamsforprint[0]', '$teamsforprint[1]' )" ;
               			if(! mysqli_query($conn,$sql3) )
                    {
                      die('error sql3');
                    }
                    echo $sql3 ."</br>";

            $ourmatchnum++;
        }
        $iplmatchnum++;
        if ($iplmatchnum>$totalIPLDays) {  break; }
        print "<br />";
    }
    print "<br />";
    if ($iplmatchnum>$totalIPLDays) {  break; }

    if ($ghost) {
        print "Matches against team " . $teams . " are byes.";
    }


} // my for loop ends here

}

function flip($match) {
    $components = explode(' v ', $match);
    return "$components[1]" . " v " . "$components[0]";
}

function team_name($num, $names) {
    $i = $num - 1;
    if (sizeof($names) > $i && strlen(trim($names[$i])) > 0) {
        return trim($names[$i]);
    } else {
        return "BYE";
    }
}
?>
