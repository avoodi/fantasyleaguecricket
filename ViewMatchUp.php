<?
session_start();
	$username=$_SESSION['username'];
	$teamname=$_SESSION['teamname'];
	$teamowner = $_SESSION['username'];
	$leaguename= $_SESSION['leaguename'];
	$ourmatchnum=$_GET['t3'];
	$team1=$_GET['t1'];
	$team2=$_GET['t2'];


	include "dbConnect.php";
	global $conn;

//echo "our match num is : " . $ourmatchnum . "and team 1 : ". $team1 . "and team2 is : ".$team2;

	if ($conn == false) {
	  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
	}

	$playercount=0;
	$playercount1=0;
	$playercount2=0;
	$sql = "select s.pid,s.playername,s.ownerteam,s.iscaptain ,p.points,s.iplday  from selectedplayers s left join playersmatchdetails p  on(s.playername=p.playername and s.leaguename=p.leaguename and s.leaguematchnum=p.ourmatchnum) where s.leaguename='$leaguename' and s.leaguematchnum=$ourmatchnum  "	 ;
//echo $sql . " </br>" ;
	$result = mysqli_query($conn,$sql) ;
	while( $row = mysqli_fetch_array( $result ) )
	{
		if($row[2] == $team1) {
				$pid1[$playercount1]=$row[0];
				$playername1[$playercount1]=$row[1];
				$ownerteam1[$playercount1]=$row[2];
				$iscaptain1[$playercount1]=$row[3];
				$points1[$playercount1]=$row[4];
				$playercount1++;
		}
		if($row[2] == $team2) {
				$pid2[$playercount2]=$row[0];
				$playername2[$playercount2]=$row[1];
				$ownerteam2[$playercount2]=$row[2];
				$iscaptain2[$playercount2]=$row[3];
				$points2[$playercount2]=$row[4];
				$playercount2++;
		}
		$iplmatchnum=$row[5]; // yes its not supposed to be an array, asits alwys going to be one value for this query
		$playercount++;
	}
	mysqli_free_result($result);
//echo $playercount . "and ". $playercount1 . " and " . $playercount2;

// get the match string - to be used just for display
$sql="select distinct matchstr , matchdate from iplschedule where iplday=$iplmatchnum";
//echo $sql . "</br>" ;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $todayIPLmatch=$row[0];
	$matchdate=$row[1];
  //echo " in here " .$todayIPLmatch;
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
<title>Team Matchup</title>
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
                        <h3 class="w3_inner_tittle two">This is how teams matchup for this match</h3>
        								<h4 class="w3_inner_tittle two"><?echo $todayIPLmatch ; ?> on <? echo $matchdate ; ?></h3>
												<table id="table">
														<thead>
																<tr>
		<!--<th align="center">Match#</th> -->
		<div class="mark">
		<th colspan="3" align="center"> Team 1 : <?echo $team1 ;?></th>
		<th colspan="3" align="center"> Team 2 : <?echo $team2 ;?> </th>
	</div>
	</tr>
	<tr>
		<th align="center">Playername</th>
		<th align="center">Captain(Y/N)</th>
		<th align="center">Points</th>
		<th align="center">Playername</th>
		<th align="center">Captain(Y/N)</th>
		<th align="center">Points</th>

	</tr>
</thead>
 <!-- entire while loop to show all rows -->
 <tbody>

	<?
	for ($count=0; $count<$playercount ; $count++) {
?>
<tr>
	<? if ($count<$playercount1) { ?>
		<td class="text-center"><? echo $playername1[$count] ; ?></td>

		<? if($iscaptain1[$count] =='Y') {?>
			<td class="text-center">Yes</td>
		<? } ;?>
		<? if($iscaptain1[$count] =='N') {?>
			<td class="text-center">-</td>
		<? } ;?>

		<td class="text-center"><? echo $points1[$count]; ?></td>
	<? }; ?>
	<? if($count>=$playercount1) { ?>
		<td class="text-center"> - </td>
		<td class="test-center"> - </td>
		<td class="text-center"> - </td>
  <?	}; ?>

	<? if($count<$playercount2) { ?>
		<td class="text-center"><? echo $playername2[$count] ; ?></td>

		<? if ($iscaptain2[$count] =='Y') {?>
			<td class="text-center">Yes</td>
		<? } ;?>
		<? if ($iscaptain2[$count] =='N') { ?>
			<td class="text-center">-</td>
		<? } ;?>

		<td class="text-center"><? echo $points2[$count]; ?></td>
	<? }; ?>
	<? if($count>=$playercount2) { ?>
		<td class="text-center"> - </td>
		<td class="test-center"> - </td>
		<td class="text-center"> - </td>
		<?	}; ?>

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
