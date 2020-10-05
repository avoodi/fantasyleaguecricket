<?
// points table and other common info for league
session_start();
	$username=$_SESSION['username'];
	$teamname=$_SESSION['teamname'];
	$teamowner = $_SESSION['username'];
	$leaguename= $_SESSION['leaguename'];

	// Create connection
	include "dbConnect.php";
	global $conn;

//	$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
	// Check connection
	if ($conn == false) {
		echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
	}

$i=0;
//$sql="select teamname, teamownername,ifnull(numberofplayers,0),ifnull(totalteamscore,0),ifnull(matcheswon,0), matcheslost,matchesdrawn, points  from leagueteamsdetails where leaguename='$leaguename'";

$sql="select teamname, teamownername,ifnull(numberofplayers,0),ifnull(totalteamscore,0),ifnull(matcheswon,0),
matcheslost,matchesdrawn, points, ifnull(totalteamscore,0)/(ifnull(matcheswon,0)+matcheslost+matchesdrawn) as avgscore  from leagueteamsdetails where leaguename='$leaguename' order by points desc, avgscore desc";

$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $tname[$i]=$row[0];
  $townername[$i]=$row[1];
  $noofplayers[$i]=$row[2];
  $totalscore[$i]=$row[3];
  $matcheswon[$i]=$row[4];
  $matcheslost[$i]=$row[5];
  $matchesdrawn[$i]=$row[6];
  $points[$i]=$row[7];
	$avgscore[$i]=$row[8];
  $i++;
}
mysqli_free_result($result);
$teamsinleague=$i;

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

	<!--SCRIPT LANGUAGE="JAVASCRIPT" SRC="images/sorttable.js"></SCRIPT -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>: League  Points Table : </title>

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
											<h3 class="w3_inner_tittle two">Points/League Standing table </h3>

											<table id="table">
												<thead>
<tr>
  <th align="center">Teamname</th>
  <th align="center">TeamOwner</th>
  <th align="center">Points</th>
  <th align="center"># of Wins</th>
  <th align="center"># of Losses </th>
  <th align="center"># of draw </th>
	<th align="center">Average score</th>
</tr>
</tread>
<?
for ($i=0;$i<$teamsinleague ; $i++) {
?>
<tbody>

  <tr >
    <td class="text-center"><? echo $tname[$i];?> </td>
    <td class="text-center"><? echo $townername[$i];?> </td>
    <td class="text-center"><? echo $points[$i];?> </td>
    <td class="text-center"><? echo $matcheswon[$i];?> </td>
    <td class="text-center"><? echo $matcheslost[$i];?> </td>
    <td class="text-center"><? echo $matchesdrawn[$i];?> </td>
		<td class="text-center"><? echo $avgscore[$i]; ?> </td>
  </tr>
<?
}
?>

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
