#!/usr/bin/php
<?
//if ($_SERVER['REQUEST_METHOD'] === 'POST')
  //  {
        //Ok we got a POST, probably from a FORM, read from $_POST.
        //var_dump($_POST); //Use this to see what info we got!
        session_start();
        $_SESSION['username']=$_POST['username'];
        $_SESSION['pwd']=$_POST['pass'];
        $_SESSION['leaguename']=$_POST['leaguename'];
  //  }
  //  else
  //  {
       //You could assume you got a GET
  //     var_dump($_GET); //Use this to see what info we got!
  //	}

    $username=$_SESSION['username'];
    $pwd=$_SESSION['pwd'];
    $leaguename=$_SESSION['leaguename'];
    $isPresent=0;
//echo $username . " " .$pwd . " " .$leaguename. "</br>";
/* need ot add code for checking / validing pwd here  */

$serverName = "sg1-wsq1.a2hosting.com";
$connectionInfo = array( "Database"=>"fantas10_mssql", "UID"=>"fantas10_avad", "PWD"=>"FLeague@2018");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

$sql="SELECT teamname,teamownername  FROM LEAGUETEAMSDETAILS WHERE leaguename= '$leaguename' and TEAMOWNEREMAIL='$username' AND TEAM_PASSWORD ='$pwd' ";
//echo $sql ;

//if(! sqlsrv_query($conn,$sql) {
//  echo "here before" ;
//  die('error sql');
//}

$result = sqlsrv_query($conn,$sql) ;
while( $row = sqlsrv_fetch_array( $result ) )
{
  //echo " here" ;
  $teamname=$row[0];
  $teamownername=$row[1];
  $_SESSION['teamname']=$teamname;
  $_SESSION['teamownername']=$teamownername;
  $isPresent=1;
}
sqlsrv_free_stmt($result);

if ($isPresent ==1) {

  date_default_timezone_set('Asia/Kolkata');
  $today=date("z");
  $startofIPL = 96; // ipl started on 4th apr so 96th day of the year
  $iplday = ($today-$startofIPL)+1;
  $_SESSION['iplday']=$iplday;

  echo '<script type="text/javascript">
             window.location = "./teamLandingPg.php"
        </script>';
}

if ($isPresent ==0){
  echo "something  is wrong, either username, password or leaguename "; // need to fix this
  echo '<script language=javascript">';
  echo  'alert("sorry username or password or leaguename is not correct")';
  echo ' window.location = "./LoginPg.php" ';
  echo ' </script>';
}
?>
