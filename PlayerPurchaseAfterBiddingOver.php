<?
  session_start();
    $username=$_SESSION['username'];
    $team=$_SESSION['teamname'];
    $teamowner = $_SESSION['username'];
    $leaguename= $_SESSION['leaguename'];

// prog is called after bidding or random alloc is over..  so that teams can purchase available players..
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


//need to update the below because we are not/can not update bidsold field when bidding is on..
    $sqlupdt4="update leagueauctionresults set bidsoldyn='Y' where leaguename='$leaguename' and ownerteam is not null ";
      //echo $sqlins . "</br>";
      if(! mysqli_query($conn,$sqlupdt4) )
        {
          die('error sqlupdate2');
        }


if(isset($_POST['nm'])) {
  $playername=$_POST['nm'];
  $bid=$_POST['urBId'];
  $reserveprice=$_POST['reserveprice'];
  $prevowner=$_POST['prevowner'];
  $currtime=date('Y-m-d');
  //echo "prev owner is ".$prevowner;
  //this means this prog is called from addurbid php , so we need to insert into bidding details and update leagueteamdetails tablea

  $sqlins="insert into BIDDINGDETAILS (playername,leaguename, biddingteam, reserveprice, BIDDINGAMOUNT, ROUNDNUMBER)  values ('$playername', '$leaguename', '$team',$reserveprice,$bid,1) ";
//echo $sqlins . "</br>";
  if(! mysqli_query($conn,$sqlins) )
    {
      die('error sqlinsert');
    }

    $sqlins="insert into tradinginfo (playername,leaguename, teamname, action,actiondt,amount)
     values ('$playername', '$leaguename', '$team','Purchase','$currtime',$bid) ";
  //echo $sqlins . "</br>";
    if(! mysqli_query($conn,$sqlins) )
      {
        die('error sqlinsert2');
      }

  $sqlupdt2="update leagueauctionresults set currenthighestbid=$bid ,ownerteam='$team', bidsoldyn='Y' where leaguename='$leaguename' and playername='$playername' ";
    //echo $sqlins . "</br>";
    if(! mysqli_query($conn,$sqlupdt2) )
      {
        die('error sqlupdate2');
      }
/* commented on apr23 , can be deleted if no problems reported in purchase players
    $sql="select count(*) from leagueauctionresults where leaguename='$leaguename' and ownerteam='$team'";
    $result = sqlsrv_query($conn,$sql) ;
    while( $row = sqlsrv_fetch_array( $result ) )
    {
      $countofplayers=$row[0];
    }
    mysqli_free_result($result);

  $sqlupdt="UPDATE leagueteamsdetails SET Currentbidamount= isnull(Currentbidamount,0)+ $bid , virtualpurchasepower= virtualpurchasepower - $bid, numberofplayers=$countofplayers  WHERE leaguename = '$leaguename' and teamname='$team' ";
      //echo  "in if " . $bid . "and ". $reserveprice . "and " . $sqlupdt . "</br>";
      if(! sqlsrv_query($conn,$sqlupdt) )
        {
          die('error sqlupdate');
        }
*/
}

$numberofplayers=0;
$totalbidamt=0;
$teamvirpp=0;
$numofTrades=0;

$sql2 = "select count(*) from tradinginfo  where leaguename='$leaguename' and teamname='$team'";
$result = mysqli_query($conn,$sql2) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $numofTrades=$row[0];
}
mysqli_free_result($result);

$sql="select count(*) from leagueauctionresults where leaguename='$leaguename' and ownerteam='$team'";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$numberofplayers=$row[0];
}
mysqli_free_result($result);

$sql="select ifnull(sum(currenthighestbid),0) from leagueauctionresults where leaguename='$leaguename' and ownerteam='$team'";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$totalbidamt=$row[0];
	$teamvirpp=15000000-$totalbidamt;
}
mysqli_free_result($result);

$sqlupdt="update leagueteamsdetails set Currentbidamount=$totalbidamt , virtualpurchasepower=$teamvirpp, numberofplayers=$numberofplayers WHERE leaguename = '$leaguename' and teamname='$team' ";
//echo $sqlupdt;
	if(! mysqli_query($conn,$sqlupdt) )
		{
			die('error sqlupdate');
		}
//above 3 sql stmts will make sure data is correct about money and count of players

$sql1="select ifnull(t.virtualpurchasepower,0), ifnull(t.currentbidamount,0) currentbidamount , t.numberofplayers from leagueteamsdetails T where t.teamname= '$team' and t.leaguename='$leaguename' ";
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
<!--SCRIPT LANGUAGE="JAVASCRIPT" SRC="images/sorttable.js"></SCRIPT -->
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>: Cricket : </title>
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

  <? 	if ($biddingstatus =="Closed") {?>
      <h5 align="center" style="margin-bottom:10px;"> Below list shows players which are not owned by any team in your league So they are available for 'individual purchase' OR can be 'auto allocated'(for this you need to talk to your leagues creator)... </h5>
      <h5 align="center" style="margin-bottom:10px; color:red"> Maximum 20 purchases are allowed throughout the time period of the league </h5>
  <? } ;?>
  <?	if ($biddingstatus=="Yet To Start") { ?>
      <H4 align ="center" style="margin-bottom:10px; color:red"> Bidding for your league is not activated yet.. pl contact league Creator.. This page can be used only after bidding is complete </h4>
  <? } ;?>
  <? if ($biddingstatus=="Started-InProgress") { ?>
        <H4 align="center" style="margin-bottom:10px; color:green">Bidding is currently in progress; You wont be able to purchase players from here as yet</H4>
  <? } ;?>

  <? if ($biddingstatus == "Closed") { ?>
      <? if ( $numofTrades >=20 ) {?>
          <h4 align ="center" style="margin-bottom:10px; color:red"> SORRY, you have already done enough(20) trades/purchases ; hence you will not be able to purchase any more players </h4>
      <?} ?>
      <? if ($numofTrades <20) {?>
          <h4 align ="center" style="margin-bottom:10px; color:green"> You have done <? echo $numofTrades; ?> trades/purchase so far; so you sure can do one more </h4>
      <?} ?>
  <? } ?>
  <div class="clearfix"></div>
      <div class="rows">
          <div class="">
          <div class="col-md-offset-3 col-md-3 agile-validation agile_info_shadow text-center" style="background-color: crimson; color: white;">
              Virtual Purchase Power :
              <hr>
              Current Bid Amount Total :
          </div>
          <div class="col-md-3 text-center agile-validation agile_info_shadow" style="background-color: crimson;color: white;">
                  <? echo $virtualpurchasepower ?>
              <hr>
                  <? echo $currentbidamount ?>
          </div>
      </div>
  </div>
  <div class="clearfix"></div>
  </div>

    <div class="inner_content_w3_agile_info two_in" style="margin-top: 0px;">
        <!-- <h2 class="w3_inner_tittle">Team Home Page</h2> -->
        <!-- tables -->
        <div class="agile-tables">
            <div class="w3l-table-info agile_info_shadow">
                <h3 class="w3_inner_tittle two">Player Purchase After Bidding Over</h3>
                <table id="table">
                  <form name="frmcricket" action="PlayersListForBidding.php" method="post">

                    <thead>
                        <tr>
    <th>Sr.No</th>
    <th>Player Name</th>
    <th>Speciality</th>
    <th>IPL Team</th>
    <th >Reserve  Price</th>
    <th>Current higest Bid</th>
    <th>Highest Bidder </th>
    <th>Purchase</th>
  </tr>

<!-- entire while loop to show all rows -->
  </thead>
  <tbody>
<?

$i=1;
$sql="select x.playername,x.iplteam,x.speciality, x.reserveprice,ifnull(t.currenthighestbid,x.reserveprice)currenthighestbid, t.ownerteam from LEAGUEAUCTIONRESULTS T, PLAYERMST X where t.playername = x.playername and (ifnull(t.leaguename,'X')='$leaguename'  or t.leaguename is null)  and ifnull(t.bidsoldyn,'N')='N' ";
//echo $sql . "<br/>";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
//echo "Values are " . $row[0] ." and ". $row[1]." and ". $row[2]." and ". $row[3]." and ". $row[4]." and ". $row[5] . "<br\>";
?>
<tr class="header1">
 <td align="center"><? echo $i ?></td>
 <td><? echo $row[0] ?></td>
 <td><? echo $row[1] ?></td>
 <td><? echo $row[2] ?></td>
 <td > <? echo $row[3] ?></td>
 <td ><input type="text" value="<? echo $row[4]; ?>" name="currbid" size="15" readonly="true"></td>
 <td ><? echo $row[5] ?></td>
   <? if ($biddingstatus=="Closed") { ?>
     <? if($numofTrades <20) { ?>
     <td><a href="PlayerPurchase2.php?nm=<? echo $row[0] ?>" onClick="return valid();"><strong>Purchase</strong> </a>  </td>
    <? } ?>
 <? } ?>
   <? if ($biddingstatus!=="Closed") { ?>
     <td><a href="#" ><strong>Purchase</strong> </a>  </td>
   <? } ?>
</tr>
<? $i++; }  ?>


<input type="hidden" name='numberofplayers' value="<? echo $numberofplayers ?>" >
<input type="hidden" name='nm' value="" >
</form>
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
            window.onload = function() {

	  el = document.getElementsByTagName('html')[0];
		el.style.overflow = "scroll";

	};
        </script>

        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/scripts.js"></script>

        <script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>


</body>

</html>

<script language="javascript">
function valid(id)
  {

    if(parseInt(document.frmcricket.numberofplayers.value) >=22 )
    {
       alert("Sorry you already have enough players in your rooster, you may not bid more at this time.");
       //document.frmcricket.currbid.focus();
       return false;
    }
    else
    {
      //alert(id);
    window.document.frmcricket.target = "_self";
    window.document.frmcricket.action = 'PlayerPurchase2.php';
    document.all("nm").value	= id;
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
