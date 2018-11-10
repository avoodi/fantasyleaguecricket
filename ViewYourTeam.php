<?

session_start();
$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$pass=$_SESSION['pass'];
$teamname=$_SESSION['teamname'];

$servername = "localhost:3306";
$dbusername = "fanta_avad";
$dbpassword = "FLeague@2018";
$dbname="fantas10_avad";
// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if ($conn == false) {
  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}

$playercount=0;
$sql="select pid, playername from leagueauctionresults where leaguename='$leaguename' and ownerteam='$teamname' ";
//echo "first ".$sql."</br>";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $pid[$playercount]=$row[0];
  $playername[$playercount]=$row[1];
  $playercount++;
}
mysqli_free_result($result);
//for the above players get details from playermst
//echo $playercount ;
for ($i=0 ; $i<$playercount ; $i++){

  $sql1="select pid, playername,iplteam,score,numberof4,numberof6,numberofcatches,numberofrunouts,manofthematch,
  wickets,points,speciality from playermst where pid=$pid[$i] ";
  //echo $sql1."</br>";
  $result = mysqli_query($conn,$sql1) ;
  while( $row = mysqli_fetch_array( $result ) )
  {
  $PM_pid[$i]=$row[0];
  $PM_playername[$i]=$row[1];
  $PM_iplteam[$i]=$row[2];
  $PM_score[$i]=$row[3];
  $PM_numberof4[$i]=$row[4];
  $PM_numberof6[$i]=$row[5];
  $PM_numberofcatches[$i]=$row[6];
  $PM_umberofrunouts[$i]=$row[7];
  $PM_manofthematch[$i]=$row[8];
  $PM_wickets[$i]=$row[9];
  $PM_points[$i]=$row[10];
  $PM_speciality[$i]=$row[11];

  }
  mysqli_free_result($result);
}
mysqli_free_result($result);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Team Details</title>
<link href="NewUI/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" type="text/css" href="NewUI/css/table-style.css" />
<link rel="stylesheet" type="text/css" href="NewUI/css/basictable.css" />
<link href="NewUI/css/component.css" rel="stylesheet" type="text/css" media="all" />
<link href="NewUI/css/style_grid.css" rel="stylesheet" type="text/css" media="all" />
<link href="NewUI/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- font-awesome-icons -->
<link href="NewUI/css/font-awesome.css" rel="stylesheet">


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
                        <h3 class="w3_inner_tittle two">Teams Performance</h3>

                        <table id="table">
                            <thead>
                                <tr>
    <th class="text-center"> SrNo</td>
    <th class="text-center">PlayerName</td>
    <th class="text-center">Speciality</td>
    <th class="text-center">Plays for</td>
    <th class="text-center">Total Points</td>
    <th class="text-center">Total Runs</td>
    <th class="text-center">Total 4s</td>
    <th class="text-center">Total 6s</td>
    <th class="text-center">Total Wickets</td>
    <th class="text-center">Total Catches</td>
    <th class="text-center">Total Runouts</td>
  </tr>
</thead>
<tbody> <!-- entire while loop to show all rows -->
<?
  for ($i=0 ; $i<$playercount ; $i++) {
  ?>
  <tr>
    <td> <? echo $i+1 ; ?></td>
    <td><? echo $playername[$i]; ?></td>
    <td><?echo $PM_speciality[$i]; ?></td>
    <td><?echo $PM_iplteam[$i]; ?></td>
    <td><? echo $PM_points[$i]; ?></td>
    <td><? echo $PM_score[$i]; ?></td>
    <td><? echo $PM_numberof4[$i]; ?></td>
    <td><? echo $PM_numberof6[$i]; ?></td>
    <td><? echo $PM_wickets[$i]; ?></td>
    <td><? echo $PM_numberofcatches[$i]; ?></td>
    <td><? echo $PM_umberofrunouts[$i]; ?></td>
  </tr>
<? } ?>
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
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<script src="js/classie.js"></script>
<!-- tables -->

<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
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

<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>

<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>


</body>
</html>
