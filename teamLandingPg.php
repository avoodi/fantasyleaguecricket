<!DOCTYPE html>
<?

include "dbConnect.php";
global $conn;

session_start();
$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$pass=$_SESSION['pwd'];
$teamname=$_SESSION['teamname'];
$teamownername=$_SESSION['teamownername'];
$iplday=$_SESSION['iplday'];

echo $teamownername;

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
//$sql="select distinct(ld.ourmatchnum),ld.iplmatchnum,ld.team1name, ld.team2name, ip.matchstr ,ip.matchdate,  ifnull(ld.score,'-')score, ifnull(ld.whowon,'-') whowon from iplschedule ip , leaguedraw ld where ld.leaguename='$leaguename' and ( ld.team1name='$teamname' or ld.team2name='$teamname')and ld.iplmatchnum=ip.iplday ";
$sql="select ld.ourmatchnum,ld.iplmatchnum,ld.team1name, ld.team2name, ifnull(ld.score,'-') score, ifnull(ld.whowon,'-') whowon,ld.actualiplmatch  from  leaguedraw ld where ld.leaguename='$leaguename' ";
//echo $sql ;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$iplmatchnum[$count]=$row[1];
	$ourmatchnum[$count]=$row[0];
	$team1name[$count]=$row[2];
	$team2name[$count]=$row[3];
	$iplmatchs[$count]=$row[6];
//	$iplmatchdate[$count]=date_format($row[6],"yyyy-mm-dd");
	$score[$count]=$row[4];
	$whowon[$count]=$row[5];
	$count++;

}
mysqli_free_result($result);

$isOwner='No';
$sql="select leaguecreatorname,drawdone from league_mst where leaguename='$leaguename'";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$Owner=$row[0];
	$drawdone=$row[1];
}
//echo "league is " .$leaguename. " and teamowner is ". $isOwner;

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
echo $sqlupdt;
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
							<button type="button" class="btn btn-xs btn-info" onClick="Javascript:window.location.href = 'NewLeagueDraw.php';">Create League Schedule(draws) </button>
							<button type="button" class="btn btn-xs btn-success" onClick="Javascript:window.location.href = 'RandomAlloc.php';">Auto Allocation</button>

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
	<p> To get the league started quickly, invite few friends (any number >4 to 14 is good we say) </p>
	<p> And go for bidding(switch it on in league rules page) or auto allocation(do not click on auto allocate button otherwise) of players. </p>
	<p>And then put up league draws(do this only after teams are set with players either via bidding or auto allocate) </p>
	<p> pl email avoodi@gmail.com if you need any help </p>
<? } ?>
<? if ($isOwner=='No') {?>
	<? if ($drawdone =='N') {?>
			<h3 class="w3_inner_tittle two">
			<p> Looks like your league has not started playing matches yet! </p>
			<p> Is the bidding, player allocation over? Talk to the league creator ; and should you need any help/have questions , do write to avoodi@gmail.com </p>
		<? } ?>
<? } ?>
				<div class="agile-tables">
					<div class="w3l-table-info agile_info_shadow">
						<h3 class="w3_inner_tittle two">Match Schedule for your team</h3>
						<table id="table">
							<thead>
								<tr>
									<th>Match#</th>
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
										<td><? echo $ourmatchnum[$i] ; ?></td>
										<? if ($team1name[$i] == $teamname) { ?>
										<td> <a href="SelectYourTeam.php?mnum=<? echo $iplmatchnum[$i] ; ?>"><strong><? echo $team1name[$i]; ?></strong></a> </td>
										<td> <a href="ViewOtherTeam.php?nm=<? echo $team2name[$i] ?>&mnum=view"><? echo $team2name[$i] ;?></a> </td>
									<? } ?>
									<? if ($team2name[$i] == $teamname) { ?>
										<td> <a href="ViewOtherTeam.php?nm=<? echo $team1name[$i] ?>&mnum=view"><? echo $team1name[$i] ;?></a> </td>
										<td> <a href="SelectYourTeam.php?mnum=<? echo $iplmatchnum[$i] ; ?>"><strong><? echo $team2name[$i]; ?></strong></a> </td>
									<? } ?>
										<td> <? echo $score[$i] ; ?> </td>
										<td><strong> <? echo $whowon[$i] ; ?></strong></td>
										<td ><?echo $iplmatchs[$i] ;?></td>
								</tr>
							<? }
								}	?>

						<!--		<tr>
										<td>7</td>
										<td>2</td>
										<td> <a href="#"><strong>av</strong></a> </td>
										<td> <a href="#">ne</a> </td>
										<td> 10 - 77 </td>
										<td><strong> ne</strong></td>
										<td >RCB-KXP</td>
								</tr>
								<tr>
										<td>7</td>
										<td>2</td>
										<td> <a href="#"><strong>av</strong></a> </td>
										<td> <a href="#">ne</a> </td>
										<td> 10 - 77 </td>
										<td><strong> ne</strong></td>
										<td >RCB-KXP</td>
								</tr>
								<tr>
										<td>7</td>
										<td>2</td>
										<td> <a href="#"><strong>av</strong></a> </td>
										<td> <a href="#">ne</a> </td>
										<td> 10 - 77 </td>
										<td><strong> ne</strong></td>
										<td >RCB-KXP</td>
								</tr>
								<tr>
										<td>7</td>
										<td>2</td>
										<td> <a href="#"><strong>av</strong></a> </td>
										<td> <a href="#">ne</a> </td>
										<td> 10 - 77 </td>
										<td><strong> ne</strong></td>
										<td >RCB-KXP</td>
								</tr><tr>
										<td>7</td>
										<td>2</td>
										<td> <a href="#"><strong>av</strong></a> </td>
										<td> <a href="#">ne</a> </td>
										<td> 10 - 77 </td>
										<td><strong> ne</strong></td>
										<td >RCB-KXP</td>
								</tr><tr>
										<td>7</td>
										<td>2</td>
										<td> <a href="#"><strong>av</strong></a> </td>
										<td> <a href="#">ne</a> </td>
										<td> 10 - 77 </td>
										<td><strong> ne</strong></td>
										<td >RCB-KXP</td>
								</tr>

-->
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
</body>

</html>
