
<?
session_start();
	$username=$_SESSION['username'];
	$teamname=$_SESSION['teamname'];
	$teamowner = $_SESSION['username'];
	$leaguename= $_SESSION['leaguename'];
  $iplday=$_SESSION['iplday'];

	include "dbConnect.php";
	global $conn;

	// Create connection
	//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
	// Check connection
	if ($conn == false) {
	  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
	}

	$i=0;
	$sql = "select *  from leaguedraw ld  where leaguename='$leaguename'" ;
//echo $sql . " </br>" ;
	$result = mysqli_query($conn,$sql) ;
	while( $row = mysqli_fetch_array( $result ) )
	{
		$iplmatchnum[$i]=$row[1];
		$ourmatchnum[$i]=$row[2];
		$team1name[$i]=$row[3];
		$team2name[$i]=$row[4];
		$matchdate[$i]=$row[5];
		$score[$i]=$row[7];
		$whowon[$i]=$row[8];
		$actualiplmatch[$i]=$row[9];
		$prediction[$i]=$row[10];
		$team1vote[$i]=$row[11];
		$team2vote[$i]=$row[12];
		$i++;
	}
	mysqli_free_result($result);
	$leaguedrawrows=$i;
	$i=0;
	$sql="select iplday, matchstr, matchdate from iplschedule where iplday>=$iplmatchnum[0]";
	$result = mysqli_query($conn,$sql) ;
	while( $row = mysqli_fetch_array( $result ) )
	{
		$iplmatchstr[$row[0]]=$row[1];
		$iplmatchdate[$row[0]]=$row[2];
		$i++;
	}
	mysqli_free_result($result);

?>

<html>
<head>
	<link href="NewUI/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" type="text/css" href="NewUI/css/table-style.css" />
	<link rel="stylesheet" type="text/css" href="NewUI/css/basictable.css" />
	<link href="NewUI/css/component.css" rel="stylesheet" type="text/css" media="all" />
	<link href="NewUI/css/style_grid.css" rel="stylesheet" type="text/css" media="all" />
	<link href="NewUI/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- font-awesome-icons -->
	<link href="NewUI/css/font-awesome.css" rel="stylesheet">
<title>LEAGUE TEAMS DETAILS</title>
</head>
<body>
    <!-- banner -->
    <div class="wthree_agile_admin_info">
        <div class="w3_agileits_top_nav">
            <ul id="gn-menu" class="gn-menu-main">

                <!-- //nav_agile_w3l -->
                <li class="second logo admin">
                    <h1>
                        <a href="teamLandingPg.php">
                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>Team </a>
                    </h1>
                </li>

                <!-- <li class="second w3l_search admin_login">



                </li> -->
                <li class="second top_bell_nav">
                        <ul class="top_dp_agile ">
                            <li class="dropdown head-dpdn">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-home"></i></a>
                            </li>
                        </ul>
                     </li>
                <li class="second full-screen">

                </li>

            </ul>
            <!-- //nav -->

        </div>
        <div class="clearfix"></div>


        <!-- /inner_content-->
        <div class="inner_content">
            <!-- /inner_content_w3_agile_info-->
            <div class="clearfix"></div>

            <div class="buttons_w3ls_agile" style="margin-top:60px;">

            </div>
            <div class="inner_content_w3_agile_info two_in" style="margin-top: 0px;">
                <!-- <h2 class="w3_inner_tittle">Team Home Page</h2> -->
                <!-- tables -->
                <div class="agile-tables">
                    <div class="w3l-table-info agile_info_shadow">
                        <h3 class="w3_inner_tittle two">Match Schedule for League</h3>

												<table id="table">
														<thead>
																<tr>
		<!--<th align="center">Match#</th> -->
		<th align="center">MatchDate#</th>
		<th align="center">Team1</th>
		<th align="center">Team2</th>
		<!--<th align="center">Date</th> -->
		<th align="center">Score</th>
		<th align="center">Winner</th>
				<th align="center">Matchup</th>
		<!--<th align="center">Prediction</th> -->
		<th align="center">IPL Matchup</th>

	</tr>
</thead>
 <!-- entire while loop to show all rows -->
	<?
//	echo "rows are ". $leaguedrawrows ."</br>";
	for ($count=0; $count<=$leaguedrawrows ; $count++) {
//  echo "values are " . $iplmatchnum[$j] . " " .	$ourmatchnum[$j] . " " . $team1name[$j] . " ".	$team2name[$j] . " ". 	$matchdate[$j] . " ". $score[$j] . "</br> ";
//	echo "and also " . $whowon[$j] . " " . $actualiplmatch[$j] ." " . $prediction[$j] . " " . $team1vote[$j] . " " . $team2vote[$j] . "</br>";
?>
<tbody>
<tr>
	 <!--<td align="center"><? echo $iplmatchnum[$count] ;?></td> -->
		<td class="text-center"><? echo $iplmatchdate[$iplmatchnum[$count]] ; ?></td>
		<? if ($team1name[$count] == $teamname) { ?>
		 <td class="text-center"> <a href="SelectYourTeam.php?mnum=<? echo $iplmatchnum[$count] ; ?>&omn=<?echo $ourmatchnum[$count]; ?>"><strong><? echo $team1name[$count]; ?></strong></a> </td>
		<td class="text-center"> <a href="ViewOtherTeam.php?nm=<? echo $team2name[$count] ?>&mnum=view"><? echo $team2name[$count] ;?></a> </td>
	<? } ?>
	<? if ($team2name[$count] == $teamname) { ?>
		<td class="text-center"> <a href="ViewOtherTeam.php?nm=<? echo $team1name[$count] ?>&mnum=view"><? echo $team1name[$count] ;?></a> </td>
	 <td class="text-center"> <a href="SelectYourTeam.php?mnum=<? echo $iplmatchnum[$count] ; ?>&omn=<?echo $ourmatchnum[$count]; ?>"><strong><? echo $team2name[$count]; ?></strong></a> </td>
 <? } ?>
 <? if ( ($team2name[$count] !== $teamname) && ($team1name[$count] !== $teamname)) { ?>
	 <td class="text-center"> <a href="ViewOtherTeam.php?nm=<? echo $team1name[$count] ?>&mnum=view"><? echo $team1name[$count] ;?></a> </td>
 <td class="text-center"> <a href="ViewOtherTeam.php?nm=<? echo $team2name[$count] ?>&mnum=view"><? echo $team2name[$count] ;?></a> </td>
<? } ?>

		<!--<td align="right"><? echo $matchdate[$count] ; ?></td> -->
		<td class="text-center">&nbsp;<? echo $score[$count] ; ?></td>
		<td class="text-center"><strong><? echo $whowon[$count] ; ?></strong></td>
		<td class="text-center">
	<a href="viewmatchup.php?t1=<? echo $team1name[$count] ?>&t2=<? echo $team2name[$count] ?>&t3=<? echo $ourmatchnum[$count] ?>">
			  <strong>ViewMatchup</strong></a>
				<!--<td align="center">&nbsp;<? echo $prediction[$count] ;?></td> -->
				<td class="text-center"><?echo $iplmatchstr[$iplmatchnum[$count]] ;?></td>


   </tr>
<?
	}	?>

</tbody>
</table>
</div>
</div>
<!-- //tables -->
</div>
<!-- //inner_content_w3_agile_info-->
</div>

<div class="copyrights">
		<p>© 2018 All Rights Reserved | contact avoodi@gmail.com for any queries
		</p>
</div>
<!--copy rights end here-->
<!-- js -->

<script type="text/javascript" src="NewUI/js/jquery-2.1.4.min.js"></script>
<script src="NewUI/js/modernizr.custom.js"></script>
<script src="NewUI/js/classie.js"></script>
<!-- tables -->

<script type="text/javascript" src="NewUI/js/jquery.basictable.min.js"></script>
<script type="text/javascript">
		$(document).ready(function () {
				$('#table').basictable();

				$('#table-breakpoint').basictable({
						breakpoint: 768
				});

				$('#table-swap-axis').basictable({
						swapAxis: true
				});

				$('#table-force-off').basictable({
						forceResponsive: false
				});

				$('#table-no-resize').basictable({
						noResize: true
				});

				$('#table-two-axis').basictable();

				$('#table-max-height').basictable({
						tableWrapper: true
				});
		});
</script>

<!-- <script src="NewUI/js/jquery.nicescroll.js"></script>-->
<script src="NewUI/js/scripts.js"></script>

<script type="text/javascript" src="NewUI/js/bootstrap-3.1.1.min.js"></script>


</body>

</html>
