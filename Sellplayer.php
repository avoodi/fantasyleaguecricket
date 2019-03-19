<?

session_start();
$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$teamname=$_SESSION['teamname'];
$iplday=$_SESSION['iplday'];

include "dbConnect.php";
global $conn;
// Create connection
//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if ($conn == false) {
  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}

$selectedcount=0;

$sql2 = "select biddingstatus from leaguerules  where leaguename='$leaguename'";
$result = mysqli_query($conn,$sql2) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $biddingstatus=$row[0];
}
mysqli_free_result($result);

$action=$_POST['specialaction'];
echo "action is " . $action;
if(!empty($_POST)) {
   if(count($_POST['chkSelGroup']) > 0 && !empty($_POST['chkSelGroup'][0])) {
       foreach($_POST['chkSelGroup'] as $key => $checked) {
          $id = $_POST['chkSelGroup'][$key];
          echo "id is ".$id." and key ".$key ."</br>";
          $pid[$selectedcount]=$id;
          $selectedcount++;
          // rest of the data and processings
       }
   }
   $costofsoldplayers=0;
   if ( $selectedcount >0) {
     //we need to adjust/increase the virtualpp and reduce the count ofplayers for this teams, set owner team to null bidsoldynto 'N' and also mark currenthighestbid to reserve Price
     for ($i=0; $i<$selectedcount ; $i++) {
        $sql="select currenthighestbid from leagueauctionresults where leaguename='$leaguename' and pid=$pid[$i]";
        $result = mysqli_query($conn,$sql) ;
        while( $row = mysqli_fetch_array( $result ) )
        {
          $costofsoldplayers=$costofsoldplayers+$row[0];
        }
        mysqli_free_result($result);
     }
     $sqlupdt="update leagueteamsdetails set numberofplayers=numberofplayers-$selectedcount , virtualpurchasepower=virtualpurchasepower+$costofsoldplayers where leaguename='$leaguename' and teamname='$teamname' ";
     //echo $sqlupdt;
     if(! mysqli_query($conn,$sqlupdt) )
       {
         die('error sqlupdt');
       }
      for ($i=0; $i<$selectedcount ; $i++) {
          $sqlupdt="update leagueauctionresults set bidsoldyn='N' , ownerteam = null where leaguename='$leaguename' and pid=$pid[$i]";
echo $sqlupdt;
          if(! mysqli_query($conn,$sqlupdt) )
            {
              die('error sqlupdt 2');
            }
          $sqldel="delete from selectedplayers where leaguename='$leaguename' and pid=$pid[$i] and iplday>$iplday" ;
          if(! mysqli_query($conn,$sqldel) )
            {
              die('error sqldel');
            }
        }
   }
}

$playercount=0;
$sql="select pid, playername,currenthighestbid from leagueauctionresults where leaguename='$leaguename' and ownerteam='$teamname' ";
//echo $sql . "</br>";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $pid[$playercount]=$row[0];
  $playername[$playercount]=$row[1];
  $costofplayer[$playercount]=$row[2];

  $playercount++;
}
mysqli_free_result($result);
//for the above players get details from playermst

for ($i=0 ; $i<$playercount ; $i++){

  $sql1="select pid, playername,iplteam,score,numberof4,numberof6,numberofcatches,numberofrunouts,manofthematch,
wickets,points,speciality from playermst where pid=$pid[$i] ";
  //echo $sql1 ."</br>";
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
<title>Team Details</title>
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
    <h3 class="w3_inner_tittle two">
      Select the player you want to get rid off :<? echo $todayIPLmatch ; ?>
      <Form name="LAYOUTFORM" action="Sellplayer.php" method="POST">

      <table id="table">
          <thead>
              <tr style="font-size: 11px;">
    <th> SrNo</th>
    <th>PID</th>
    <th>PlayerName</th>
    <th>Speciality</th>
    <th>You Paid</th>
    <th>Plays for</th>
    <th>Total Points</th>
    <th>Total Runs</th>
    <th>Total 4s</th>
    <th>Total 6s</th>
    <th>Total Wickets</th>
    <th>Total Catches</th>
    <th>Total Runouts</th>
      </tr>
    </thead>
<tbody> <!-- entire while loop to show all rows -->
  <?
  for ($i=0 ; $i<$playercount ; $i++) {
  ?>
  <tr>
    <td class="text-center"> <? echo $i+1 ; ?></td>
    <td class="text-center"> <? echo $pid[$i] ; ?> </td>
    <td><input type="checkbox" name="chkSelGroup[]" VALUE="<? echo $pid[$i]; ?>" un-checked onClick="document.LAYOUTFORM.btnSave.disabled=false;">
      <? echo $playername[$i]; ?></td>
      <td > <? echo $PM_speciality[$i]; ?></td>
      <td class="text-center"> <? echo $costofplayer[$i]; ?></td>
    <td class="text-center"><? echo $PM_iplteam[$i] ;?></td>
    <td class="text-center"><? echo $PM_points[$i] ;?></td>
    <td class="text-center"><? echo $PM_score[$i]; ?></td>
    <td class="text-center"><? echo $PM_numberof4[$i]; ?></td>
    <td class="text-center"><? echo $PM_numberof6[$i]; ?></td>
    <td class="text-center"><? echo $PM_wickets[$i]; ?></td>
    <td class="text-center"><? echo $PM_numberofcatches[$i]; ?></td>
    <td class="text-center"><? echo $PM_umberofrunouts[$i]; ?></td>
  </tr>
<? } ?>
</tbody>
</table>

<? if ($biddingstatus=="Closed") { ?>
  <div class="row text-center" style="margin-top: 30px;">
      <button type="submit" value="SubmitTeam" name="btnSave" class="btn btn-xs btn-success" onClick="return callforsave(<? echo $i ;?>);">Submit Team</button>
  </div>
<? } ?>
<? if ($biddingstatus!=="Closed") { ?>
  <div class="row text-center" style="margin-top: 30px;">
      <h4 style="color:red;">This page can be used only after Bidding is Complete</h4>
  </div>
<? } ?>
</form>
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
            window.onload = function() {

    el = document.getElementsByTagName('html')[0];
    el.style.overflow = "scroll";

  };
        </script>

        <script src="NewUI/js/jquery.nicescroll.js"></script>
        <script src="NewUI/js/scripts.js"></script>

        <script type="text/javascript" src="NewUI/js/bootstrap-3.1.1.min.js"></script>

        <script language="javascript">
        var cnt =0;

        	function callforsave(selcount)
        	{
         //return false;
          //  alert("in here ");
        	  alert("ok you have sold one of your players");
        		document.LAYOUTFORM.specialaction.value="sell";
        		document.LAYOUTFORM.method = "POST";
        		document.LAYOUTFORM.action = "Sellplayer.php";
        		document.LAYOUTFORM.submit();
        		return true;
        	}



        </script>

</body>

</html>
