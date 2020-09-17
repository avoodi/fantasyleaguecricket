#!/usr/bin/php
<?
include "dbConnect.php";
global $conn;
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

/*
$servername = "103.21.58.5";
$dbusername = "fantay5h_avad";
$dbpassword = "FLeague@2019";
$dbname="fantay5h_avad";
*/
// Create connection
//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql="SELECT teamname,teamownername  FROM leagueteamsdetails WHERE leaguename= '$leaguename' and TEAMOWNEREMAIL='$username' AND TEAM_PASSWORD ='$pwd' ";
//echo $sql ;

$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
//  echo " here in fetch" ;
  $teamname=$row[0];
  $teamownername=$row[1];
  $_SESSION['teamname']=$teamname;
  $_SESSION['teamownername']=$teamownername;
  $isPresent=1;
}

if ($isPresent ==1) {
  date_default_timezone_set('Asia/Kolkata');
  $today=date("z");
  $startofIPL = 263; // ipl started on 4th apr so 96th day of the year
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
mysqli_free_result($result);

?>
