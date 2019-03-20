<?
// this prog will just update the league rules , as its called from leagurrules.php

session_start();
$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$pass=$_SESSION['pwd'];
$teamname=$_SESSION['teamname'];
$teamownername=$_SESSION['teamownername'];

include "dbConnect.php";
global $conn;

//$serverName = "sg1-wsq1.a2hosting.com";
//$connectionInfo = array( "Database"=>"fantas10_mssql", "UID"=>"fantas10_avad", "PWD"=>"FLeague@2018");
//$conn = sqlsrv_connect( $serverName, $connectionInfo);

$maxteams=$_POST['maxteams'];
$maxtrades=$_POST['maxtrades'];
$ppower=$_POST['purchasepower'];
$runpoints=$_POST['runpoints'];
$wpoints=$_POST['wicketpoints'];
$bpoints=$_POST['boundrypoints'];
$spoints=$_POST['sixpoints'];
$cpoints=$_POST['catchpoints'];
$runoutpoints=$_POST['runoutpoints'];
$mpoints=$_POST['maidenpoints'];
$fivepoints=$_POST['fivewicketpoints'];
$hatrikpoints=$_POST['hatrikpoints'];
$biddingstatus=$_POST['D1'];

$sql="update leaguerules set  maxteams=$maxteams ,maxtrades=$maxtrades,runpoints=$runpoints,catchpoints=$cpoints, wicketpoints=$wpoints, runoutpoints=$runoutpoints, maidenoverpoints=$mpoints, boundrypoints=$bpoints, sixpoints=$spoints, purchasepower=$ppower, biddingstatus='$biddingstatus', fivewicketinmatch=$fivepoints, hatrik=$hatrikpoints where leaguename='$leaguename'";
echo $sql;
if(!mysqli_query($conn,$sql) )
  {
    die('error sqlupdate');
  }

  echo '<script type="text/javascript">
             window.location = "./teamLandingPg.php"
        </script>';
?>
