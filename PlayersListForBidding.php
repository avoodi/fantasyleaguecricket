<?
    	session_start();
		$username=$_SESSION['username'];
		$team=$_SESSION['teamname'];
		$teamowner = $_SESSION['username'];
		$leaguename= $_SESSION['leaguename'];

		//  echo "all session " . $username . " and team " . $team . " and owner " . $teamowner . " and league ". $leaguename . "<br/>";
		include "dbConnect.php";
		global $conn;

		// Create connection
		//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
		// Check connection
		if ($conn == false) {
		echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
		}
		//is null for virtual purchase power is to be removed

		$sql2 = "select biddingstatus from leaguerules  where leaguename='$leaguename'";
		$result = mysqli_query($conn,$sql2) ;
		while( $row = mysqli_fetch_array( $result ) )
		{
			$biddingstatus=$row[0];
		}
		mysqli_free_result($result);

		if(isset($_POST['nm'])) {
			$playername=$_POST['nm'];
			$bid=$_POST['urBId'];
			$reserveprice=$_POST['reserveprice'];
			$prevowner=$_POST['prevowner'];
			//echo "prev owner is ".$prevowner;
			//this means this prog is called from addurbid php , so we need to insert into bidding details and update leagueteamdetails tablea

			$sqlins="insert into biddingdetails (playername,leaguename, biddingteam, reserveprice, biddingamount ,roundnumber)  values ('$playername', '$leaguename', '$team',$reserveprice,$bid,1) ";
			//echo $sqlins . "</br>";
			if(! mysqli_query($conn,$sqlins) )
			{
				die('error sqlinsert');
			}

			$sqlupdt2="update leagueauctionresults set currenthighestbid=$bid ,ownerteam='$team' where leaguename='$leaguename' and playername='$playername' ";
			//echo $sqlins . "</br>";
			if(! mysqli_query($conn,$sqlupdt2) )
				{
				die('error sqlupdate2');
				}

		}

		$countofplayers=0;
		$totalbidamt=0;
		$virpp=0;

		$sql="select count(*) from leagueauctionresults where leaguename='$leaguename' and ownerteam='$team'";
		$result = mysqli_query($conn,$sql) ;
		while( $row = mysqli_fetch_array( $result ) )
		{
			$countofplayers=$row[0];
		}
		mysqli_free_result($result);


		$sql="select ifnull(sum(currenthighestbid),0) from leagueauctionresults where leaguename='$leaguename' and ownerteam='$team'";
		$result = mysqli_query($conn,$sql) ;
		while( $row = mysqli_fetch_array( $result ) )
		{
			$totalbidamt=$row[0];
			$virpp=15000000-$totalbidamt;
		}
		mysqli_free_result($result);

		//    $sqlupdt="UPDATE leagueteamsdetails SET Currentbidamount= ifnull(Currentbidamount,0)+ $bid , virtualpurchasepower= virtualpurchasepower - $bid, numberofplayers=$countofplayers  WHERE leaguename = '$leaguename' and teamname='$team' ";
		//echo  "in if " . $bid . "and ". $reserveprice . "and " . $sqlupdt . "</br>";
		$sqlupdt="update leagueteamsdetails set Currentbidamount=$totalbidamt , virtualpurchasepower=$virpp, numberofplayers=$countofplayers WHERE leaguename = '$leaguename' and teamname='$team' ";
		//echo $sqlupdt;
		if(! mysqli_query($conn,$sqlupdt) )
		{
			die('error sqlupdate');
		}
			//  $sqlupdt2="UPDATE leagueteamsdetails SET Currentbidamount= ifnull(Currentbidamount,0)- $bid , virtualpurchasepower= virtualpurchasepower + $bid, numberofplayers=numberofplayers-1  WHERE leaguename = '$leaguename' and teamname='$prevowner' ";
			//echo $sqlupdt2;
					//echo  "in if " . $bid . "and ". $reserveprice . "and " . $sqlupdt . "</br>";
			//          if(! mysqli_query($conn,$sqlupdt2) )
			//          {
			//          die('error sqlupdate2');
			//      }

		$sql1="select ifnull(t.virtualpurchasepower,0), ifnull(t.currentbidamount,0) currentbidamount , t.numberofplayers from leagueteamsdetails t where t.teamname= '$team' and t.leaguename='$leaguename' ";
		//echo $sql1 . "<br/>";
		$result = mysqli_query($conn,$sql1) ;
		while( $row = mysqli_fetch_array( $result ) )
		{
		$virtualpurchasepower=$row[0];
		$currentbidamount=$row[1];
		$numberofplayers=$row[2];
		}
		mysqli_free_result($result);


  ?>
<html>

<head>
	<title>Bidding</title>
	<link rel="icon" href="assets/dist/img/favicon.ico" type="image/ico" sizes="16x16">
	<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/dist/css/style.css" rel="stylesheet">
	<link href="assets/dist/css/colors.css" rel="stylesheet">
</head>

<body class="bg-fantasy">
	<!-- Navigation -->
	<?php include 'navbar.php'; ?>

	<!-- Page Content -->
	<div class="container bg-white p-3 pt-1">

		<div class="row text-center m-0">
			<? if ($biddingstatus =="Closed") {?>
			<div class="alert alert-danger text-danger w-100" role="alert">
				Bidding IS OVER For This League , Pl check your players page (or playerpurchase page).
			</div>
<!--			<div class="alert alert-warning text-danger w-100" role="alert">
				Below list shows players which are not owned by any team in your league So they are available for 'individual purchase' OR can be 'auto allocated'(for this you need to talk to your leagues creator)...
			</div>
-->      
			<? } ;?>

			<? if ($biddingstatus=="Yet To Start") { ?>
			<div class="alert alert-warning text-danger w-100" role="alert">
				Bidding for your league is not activated yet.. pl contact league Creator..
			</div>
			<? } ;?>
			<? if ($biddingstatus=="Started-InProgress") { ?>
			<div class="alert alert-warning text-danger w-100" role="alert">
				Happy Bidding
			</div>
			<? } ;?>
		</div>

		<div class="row justify-content-md-center m-0">
			<div class="col col-lg-4">
				<div class="card text-white bg-danger mb-3">
					<div class="card-body text-center">
						<h5 class="card-title">Virtual Purchase Power</h5>
						<strong class="card-text">
							<? echo $virtualpurchasepower ?>
						</strong>
					</div>
				</div>
			</div>

			<div class="col col-lg-4">
				<div class="card text-white bg-success mb-3">
					<div class="card-body text-center">
						<h5 class="card-title">Current Bid Amount Total </h5>
						<strong class="card-text">
							<? echo $currentbidamount ?>
						</strong>
					</div>
				</div>
			</div>



		</div>


		<div class="row m-0 pb-5 mb-5">
			<h5 class="text-capitalize text-danger">Players list for bidding</h5>
			<table class="table table-sm table-light table-bordered border-danger text-center" id="table">
				<form name="frmcricket" action="PlayersListForBidding.php" method="post">
					<thead class="bg-fantasy text-danger" style="font-size: small;">
						<tr>
							<th>Sr.No</th>
							<th>Player Name</th>
							<th>Speciality</th>
							<th>IPL Team</th>
							<th>Reserve Price</th>
							<th>Current highest Bid</th>
							<th>Highest Bidder</th>
							<th>Your bid</th>
						</tr>
					</thead>
					<tbody>
						<?
							$i=1;
							$sql="select x.playername,x.iplteam,x.speciality, x.reserveprice,ifnull(t.currenthighestbid,x.reserveprice)currenthighestbid, t.ownerteam from leagueauctionresults  t, playermst x where t.playername = x.playername and (ifnull(t.leaguename,'X')='$leaguename'  or t.leaguename is null)   ";
							//echo $sql . "<br/>";
							$result = mysqli_query($conn,$sql) ;
							while( $row = mysqli_fetch_array( $result ) )
							{
							//echo "Values are " . $row[0] ." and ". $row[1]." and ". $row[2]." and ". $row[3]." and ". $row[4]." and ". $row[5] . "<br\>";
						?>
						<tr class="header1">
							<td align="center">
								<? echo $i ?>
							</td>
							<td>
								<? echo $row[0] ?>
							</td>
							<td>
								<? echo $row[1] ?>
							</td>
							<td>
								<? echo $row[2] ?>
							</td>
							<td>
								<? echo $row[3] ?>
							</td>
							<td><input type="text" value="<? echo $row[4]; ?>" class="form-control form-control-sm" name="currbid" size="15" readonly="true"></td>
							<td>
								<? echo $row[5] ?>
							</td>
							<? if ($biddingstatus == "Started-InProgress" ) { ?>
							<td><a href="addurbid.php?nm=<? echo $row[0] ?>" onClick="return valid();">Your bid</a> </td>
							<? } ?>
							<? $i++; }  ?>
							<input type="hidden" name='numberofplayers' value="<? echo $numberofplayers ?>">
							<input type="hidden" name='nm' value="">
						</tr>
					</tbody>
				</form>
			</table>
		</div>

	</div>
	<!-- /.container -->

	<!-- Footer -->
	<?php include 'footer.php'; ?>
	<!-- Bootstrap core JavaScript -->
	<script src="assets/dist/js/jquery/jquery.min.js"></script>
	<script src="assets/dist/js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>

<script language="javascript">
	function valid(id) {

		if (parseInt(document.frmcricket.numberofplayers.value) >= 22) {
			alert("Sorry you already have enough players in your rooster, you may not bid more at this time.");
			//document.frmcricket.currbid.focus();
			return false;
		} else {
			//alert(id);
			window.document.frmcricket.target = "_self";
			window.document.frmcricket.action = 'addurbid.php';
			document.all("nm").value = id;
			window.document.frmcricket.submit();
		}
	}
	/* function chkval(id)
		{
		 var i
		 for(i=0; i<document.frmcricket.elements.length;i++)
		 {
			alert(document.frmcricket.elements[0].value);
		 }

		if((document.frmcricket.urbid[id].value) <= (document.frmcricket.currbid[id].value)) ;
			{
				 alert('HI');
			}
		} */
</script>
