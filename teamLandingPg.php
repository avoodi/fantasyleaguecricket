<!DOCTYPE html>
<?
session_start();
include "dbConnect.php";
global $conn;


$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$pass=$_SESSION['pwd'];
$teamname=$_SESSION['teamname'];
$teamownername=$_SESSION['teamownername'];
$iplday=$_SESSION['iplday'];

//echo "leaguename is ". $leaguename . " and owner name is " . $teamownername . 'is correct';

//$servername = "localhost:3306";
//$dbusername = "fanta_avad";
//$dbpassword = "FLeague@2018";
//$dbname="fantas10_avad";
// Create connection
//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if ($conn == false) {
	echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}
// select from leaguedraw all matches only for this team
$count=0;
//$sql="select ld.ourmatchnum,ld.iplmatchnum,ld.team1name, ld.team2name, ifnull(ld.score,'-') score, ifnull(ld.whowon,'-') whowon,ld.actualiplmatch  from  leaguedraw ld where ld.leaguename='$leaguename' ";
$sql="select distinct ld.ourmatchnum,ld.iplmatchnum,ld.team1name, ld.team2name, ifnull(ld.score,'-') score, ifnull(ld.whowon,'-') whowon, i.matchstr, i.matchdate  from  leaguedraw ld left join iplschedule i on (i.iplday=ld.iplmatchnum) where ld.leaguename='$leaguename'";
//echo $sql ;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$iplmatchnum[$count]=$row[1];
	$ourmatchnum[$count]=$row[0];
	$team1name[$count]=$row[2];
	$team2name[$count]=$row[3];
	$iplmatchs[$count]=$row[6];
	$iplmatchdate[$count]=$row[7];
	$score[$count]=$row[4];
	$whowon[$count]=$row[5];
	$count++;

}
mysqli_free_result($result);

$isOwner='No';
$sql="select leaguecreatorname,drawdone from league_mst where leaguename='$leaguename'";
//echo $sql;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$Owner=$row[0];
//	echo "here owner is " . $Owner ."is it right?";
	$drawdone=$row[1];
}
//echo "session owner is ". $teamownername . "and comparing it ".$Owner ;
if ($Owner == $teamownername)
{
	$isOwner='Yes';
}
mysqli_free_result($result);

$numberofplayers=0;
$totalbidamt=0;
$teamvirpp=0;
$sql="select count(*) from leagueauctionresults where leaguename='$leaguename' and ownerteam='$teamname'";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$numberofplayers=$row[0];
}
mysqli_free_result($result);

$sql="select ifnull(sum(currenthighestbid),0) from leagueauctionresults where leaguename='$leaguename' and ownerteam='$teamname'";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$totalbidamt=$row[0];
	$teamvirpp=15000000-$totalbidamt;
}
mysqli_free_result($result);

$sqlupdt="update leagueteamsdetails set Currentbidamount=$totalbidamt , virtualpurchasepower=$teamvirpp, numberofplayers=$numberofplayers WHERE leaguename = '$leaguename' and teamname='$teamname' ";
//echo $sqlupdt;
	if(! mysqli_query($conn,$sqlupdt) )
		{
			die('error sqlupdate');
		}
//

//$sql="select virtualpurchasepower,numberofplayers from leagueteamsdetails where leaguename='$leaguename' and teamname='$teamname' ";
//$result = mysqli_query($conn,$sql) ;
//while( $row = mysqli_fetch_array( $result ) )
//{
//	$teamvirpp=$row[0];
//	$numberofplayers=$row[1];
//}
//mysqli_free_result($result);

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
						<a href="teamLandingPg.php">
							<i class="fa fa-graduation-cap" aria-hidden="true"></i>Team </a>
					</h1>
				</li>

				<!-- <li class="second w3l_search admin_login">



				</li> -->
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
					<h2 class="w3_inner_tittle">Team Home Page</h2>
				<div class="row " style="margin-bottom:20px;">
					<div class="social_media_w3ls">

						<div class="col-md-3 socail_grid_agile facebook">
							<ul class="icon_w3_info">
								<li>Team Name</li>
								<li>
									<a href="#" class="wthree_facebook" style="color:white; ">
										<span class="badge badge-success"><? echo $teamname; ?></span>
									</a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="col-md-3 socail_grid_agile twitter">
							<ul class="icon_w3_info">
								<li>League Name</li>
								<li>
									<a href="#" class="wthree_facebook" style="color:white">
										<span class="badge badge-success"><? echo $leaguename; ?></span>
									</a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="col-md-3 socail_grid_agile gmail">
							<ul class="icon_w3_info">
								<li>Amount You have</li>
								<li>
									<a href="#" class="wthree_facebook" style="color:white">
											<span class="badge badge-success"><?echo $teamvirpp; ?></span>
									</a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="col-md-3 socail_grid_agile dribble">
							<ul class="icon_w3_info">
								<li>#of Players you have</li>
								<li>
									<a href="#" class="wthree_facebook" style="color:white">
										<span class="badge badge-success"><? echo $numberofplayers; ?></span>
									</a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-12 button_set_one agile_info_shadow text-center">
					<!-- Standard button -->
					<? if ($isOwner=='No') {?>
					<button type="button" class="btn btn-xs btn-warning" onClick="Javascript:window.location.href = 'LeagueRulesView.php';">League Rules</button>
				<? } ?>
			 <? if ($isOwner=='Yes') { ?>
				 <button type="button" class="btn btn-xs btn-warning" onClick="Javascript:window.location.href = 'LeagueRules.php';">League Rules</button>

			 <? } ?>

					<button type="button" class="btn btn-xs btn-success " onClick="Javascript:window.location.href = 'PlayersListForBidding.php';" >Bidding</button>
					<button type="button" class="btn btn-xs btn-danger" onclick="call_leaguestanding()" >League Standing </button>
					<? if ($isOwner=='Yes') { ?>
						<? if ($drawdone =='N') {?>
						<!--	<button type="button" class="btn btn-xs btn-info" onClick="Javascript:window.location.href = 'NewLeagueDraw.php';">Create League Schedule(draws) </button>
						<button type="button" class="btn btn-xs btn-success" onClick="Javascript:window.location.href = 'RandomAlloc.php';">Auto Allocation</button> -->

							<button type="button" class="btn btn-xs btn-info" onClick="confirmPutUpDraws()">Create League Schedule(draws)</button>
						<button type="button" class="btn btn-xs btn-success" onClick="confirmRandomAlloc()">Auto Allocation</button>
						<? } ?>
					<? } ?>
					<button type="button" class="btn btn-xs btn-info" onClick="Javascript:window.location.href = 'ShowLeagueDraws.php';">League Schedule(draws) </button>

					<button type="button" class="btn btn-xs btn-primary" onClick="Javascript:window.location.href = 'ViewYourTeam.php';">Your Team</button>
					<button type="button" class="btn btn-xs btn-warning" onClick="Javascript:window.location.href = 'PlayerPurchaseAfterBiddingOver.php';">Player Purchase </button>
					<button type="button" class="btn btn-xs btn-primary" onClick="Javascript:window.location.href = 'Sellplayer.php';">Player Sell </button>
					<button type="button" class="btn btn-xs btn-info" onClick="Javascript:window.location.href = 'viewallplayersperf.php';">All Players performance</button>
				</div>

				<div class="clearfix"></div>
			</div>
			<div class="inner_content_w3_agile_info two_in">
				<!-- <h2 class="w3_inner_tittle">Team Home Page</h2> -->
				<!-- tables -->
				<? if ($isOwner=='Yes') {?>
<h3 class="w3_inner_tittle two">
	<p> You are the league creator; you have powers :), and with power comes responsibility... </p>
	<p> DO NOT click on buttons which say "AutoAllocation" or "Create League Schedule" as yet </p>
	<p> To get the league started quickly follow below steps</p>
	<p> 1.  invite few friends (any number >4 to 14 is good we say) </p>
	<p> 2. after you have enough teams go to league rules page and change rules if required </p>
	<p> 3. on league rules page , check what the 'Current Bidding Status' says </p>
	<p> 4. if your league wants to go for bidding -the value should be 'started-in progress'</p>
	<p> 5. fix some time window for bidding and communicate with other teams; and change the value to 'bidding over' whenever you want to close bidding </p>
	<p> 6. if your league does not want to go for bidding then you can click on the 'Auto allocation' button  </p>
	<p> 7. after bidding is over OR auto allocation is done, then put up league draws by clicking 'Create League Schedule' button </p>
	<p> 8. thats it your league is all set now </p>
	<p> pl email avoodi@gmail.com if you need any help </p>
<? } ?>
<? if ($isOwner=='No') {?>
	<? if ($drawdone =='N') {?>
			<h3 class="w3_inner_tittle two">
			<p> Match schedule for your team will appear below, after your league has enough teams and league creator has clicked on 'create draws' ! </p>
			<p> May be your league is still bidding for players ? Talk to the league creator ; and should you need any help/have questions , do write to avoodi@gmail.com </p>
		<? } ?>
<? } ?>
				<div class="agile-tables">
					<div class="w3l-table-info agile_info_shadow">
						<h3 class="w3_inner_tittle two">Match Schedule for your team</h3>
						<table id="table">
							<thead>
								<tr>
									<th>MatchDate</th>
									<th>Team1</th>
									<th>Team2</th>
									<th>Score</th>
									<th>Winner</th>
									<th>IPL Matchup</th>
								</tr>
							</thead>
							<?
						//	echo "rows are ". $count ."</br>";
							for ($i=0; $i<$count ; $i++) {
								if ($team1name[$i]==$teamname || $team2name[$i]==$teamname) {
						?>
							<tbody>
								<tr>
										<!--<td><? echo $ourmatchnum[$i] ; ?></td> -->
										<td><? echo $iplmatchdate[$i]; ?></td>
										<? if ($team1name[$i] == $teamname) { ?>
										<td> <a href="SelectYourTeam.php?mnum=<? echo $iplmatchnum[$i] ; ?>&omn=<?echo $ourmatchnum[$i]; ?>"><strong><? echo $team1name[$i]; ?></strong></a> </td>
										<td> <a href="ViewOtherTeam.php?nm=<? echo $team2name[$i] ?>&mnum=view"><? echo $team2name[$i] ;?></a> </td>
									<? } ?>
									<? if ($team2name[$i] == $teamname) { ?>
										<td> <a href="ViewOtherTeam.php?nm=<? echo $team1name[$i] ?>&mnum=view"><? echo $team1name[$i] ;?></a> </td>
										<td> <a href="SelectYourTeam.php?mnum=<? echo $iplmatchnum[$i] ; ?>&omn=<?echo $ourmatchnum[$i]; ?>"><strong><? echo $team2name[$i]; ?></strong></a> </td>
									<? } ?>
										<td> <? echo $score[$i] ; ?> </td>
										<td><strong> <? echo $whowon[$i] ; ?></strong></td>
										<td ><?echo $iplmatchs[$i] ;?></td>
								</tr>
							<? }
								}	?>

							</tbody>
						</table>
					</div>
					<table valign="top" align="center" border="4" bordercolordark="#CC0066" >
							<tr> <td> League Wall </td></tr>
							<tr>
								<td>
									<form name="form1" method="post" action="wallpost.php" >
										<input name="wallPost" type="text" id="wallPost" value="Type here" size="50" maxlength="400" align="middle">
										<input type="submit" name="post" id="post" value="Submit">
									</form>

									<table border="0">

										<?
										 $sql1="select leaguename, teamname, post, posttime from leaguewall where leaguename='$leaguename' order by posttime desc ";
										$i=0;
										$result = mysqli_query($conn,$sql1) ;
										while( $row = mysqli_fetch_array( $result ) )
										{
											$teamname[$i]=$row[1];
											$post[$i]=$row[2];
											?>
											<tr> <td><font face="Lucida Console, Monaco, monospace" size="-1">
											<? echo $teamname[$i] ; echo "::"?></font><font face="Comic Sans MS, cursive" size="-1">
											<?echo $post[$i] ;?>	</font></td></tr>
										<?$i++;

										}
										?>
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

<script type="text/javascript">
function call_leaguestanding(){
   window.location.assign('LeaguePointsTable.php');//there are many ways to do this
}
</script>
<script type="text/javascript">
function confirmPutUpDraws() {
    var ask = window.confirm("Are you sure your league has enough teams to put up league draws?");
    if (ask) {
        window.location.href = "NewLeagueDraw.php";
    }
}
</script>
<script type="text/javascript">
function confirmRandomAlloc() {
    var ask = window.confirm("Are you sure you want to Allocate players to all teams randomly?");
    if (ask) {
        window.location.href = "RandomAlloc.php";
    }
}
</script>

</body>

</html>
