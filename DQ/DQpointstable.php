<?
// points table and other common info for league
session_start();
include "dbConnect.php";
global $conn;

session_start();
$uname=$_SESSION['uname'];
$pwd=$_SESSION['pwd'];
$groupname=$_SESSION['groupname'];
$grouppwd=$_SESSION['grouppwd'];
//echo $uname, $groupname;
	// Check connection
	if ($conn == false) {
		echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
	}

$i=0;
$sql= "select  username,  sum(score) points,count(*) count , sum(score)/count(*) as avgcount  from DQanswersdetails where groupname='$groupname' and score is not null group by username order by avgcount desc";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $tname[$i]=$row[0];
  $totalpoints[$i]=$row[1];
  $noofquestions[$i]=$row[2];
    $i++;
}
mysqli_free_result($result);
$teamsinleague=$i;
//echo $teamsinleague;
$i=0;
$sql= "select ad.username,ad.iplday,ad.groupname,ad.result, am.answer as realanswer,
 (select question from DQMaster dqm where dqm.qid=ad.qid and dqm.groupname='$groupname') as question,
(select distinct matchstr from iplschedule i where ad.iplday=i.iplday) as IPLMatch
from DQanswersdetails ad, DQanswerMaster am
where ad.qid=am.qid and ad.iplday=am.iplday and ad.groupname='$groupname' and username='$uname'";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$iplmatch[$i]=$row[6];
	$question[$i]=$row[5];
	$youranswer[$i]=$row[3];
	$realanswer[$i]=$row[4];
	$i++;
}
$questionCompare=$i;
?>
<html>
<head>
	<link href="../NewUI/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" type="text/css" href="../NewUI/css/table-style.css" />
	<link rel="stylesheet" type="text/css" href="../NewUI/css/basictable.css" />
	<link href="../NewUI/css/component.css" rel="stylesheet" type="text/css" media="all" />
	<link href="../NewUI/css/style_grid.css" rel="stylesheet" type="text/css" media="all" />
	<link href="../NewUI/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- font-awesome-icons -->
	<link href="../NewUI/css/font-awesome.css" rel="stylesheet">

	<!--SCRIPT LANGUAGE="JAVASCRIPT" SRC="images/sorttable.js"></SCRIPT -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>: Leaderboard : </title>

</head>
<body>
	<!-- banner -->
	<div class="wthree_agile_admin_info">
			<div class="w3_agileits_top_nav">
					<ul id="gn-menu" class="gn-menu-main">

							<!-- //nav_agile_w3l -->
							<li class="second logo admin">
									<h1>
											<a href="DQLandingPg-New.php">
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
											<h3 class="w3_inner_tittle two">Leaderboard of your group </h3>

											<table id="table">
												<thead>
<tr>
  <th align="center">User Name</th>
  <th align="center">TotalPoints</th>
  <th align="center"># of answers</th>
  <th align="center">Average points </th>
</tr>
</tread>
<?
for ($i=0;$i<$teamsinleague ; $i++) {
?>
<tbody>

  <tr >
    <td class="text-center"><? echo $tname[$i];?> </td>
    <td class="text-center"><? echo $totalpoints[$i];?> </td>
    <td class="text-center"><? echo $noofquestions[$i];?> </td>
		<? if ($totalpoints[$i] >0) {
			 $avgPts=$totalpoints[$i]/$noofquestions[$i] ;
		 }
		 else {
			 $avgPts=0;
		 }
		  ?>
    <td class="text-center"><? echo round($avgPts,1) ; ?> </td>
	</tr>

<?
}
?>

</tbody>
</table>
<h3 class="w3_inner_tittle two">Here are your answers in the past </h3>
<table id="table">
	<thead>
<tr>
<th align="center">IPL Match</th>
<th align="center">Question</th>
<th align="center">Your Answer</th>
<th align="center">Actual Answer </th>
</tr>
</tread>
<?
for ($i=$questionCompare-1;$i>0 ; $i--) {
?>
<tbody>

<tr >

<td class="text-center"><? echo $iplmatch[$i];?> </td>
<td class="text-center"><? echo $question[$i];?> </td>
<td class="text-center"><? echo $youranswer[$i];?> </td>
<td class="text-center"><? echo $realanswer[$i];?> </td>
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

<script type="text/javascript" src="../NewUI/js/jquery-2.1.4.min.js"></script>
<script src="../NewUI/js/modernizr.custom.js"></script>
<script src="../NewUI/js/classie.js"></script>
<!-- tables -->

<script type="text/javascript" src="../NewUI/js/jquery.basictable.min.js"></script>
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
<script src="../NewUI/js/scripts.js"></script>

<script type="text/javascript" src="../NewUI/js/bootstrap-3.1.1.min.js"></script>



</body>
</html>
