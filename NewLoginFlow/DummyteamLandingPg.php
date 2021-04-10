<!DOCTYPE html>
<?
	session_start();
	include "dbConnect.php";
	global $conn;

	$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
	$pass=$_SESSION['pwd'];
	$iplday=$_SESSION['iplday'];
  $yourleaguename=$_SESSION['yourleaguename']

?>
<html>

<head>
	<title>Team</title>
	<link rel="icon" href="../assets/dist/img/favicon.ico" type="image/ico" sizes="16x16">
	<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/dist/css/style.css" rel="stylesheet">
	<link href="../assets/dist/css/colors.css" rel="stylesheet">
</head>

<body class="bg-fantasy">
	<!-- Navigation -->
	<?php include '../navbar.php';?>
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
						<? foreach ($yourleaguename as $value) {
              echo $leaguename."\n";
            } ?>
          </span>
					</div>
				</div>
			</div>
		</div>

		<hr>
		<!-- Section -->
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
