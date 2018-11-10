<?
    session_start();
      $username=$_SESSION['username'];
      $team=$_SESSION['teamname'];
      $teamowner = $_SESSION['username'];
      $leaguename= $_SESSION['leaguename'];

//  echo "all session " . $username . " and team " . $team . " and owner " . $teamowner . " and league ". $leaguename . "<br/>";
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

    $sqlins="insert into BIDDINGDETAILS (playername,leaguename, biddingteam, reserveprice, BIDDINGAMOUNT, ROUNDNUMBER)  values ('$playername', '$leaguename', '$team',$reserveprice,$bid,1) ";
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
  <html>
  <head>
  
  <!--SCRIPT LANGUAGE="JAVASCRIPT" SRC="images/sorttable.js"></SCRIPT -->
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>: Cricket : </title>

  </head>
  <body >
  <table width="950" border="0" cellspacing="0" cellpadding="0" align="Center">
  	<tr>
  		<td align="center" height=90>
  			<span style="font-size: 15pt;color:#DDDDDD">Welcome to the Fantasy Cricket league </span>
  					 </td>
  				</tr>
  </table>

  <? 	if ($biddingstatus =="Closed") {?>
  		<h4 align="center"> Bidding IS OVER For This League , Pl check your players page.  </h4>
      <h5 align="center"> Below list shows players which are not owned by any team in your league So they are available for 'individual purchase' OR can be 'auto allocated'(for this you need to talk to your leagues creator)... </h5>
  <? } ;?>
  <?	if ($biddingstatus=="Yet To Start") { ?>
  		<H4 align ="center"> Bidding for your league is not activated yet.. pl contact league Creator..  </h3>
  <? } ;?>
  <? if ($biddingstatus=="Started-InProgress") { ?>
  	    <H4 align="center">Happy Bidding </H2>
  <? } ;?>

  <table width="950" border="0" class="text" cellspacing="0" cellpadding="0" align="Center">
  		<tr>
  		<td height="30" align="center" class="text" ></td>
  		<td  align="center" class="text"></td>
  	</tr>

  	<tr>
  		<!-- <td width="40%" align="center" class="text"><a href="teamplayerdetails.asp"><b>Team Players Information</b></a></td> -->
  		<td width="40%" align="center" class="text"><a href="teamLandingPg.php"><b>Main Team Page</b></a></td>
  	</tr>
  	<tr>
  		<td height="30" align="center" class="text" ></td>
  		<td  align="center" class="text"></td>
  	</tr>
  </table>
  <!-- nneed to show league name , team name in same tablea as purchase power -->
  	<table width="950" border="0" align="center">
      <tr>
      		<td width="353">
  				<table  width="347" border="1" align="center" bordercolor="#00FFFF" bgcolor="#CCFF00" class="pagenav" >
  				  <tr>
  					       <td width="218"><h4 align="center">Virtual Purchase Power :</h4></td>
  					       <td width="128"><div align="right"><font face="Tahoma, Geneva, sans-serif" size="2"><? echo $virtualpurchasepower ?> </div></td>
  				  </tr>
  				  <tr>
  					       <td><h4 align="center">Current Bid Amount Total :</h4></td>
  					       <td><div align="right"><font face="Tahoma, Geneva, sans-serif" size="2"><? echo $currentbidamount ?> </div></td>
  				  </tr>
  			</table>
  		</td>
  	  </tr>
  	</table>

  <table border="1" width="65%" ALIGN="center" class="header3" cellspacing="1" cellpadding="1" bordercolor="#FFFFCC">
  <form name="frmcricket" action="PlayersListForBidding.php" method="post">
  	<tr height="20" class="header4" bgcolor="#FFFFCC">
  		<td align="center" class="Header1">Sr.No</td>
  		<td class="Header1">Player Name</td>
  		<td class="Header1">Speciality</td>
  		<td class="Header1">IPL Team</td>
  		<td align="center" >Reserve  Price</td>
  		<td align="center" >Current highest Bid</td>
  		<td class="Header1">Highest Bidder </td>
  		<td class="Header1">Your bid</td>
  	</tr>

  <!-- entire while loop to show all rows -->

  <?

  $i=1;
  $sql="select x.playername,x.iplteam,x.speciality, x.reserveprice,ifnull(t.currenthighestbid,x.reserveprice)currenthighestbid, t.ownerteam from LEAGUEAUCTIONRESULTS T, PLAYERMST X where t.playername = x.playername and (ifnull(t.leaguename,'X')='$leaguename'  or t.leaguename is null)   ";
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
   <td align="right"> <? echo $row[3] ?></td>
   <td align="right"><input type="text" value="<? echo $row[4]; ?>" name="currbid" size="15" readonly="true"></td>
   <td align="right"><? echo $row[5] ?></td>
  <? if ($biddingstatus == "Started-InProgress" ) { ?>
      <td><a href="addurbid.php?nm=<? echo $row[0] ?>" onClick="return valid();"><strong>Your bid</strong> </a>  </td>
    <? } ?>
  <? $i++; }  ?>


  <input type="hidden" name='numberofplayers' value="<? echo $numberofplayers ?>" >
  <input type="hidden" name='nm' value="" >
  </form>
  </table>
  <table width="950" align="center">
  <tr>
  		<td >
  			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="Center">
  				<tr>
  					<td align="left" height="30"></td>
  				</tr>
  			</table>
  		</td>
  	</tr>
  		<tr><td align="Right" class="text">&copy 2011 All Rights Reserved.</td></tr>
  </table>
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
