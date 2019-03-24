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
  <title>: Cricket : </title>

  </head>
  <body >
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
                                <a href="teamLandingPg.php" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-home"></i></a>
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
  		<h4 align="center" style="margin-bottom:10px;"> Bidding IS OVER For This League , Pl check your players page.  </h4>
      <h5 align="center" style="margin-bottom:10px;"> Below list shows players which are not owned by any team in your league So they are available for 'individual purchase' OR can be 'auto allocated'(for this you need to talk to your leagues creator)... </h5>
  <? } ;?>
  <?	if ($biddingstatus=="Yet To Start") { ?>
  		<H4 align ="center" style="margin-bottom:10px;"> Bidding for your league is not activated yet.. pl contact league Creator..  </h4>
  <? } ;?>
  <? if ($biddingstatus=="Started-InProgress") { ?>
  	    <H4 align="center" style="margin-bottom:10px;">Happy Bidding </H4>
  <? } ;?>

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
            <h3 class="w3_inner_tittle two">Players list for bidding</h3>

            <table id="table" >
              <form name="frmcricket" action="PlayersListForBidding.php" method="post">

                <thead>
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
                <tbody ><!-- entire while loop to show all rows -->

  <!-- entire while loop to show all rows -->
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
   <td align="center"><? echo $i ?></td>
   <td><? echo $row[0] ?></td>
   <td><? echo $row[1] ?></td>
   <td><? echo $row[2] ?></td>
   <td > <? echo $row[3] ?></td>
   <td ><input type="text" value="<? echo $row[4]; ?>" name="currbid" size="15" readonly="true"></td>
   <td ><? echo $row[5] ?></td>
  <? if ($biddingstatus == "Started-InProgress" ) { ?>
      <td><a href="addurbid.php?nm=<? echo $row[0] ?>" onClick="return valid();"><strong>Your bid</strong> </a>  </td>
    <? } ?>
  <? $i++; }  ?>


  <input type="hidden" name='numberofplayers' value="<? echo $numberofplayers ?>" >
  <input type="hidden" name='nm' value="" >
</tbody>
</form>
</table>
</div>


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

<!--        <script src="NewUI/js/jquery.nicescroll.js"></script> -->
        <script src="NewUI/js/scripts.js"></script>

        <script type="text/javascript" src="NewUI/js/bootstrap-3.1.1.min.js"></script>


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
  		window.document.frmcricket.action = 'addurbid.php';
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
