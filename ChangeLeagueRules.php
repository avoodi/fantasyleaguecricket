<?
// this prog will just update the league rules , as its called from leagurrules.php

session_start();
$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$pass=$_SESSION['pass'];
$teamname=$_SESSION['teamname'];
$teamownername=$_SESSION['teamownername'];

$serverName = "sg1-wsq1.a2hosting.com";
$connectionInfo = array( "Database"=>"fantas10_mssql", "UID"=>"fantas10_avad", "PWD"=>"FLeague@2018");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

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

$sql="update leaguerules set  MAXTEAMS=$maxteams ,MAXTRADES=$maxtrades,RUNPOINTS=$runpoints,CATCHPOINTS=$cpoints, WICKETPOINTS=$wpoints, RUNOUTPOINTS=$runoutpoints,MAIDENOVERPOINTS=$mpoints, BOUNDRYPOINTS=$bpoints, SIXERPOINTS=$spoints,PURCHASEPOWER=$ppower,BIDDINGSTATUS='$biddingstatus', FiveWicketInMatch=$fivepoints,Hatrik=$hatrikpoints where leaguename='$leaguename'";
echo $sql;
if(! sqlsrv_query($conn,$sql) )
  {
    die('error sqlupdate');
  }

  echo '<script type="text/javascript">
             window.location = "./teamLandingPg.php"
        </script>';

?>
