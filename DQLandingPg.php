<!DOCTYPE html>
<?

include "dbConnect.php";
global $conn;

session_start();
$uname=$_SESSION['uname'];
$pwd=$_SESSION['pwd'];
$groupname=$_SESSION['groupname'];
$grouppwd=$_SESSION['grouppwd'];
// Check connection
if ($conn == false) {
	echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}
// select from leaguedraw all matches only for this team
$count=0;
$sql="select question, qId, qPoints from DQMaster where groupname='$groupname'";
//echo $sql ;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$question[$count]=$row[0];
	$qId[$count]=$row[1];
	$qPoints[$count]=$row[2];
	$count++;
}
mysqli_free_result($result);

date_default_timezone_set('Asia/Kolkata');
$today=date("z"); //if we put draws before the tournament actual start date(testing) then we need to add that many days to this count
$startofIPL = 81; // ipl started on 23rd mar  so 82nd day of the year
$iplday = ($today-$startofIPL)+1;
$currentHr=date('H');
//echo $iplday;
$matches=0;
$sql= "select team1,team2, matchstr from iplschedule where iplday=$iplday";

$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$team1[$matches]=$row[0];
	$team2[$matches]=$row[1];
	$matchstr[$matches]=$row[2];
	$matches++;
}
mysqli_free_result($result);

$canSubmit='Y';
if (($matches==1 && $currentHr >=20 ) OR ($matches==2 && $currentHr >=16)) { // ondays when ony 1 match is played 8pm is start,so check with 20
 	$canSubmit='N';
}

$sql= "select sum(score) from DQanswersdetails where groupname='$groupname' and username='$uname' ";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$myScore=$row[0];
}
mysqli_free_result($result);

$i=1;
$alreadyAnswered='N';
$sql="select  result from DQanswersdetails where groupname='$groupname' and username='$uname' and iplday=$iplday" ;
$result=mysqli_query($conn,$sql) ;
while ($row=mysqli_fetch_array( $result ) )
{
	$myCurrentAnswers[$i]=$row[0];
	$alreadyAnswered='Y';
	$i++;
}
mysqli_free_result($result);

$i=1;
$otherqId=array();
$sql="select qId, result from DQanswersdetails where groupname='$groupname' and iplday=$iplday and username not in ('$uname')" ;
$result=mysqli_query($conn,$sql) ;
while ($row=mysqli_fetch_array( $result ) )
{
	$otherqId[$i]=$row[0];
	if(array_key_exists($row[0],$otherAnswers)) {
			$otherAnswers[$row[0]]=$otherAnswers[$row[0]].";".$row[1];
	}
	else {
		$otherAnswers[$row[0]]=$row[1];
	}
	$i++;
}


$playercount=0;
$sql="select playername from playermst where iplteam='$team1[0]'";
//echo $sql;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$playerTeam1[$playercount]=$row[0];
	$playercount++;
}
mysqli_free_result($result);

$playercount=0;
$sql="select playername from playermst where iplteam='$team2[0]'";
//echo $sql;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$playerTeam2[$playercount]=$row[0];
	$playercount++;
}
mysqli_free_result($result);

$playercount=0;
$sql="select playername from playermst where iplteam='$team1[1]'";
//echo $sql;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$playerTeam3[$playercount]=$row[0];
	$playercount++;
}
mysqli_free_result($result);

$playercount=0;
$sql="select playername from playermst where iplteam='$team2[1]'";
//echo $sql;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$playerTeam4[$playercount]=$row[0];
	$playercount++;
}
mysqli_free_result($result);


?>

<html>

<head>
	<title>Index page</title>
	<!-- custom-theme -->

	<link href="NewUI/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" type="text/css" href="NewUI/css/table-style.css" />
	<link rel="stylesheet" type="text/css" href="NewUI/css/basictable.css" />
	<link href="NewUI/css/component.css" rel="stylesheet" type="text/css" media="all" />
	<link href="NewUI/css/style_grid.css" rel="stylesheet" type="text/css" media="all" />
	<link href="NewUI/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- font-awesome-icons -->
	<link href="NewUI/css/font-awesome.css" rel="stylesheet">
	<!-- //font-awesome-icons -->
</head>

<body>
	<!-- banner -->
	<div class="wthree_agile_admin_info">
		<div class="w3_agileits_top_nav">
			<ul id="gn-menu" class="gn-menu-main">

				<!-- //nav_agile_w3l -->
				<li class="second logo admin">
					<h1>
						<a href="DQLandingPg.php">
							<i class="fa fa-graduation-cap" aria-hidden="true"></i>Team </a>
					</h1>
				</li>
				<li class="second full-screen">

				</li>

			</ul>

		</div>
		<div class="clearfix"></div>
		<div class="inner_content">
			<!-- /inner_content_w3_agile_info-->
			<div class="clearfix"></div>

			<div class="buttons_w3ls_agile" style="margin-top:60px;">
					<h2 class="w3_inner_tittle">Your Daily Questions Home Page</h2>
				<div class="row " style="margin-bottom:20px;">
					<div class="social_media_w3ls">

						<div class="col-md-3 socail_grid_agile facebook">
							<ul class="icon_w3_info">
								<li>Welcome</li>
								<li>
									<a href="#" class="wthree_facebook" style="color:white; ">
										<span class="badge badge-success"><? echo $uname; ?></span>
									</a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="col-md-3 socail_grid_agile twitter">
							<ul class="icon_w3_info">
								<li>Group Name</li>
								<li>
									<a href="#" class="wthree_facebook" style="color:white">
										<span class="badge badge-success"><? echo $groupname; ?></span>
									</a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="col-md-3 socail_grid_agile gmail">
							<ul class="icon_w3_info">
								<li>Your total score</li>
								<li>
									<a href="#" class="wthree_facebook" style="color:white">
											<span class="badge badge-success"><?echo $myScore; ?> </span>
									</a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<!--h3 class="w3_inner_tittle two">Todays Matche(s)</h3-->
						<div class="col-md-3 socail_grid_agile facebook">
							<ul class="icon_w3_info">
								<li>Todays First Match</li>
								<li>
									<a href="#" class="wthree_facebook" style="color:white; ">
										<span class="badge badge-success"><? echo $team1[0] ; ?> vs <?echo $team2[0] ;?></span>
									</a>
								</li>
							</ul>
							<? if ($team1[1]) { ?>
							<ul class="icon_w3_info">
								<li>Todays Second Match</li>
								<li>
									<a href="#" class="wthree_facebook" style="color:white; ">
										<span class="badge badge-success"><? if ($team1[1]) {echo $team1[1] ;} ?> vs <? if ($team2[1]) {echo $team2[1] ;}?></span>
									</a>
								</li>
							</ul>
						<? } ?>
							<div class="clearfix"></div>
						</div>


					</div>
				</div>

				<div class="clearfix"></div>
				<div class="col-md-12 button_set_one agile_info_shadow text-center">
					<button type="button" class="btn btn-xs btn-success " onClick="Javascript:window.location.href = 'DQpointstable.php';" >Leaderboard for your group</button>
				</div>


				<div class="clearfix"></div>
			</div>
			<div class="inner_content_w3_agile_info two_in">
				<!-- <h2 class="w3_inner_tittle">Team Home Page</h2> -->
				<!-- tables -->

				<div class="agile-tables">
					<div class="w3l-table-info agile_info_shadow">
<!--
							<h3 class="w3_inner_tittle two"><? echo $team1[0] ; ?> Vx  <?echo $team2[0] ;?>  </h3>
							<h3 class="w3_inner_tittle two"><? echo $team1[1] ; ?> Vx  <?echo $team2[1] ;?>  </h3>
-->
		<form name='getanswers' method = 'POST' action = 'DQSaveAnswers.php/' onsubmit="valid()">
						<h3 class="w3_inner_tittle two">Here are todays questions</h3>
						<table id="table">
							<thead>
								<tr>
									<th>Question</th>
									<th>Your Answer</th>
									<th>Points if you get it right</th>
									<th>Look What others think</th>
								</tr>

							</thead>

									<? 	for($i=0; $i<3 ; $i++) {
										?>
								<tbody>
								<tr>
									<td><?echo $question[$i] ;?> </td>
							  	<td> <input type="text" name="myAnswer[]" class="myclass" id="myAnswer[]" value="<?echo $myCurrentAnswers[$i+1];?>"> </td>
									<td><?echo $qPoints[$i] ;?> </td>
									<td><?echo $otherAnswers[$i+1]; ?></td>
									<td> <input type="hidden" name ="qId[]" value="<?echo $qId[$i];?>" > </td>
									<td> <input type="hidden" name ="question[]" value="<?echo $question[$i];?>"> </td>
								</tr>
							<? } ?>
							<? if ($matches >2) {  ?>
							 	<tr>
									<td align="CENTER" bgcolor="ff22hh" colspan="3">Second Match (ignore if there is only 1 match today)</td>
								</tr>
								<? 	for($i=3; $i<6 ; $i++) { ?>
								<tr>
									<td><?echo $question[$i] ;?> </td>
									<td> <input type="text" name="myAnswer[]"  class="myclass"  id="myAnswer[]" value="<?echo $myCurrentAnswers[$i+1];?>"> </td>
									<td><?echo $qPoints[$i] ;?> </td>
									<td><?echo $otherAnswers[$i+1]; ?></td>
									<td> <input type="hidden" name ="qId[]" value="<?echo $qId[$i];?>" > </td>
									<td> <input type="hidden" name ="question[]" value="<?echo $question[$i];?>"> </td>

								</tr>

							<? } ?>
								<?
							} ?>
							<tr>
							<? if ($canSubmit=='Y') { ?>
							<td ALIGN="CENTER" colspan="2" > <input type="submit" value="Submit" name="B1"> </td>
							<td> <input type="reset" value="Reset" name="B2"></td>
						<? } ?>
							</tr>
						</tbody>

						</table>
	</form>
					</div>
					<table>

						<tr>
							<td>Players List Team1</td>
							<td>Players List Team2</td>
							<td>Players List Team3</td>
							<td>Players List Team4</td>
						</tr>
						<? for ($playercount=0;$playercount<25;$playercount++) { ?>
								<tbody>
								<tr>
								<td><?echo $playerTeam1[$playercount] ;?></td>
								<td><? echo $playerTeam2[$playercount]; ?></td>
								<td><? echo $playerTeam3[$playercount] ; ?></td>
								<td><? echo $playerTeam4[$playercount]; ?></td>
							</tr>
						<? } ?>
					</tbody>
					</table>
				</div>
				<!-- //tables -->
			</div>
			<!-- //inner_content_w3_agile_info-->
		</div>
		<!-- //inner_content-->
		<!--copy rights start here-->
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

		<script src="NewUI/js/jquery.nicescroll.js"></script>
		<script src="NewUI/js/scripts.js"></script>

		<script type="text/javascript" src="NewUI/js/bootstrap-3.1.1.min.js"></script>


</body>

</html>
<script language="javascript">

function valid()
	{
		var x = document.getanswers.myAnswer[1].value;
		var y=  document.getanswers.myAnswer[2].value;
		var z=document.getanswers.myAnswer[3].value;
		var alertstring=" ur first answer " + x + "second is "+ y + "third is "+z;
		alert (alertstring);

	}
	</script>
