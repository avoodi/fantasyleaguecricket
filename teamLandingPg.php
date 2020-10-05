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

	//echo "leaguename is ". $leaguename " and owner name is " . $teamownername;

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
	<title>Team</title>
	<link rel="icon" href="assets/dist/img/favicon.ico" type="image/ico" sizes="16x16">
	<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/dist/css/style.css" rel="stylesheet">
	<link href="assets/dist/css/colors.css" rel="stylesheet">
</head>

<body class="bg-fantasy">
	<!-- Navigation -->
	<?php include 'navbar.php';?>


	<!-- Page Content -->
	<div class="container bg-white p-3 pt-1 ">
		<!-- <h1 class="my-4">Teams</h1> -->

		<!-- Section -->
		<div class="row ">
			<div class="col-lg-3 col-3 mb-4">
				<div class="card h-100 bg-danger">
					<h6 class="card-header text-white display">Team</h6>
					<div class="card-footer text-right">
					<span class="badge bg-white">
						<? echo $teamname; ?></span>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-3 mb-4">
				<div class="card h-100 bg-warning">
					<h6 class="card-header text-white display">League</h6>
					<div class="card-footer text-right">
					<span class="badge bg-white">
						<? echo $leaguename; ?></span>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-3 mb-4">
				<div class="card h-100 bg-primary">
					<h6 class="card-header text-white display">Amount</h6>
					<div class="card-footer text-right">
						<span class="badge bg-white">
						<?echo $teamvirpp; ?></span>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-3 mb-4">
				<div class="card h-100 bg-success">
					<h6 class="card-header text-white display">Players</h6>
					<div class="card-footer text-right">
					<span class="badge bg-white">
						<?echo $numberofplayers; ?></span>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->

		<!-- Section -->
		<div class="row">
			<div class="col-lg-8">
				<!-- <h6 class="text-danger"><u> Responsibility</u></h6> -->

				<? if ($isOwner=='Yes') {?>
					<div class="blockquote border border-dangers rounded p-2">
						<p class="m-0 text-danger"> <small>To get the league started quickly follow below steps -</small></p>
						<ul class="list text-muted">
							<li> invite few friends (any number >4 to 14 is good we say) </li>
							<li> after you have enough teams go to league rules page and change rules if required </li>
							<li> on league rules page , check what the 'Current Bidding Status' says </li>
							<li> if your league wants to go for bidding -the value should be 'started-in progress'</li>
							<li> fix some time window for bidding and communicate with other teams; and change the value to 'bidding over' whenever you want to close bidding </li>
							<li> if your league does not want to go for bidding then you can click on the 'Auto allocation' button </li>
							<li> after bidding is over OR auto allocation is done, then put up league draws by clicking 'Create League Schedule' button </li>
							<li> thats it your league is all set now </li>
						</ul>
					</div>
				<? } ?>

			</div>
			<div class="col-lg-4">
				<div class="row mb-1">
					<div class="col-lg-12 text-center">
						<? if ($isOwner=='Yes') { ?>
							<? if ($drawdone =='N') { ?>
								<p class="m-0"> <small class="text-dark"> DO NOT click on :</small> </p>
								<a class="btn btn-sm btn-danger p-1" href="#" onClick="confirmPutUpDraws()">Create League Schedule(Draws)</a></br>
								<a class="btn btn-sm btn-danger p-1 mt-2" href="#" onClick="confirmRandomAlloc()">Auto Allocation</a>
							<? } ?>
						<? } ?>
					</div>
				</div>
				<div class="row p-3">
					<? if ($isOwner=='No') {?>
						<? if ($drawdone =='N') {?>
							<code class="text-monospace text-danger bg-light p-1 mb-1"> <small>Match schedule for your team will appear below, after your league has enough teams and league creator has clicked on 'create draws' ! </small> </code>
							<code class="text-monospace text-danger bg-light p-1"> <small> May be your league is still bidding for players ? Talk to the league creator ; and should you need any help/have questions , do write to <a href="mailto:avoodi@gmail.com" class="text-success"> avoodi@gmail.com </a></small></code>
						<? } ?>
					<? } ?>
				</div>



			</div>
		</div>
		<!-- /.row -->


		<hr>
		<!-- Section -->
		<div class="row p-3 mb-2">
			<h5 class="text-capitalize text-danger">Match Schedule for your team</h5>
			<table id="table" class="table table-sm table-light table-bordered border-danger text-center">
				<thead class="bg-fantasy text-danger" style="font-size:small">
					<tr>
						<th>MatchDate</th>
						<th>Team1</th>
						<th>Team2</th>
						<th>Score</th>
						<th>Winner</th>
						<th>IPL Matchup</th>
						<th></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?
						for ($i=0; $i<$count ; $i++) {
							if ($team1name[$i]==$teamname || $team2name[$i]==$teamname) {
					?>
					<tr>
						<td>
							<? echo $iplmatchdate[$i]; ?>
						</td>
						<? if ($team1name[$i] == $teamname) { ?>
							<td>
								<a href="SelectYourTeam.php?mnum=<? echo $iplmatchnum[$i] ; ?>&omn=<?echo $ourmatchnum[$i]; ?>">
									<strong><? echo $team1name[$i]; ?></strong>
								</a>
							</td>
							<td>
								<a href="ViewOtherTeam.php?nm=<? echo $team2name[$i] ?>&mnum=view">
									<? echo $team2name[$i] ;?>
								</a>
							</td>
						<? } ?>
						<? if ($team2name[$i] == $teamname) { ?>
							<td>
								<a href="ViewOtherTeam.php?nm=<? echo $team1name[$i] ?>&mnum=view">
									<? echo $team1name[$i] ;?></a>
							</td>
							<td>
								<a href="SelectYourTeam.php?mnum=<? echo $iplmatchnum[$i] ; ?>&omn=<?echo $ourmatchnum[$i]; ?>"><strong>
										<? echo $team2name[$i]; ?></strong></a>
							</td>
						<? } ?>
						<td>
							<? echo $score[$i] ; ?>
						</td>
						<td>
							<strong><? echo $whowon[$i] ; ?></strong>
						</td>
						<td>
							<?echo $iplmatchs[$i] ;?>
						</td>
					</tr>
					<? }
					} ?>
				</tbody>
			</table>
		</div>
		<hr>
		<div class="row mb-5 p-3">
			<div class="col-lg-4">
				<h6 class="text-danger"> Write League Wall</h6>
				<form name="form1" class="w-100" method="post" action="wallpost.php">
					<textarea name="wallPost"  id="wallPost" class="form-control form-custom-control-inline mb-3" cols="30" rows="5" maxlength="400" placeholder="Enter text"></textarea>
					<button type="submit" class="btn btn-md btn-danger btn-block" name="post" id="post" value="Submit">Submit</button>
				</form>
			</div>
			<div class="col-lg-8">
			<h6 class="text-danger text-center"> League Wall Posts</h6>
				<?
					$sql1="select leaguename, teamname, post, posttime from leaguewall where leaguename='$leaguename' order by posttime desc ";
					$i=0;
					$result = mysqli_query($conn,$sql1) ;
					while( $row = mysqli_fetch_array( $result ) )
					{
						$teamname[$i]=$row[1];
						$post[$i]=$row[2];
				?>

						<blockquote class="blockquote text-left border border-dangers rounded p-1">
							<p class="mb-0 text-muted" style="font-size: 0.8rem;"><?echo $post[$i] ;?> Lorem ipsum, dolor sit amet consectetur adipisicing elit. Unde esse voluptate iste debitis dicta excepturi cumque, molestiae distinctio dolorem exercitationem voluptatibus voluptatem, aperiam sequi veniam similique accusamus rerum mollitia eum. </p>
							<footer class="blockquote-footer text-right"><cite class="text-danger" style="font-size: 1.2rem;"><? echo $teamname[$i] ; echo "::"?> Team Pune</cite></footer>
						</blockquote>
						<hr class="m-0">
				<?
						$i++;
					}
				?>
			</div>
		</div>
	</div>
	<!-- /.container -->

	<!-- Footer -->
	<?php include 'footer.php';?>

	<!-- Bootstrap core JavaScript -->
	<script src="assets/dist/js/jquery/jquery.min.js"></script>
	<script src="assets/dist/js/bootstrap/bootstrap.bundle.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
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
	<script type="text/javascript">
		function call_leaguestanding() {
			window.location.assign('LeaguePointsTable.php'); //there are many ways to do this
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
